<?php

namespace App\Filament\Resources;

use App\{
    Exports\FilmSchedules,
    Filament\Resources\PublishingScheduleResource\Pages,
    Jobs\UploadVideoToVimeo,
    Models\CreatorProfile,
    Models\CreatorProposal,
    Models\FilmTopic,
    Models\PublishingSchedule,
    Models\SponsorProfile
};
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\{Forms\Components\Card,
    Forms\Components\DatePicker,
    Forms\Components\DateTimePicker,
    Forms\Components\Select,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Form,
    Forms\Get,
    Forms\Set,
    Infolists\Components\Section,
    Infolists\Components\TextEntry,
    Notifications\Notification,
    Resources\Resource,
    Support\Enums\ActionSize,
    Tables,
    Tables\Actions\ActionGroup,
    Tables\Columns\TextColumn,
    Tables\Enums\FiltersLayout,
    Tables\Filters\Filter,
    Tables\Filters\SelectFilter,
    Tables\Table};
use Illuminate\{Database\Eloquent\Builder,
    Database\Eloquent\Model,
    Database\Eloquent\SoftDeletingScope,
    Support\Carbon,
    Support\Str};
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function auth;
use function dispatch_sync;

class PublishingScheduleResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = PublishingSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-s-clock';

    protected static ?string $modelLabel = 'Film Schedules';

    protected static ?int $navigationSort = 3;


//    public static function canEdit(Model $record): bool
//    {
//        return auth()->user()->can('update_publishing::schedule');
//    }

    #[\Override]
    public static function canAccess(): bool
    {
        return boolval(auth()->user()->approved);
    }

    public static function canCreate(): bool
    {

        return auth()->user()->can('create_publishing::schedule');
    }

    public static function canDelete(Model $model): bool
    {
        return auth()->user()->can('delete_publishing::schedule');
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'upload_to_vimeo'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
                        ->disabled(!auth()->user()->can('update_publishing::schedule'))
                        ->schema([
                            Card::make()->schema([
                                Select::make('proposal_id')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $film_project = CreatorProposal::whereId($state)->first();
                                        if (!$film_project) {
                                            return null;
                                        }

                                        $set('film_title', $film_project->working_title);
                                        $set('synopsis', $film_project->synopsis);
                                        $set('creator_id', $film_project->user_id);
                                        $set('sponsor_id', $film_project->sponsored_by);
                                        $set('topics', explode(',', $film_project->topics));
                                        $set('film_type', $film_project->film_type);
                                        $set('premium_film_price', $film_project->premium_film_price);
                                    })
                                    ->label('Select Film')
                                    ->options(CreatorProposal::all()->pluck('working_title', 'id'))
                                    ->columnSpan(5)
                                    ->nullable(),
//                            --
                                DateTimePicker::make('release_date')
                                    ->label('Premier On')
                                    ->columnSpan(3)
                                    ->nullable(),
//                                --
                                TextInput::make('film_title')
                                    ->columnSpan(4)
                                    ->required(),
                                TagsInput::make('topics')
                                    ->separator(',')
                                    ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                    ->label('Topics (Select All Related Topics)')
                                    ->columnSpan(4)
                                    ->nullable(),
//                                --
                                Textarea::make('synopsis')->label('Synopsis')->columnSpanFull()->nullable(),
                                Select::make('film_type')
                                    ->label('Film Type')
                                    ->options([
                                        'free' => 'Free',
                                        'premium' => 'Premium',
                                    ])
                                    ->columnSpan(4)
                                    ->nullable(),
//                                --
                                TextInput::make('premium_film_price')
                                    ->disabled(fn(Get $get) => $get('film_type') == 'free')
                                    ->label('Premium Film Price')
                                    ->type('number')
                                    ->columnSpan(4)
                                    ->nullable(),
//                                --
                                Select::make('creator_id')
                                    ->label('Created By')
                                    ->required()
                                    ->options(CreatorProfile::all()->pluck('name', 'user_id'))
                                    ->columnSpan(4)
                                    ->nullable(),
//                                --
                                Select::make('sponsor_id')
                                    ->label('Sponsored By')
                                    ->options(SponsorProfile::all()->pluck('organization_name', 'user_id'))
                                    ->columnSpan(4)
                                    ->nullable(),
                                TextInput::make('call_to_action_text')
                                    ->columnSpan(4)
                                    ->label('Call to action button text')
                                    ->nullable(),
//                                --
                                TextInput::make('call_to_action_link')
                                    ->url()
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->columnSpan(4)
                                    ->label('Call to Action URL')
                                    ->nullable(),
                            ])->columns(8),
//                            --
                        ])->statePath('data');
    }

    public static function tableActions()
    {
        return [
            ActionGroup::make([
                Tables\Actions\EditAction::make()
                    ->visible(auth()->user()->can('update_publishing::schedule')),
                Tables\Actions\ViewAction::make()
                    ->infolist([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('film_title'),
                                TextEntry::make('release_date'),
                                TextEntry::make('film_type'),
                                TextEntry::make('sponsor.organization_name'),
                                TextEntry::make('creator.name'),
                                TextEntry::make('synopsis'),
                            ])
                    ])
                    ->fillForm(function (PublishingSchedule $schedule) {
                        $data = $schedule->toArray();

                        return $data;
                    }),
                Tables\Actions\Action::make('upload_hd_to_vimeo')
                    ->visible(auth()->user()->can('upload_to_vimeo_publishing::schedule'))
                    ->requiresConfirmation(function (PublishingSchedule $schedule) {
                        return $schedule->proposal->vimeo_link != null;
                    })
                    ->icon('heroicon-m-arrow-up-tray')
                    ->label('Upload HD Video to Vimeo')
                    ->modalHeading('Overwrite Video')
                    ->modalDescription('This schedule has a HD Video on vimeo. Do you want ot overwrite it?')
                    ->action(function (PublishingSchedule $schedule): void {
                        //$job = (new UploadVideoToVimeo($schedule->proposal));
                        //dispatch_sync($job);
                        UploadVideoToVimeo::dispatch($schedule->proposal, 'videos');

                        Notification::make()
                            ->title('upload has been queued')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('upload_trailer_to_vimeo')
                    ->visible(auth()->user()->can('upload_to_vimeo_publishing::schedule'))
                    ->requiresConfirmation(function (PublishingSchedule $schedule) {
                        $proposal = $schedule->proposal;
                        /* @var $media Media */
                        $media = $proposal->getMedia('trailers')->last();
                        $vimeo_link = $media?->getCustomProperty('vimeo_link');
                        return !empty($vimeo_link);
                    })
                    ->icon('heroicon-m-arrow-up-tray')
                    ->label('Upload Trailer to Vimeo')
                    ->modalHeading('Overwrite Trailer')
                    ->modalDescription('This schedule has a trailer on vimeo. Do you want ot overwrite it?')
                    ->action(function (PublishingSchedule $schedule): void {
                        UploadVideoToVimeo::dispatch($schedule->proposal, 'trailers');

                        Notification::make()
                            ->title('upload has been queued')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(),
        ];
    }

    public static function table(Table $table): Table
    {
        $query = PublishingSchedule::with(['sponsor', 'creator', 'proposal']);

        if (auth()->user()->hasRole('creator')) {
            $query = $query->whereHas('creator', fn($q) => $q->where('user_id', auth()->id()));
        }
        if (auth()->user()->hasRole('sponsor')) {
            $query = $query->whereHas('sponsor', fn($q) => $q->where('user_id', auth()->id()));
        }

        $query->orderBy('id', 'desc');

        return $table->query($query)
            ->headerActions([
                Tables\Actions\Action::make('Export')
                ->action(function () {
                    $f_name = Str::snake('f_schedules_' . Carbon::now()->format('d-m-Y H:i:s') . '.csv');
                    return Excel::download(new FilmSchedules(), $f_name);
                })
            ])
            ->columns([
                TextColumn::make('film_title')->searchable(),
                TextColumn::make('slug'),
                TextColumn::make('updated_at')->date()->label('Last Updated'),
                TextColumn::make('release_date')->sortable()->date(),
                TextColumn::make('film_type'),
                TextColumn::make('sponsor.organization_name')->searchable(),
                TextColumn::make('creator.name'),
            ])
            ->recordUrl(function () {
                if (!auth()->user()->can('update_publishing::schedule')) {
                    return null;
                }
            })
            ->filters([
                SelectFilter::make('sponsor_id')
                    ->searchable()
                    ->preload()
                    ->label('Sponsor')
                    ->relationship('sponsor', 'organization_name'),
                SelectFilter::make('film_type')
                    ->options(['free' => 'free', 'premium' => 'premium'])
                    ->label('Film Type'),
                Filter::make('release_date')
                    ->form([
                        DatePicker::make('release_from')->label('From'),
                        DatePicker::make('release_until')->label('To'),
                    ])
                    ->columns(2)
                    ->columnSpan(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                        ->when(
                                $data['release_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('release_date', '>=', $date),
                        )
                        ->when(
                                $data['release_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('release_date', '<=', $date),
                        );
                    }),
                Tables\Filters\TrashedFilter::make(),
                    ], layout: FiltersLayout::AboveContent)->filtersFormColumns(4)
            ->actions(static::tableActions())
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
                //Tables\Actions\ForceDeleteBulkAction::make(),
                //Tables\Actions\RestoreBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
                //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublishingSchedules::route('/'),
            'create' => Pages\CreatePublishingSchedule::route('/create'),
            'edit' => Pages\EditPublishingSchedule::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user_can_view = auth()->user()->can('view_publishing::schedule') && auth()->user()->can('view_any_publishing::schedule');

        if ($user_can_view) {
            return true;
        }
        return false;
    }
}
