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
    Forms\Concerns\InteractsWithForms,
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
    Tables\Columns\CheckboxColumn,
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
    use InteractsWithForms;

    //public array $data = [];

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

    public function mount(): void
    {

    }

    public static function form(Form $form): Form
    {
        $proposal_id = request('proposal_id');
        $film_project_data = [];
        if ($proposal_id) {
            $film_project = CreatorProposal::whereId($proposal_id)->with(['sponsor'])->first();

            $film_project_data['proposal_id'] = $proposal_id;
            $film_project_data['film_title'] = $film_project->working_title;
            $film_project_data['synopsis'] = $film_project->synopsis;
            $film_project_data['creator_id'] = $film_project->creator_id;
            $film_project_data['sponsor_id'] = $film_project->sponsored_by;
            $film_project_data['topics'] = explode(',', $film_project->topics);
            $film_project_data['film_type'] = $film_project->film_type;
            $film_project_data['premium_film_price'] = $film_project->premium_film_price;
            $film_project_data['call_to_action_text'] = $film_project->sponsor?->default_cta_text;
            $film_project_data['call_to_action_link'] = $film_project->sponsor?->default_cta_link;
        }

        return $form
                        ->disabled(!auth()->user()->can('update_publishing::schedule'))
                        ->schema([
                            Card::make()->schema([
                                Select::make('proposal_id')
                                    ->live()
                                    ->default($film_project_data['proposal_id'] ?? null)
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
                                    ->options(CreatorProposal::unpublished()->get()->pluck('working_title', 'id'))
                                    ->columnSpan(5)
                                    ->required(),
//                            --
                                DateTimePicker::make('release_date')
                                    ->label('Premier On')
                                    ->columnSpan(3)
                                    ->required(),
//                                --
                                TextInput::make('film_title')
                                    ->columnSpan(4)
                                    ->default($film_project_data['film_title'] ?? null)
                                    ->required(),
                                TagsInput::make('topics')
                                    ->separator(',')
                                    ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                    ->label('Topics (Select All Related Topics)')
                                    ->default($film_project_data['topics'] ?? null)
                                    ->columnSpan(4)
                                    ->nullable(),
//                                --
                                Textarea::make('synopsis')
                                    ->label('Synopsis')
                                    ->default($film_project_data['synopsis'] ?? null)
                                    ->columnSpanFull()
                                    ->nullable(),
                                Select::make('film_type')
                                    ->label('Film Type')
                                    ->options([
                                        'free' => 'Free',
                                        'premium' => 'Premium',
                                    ])
                                    ->default($film_project_data['film_type'] ?? null)
                                    ->columnSpan(4)
                                    ->nullable(),
//                                --
                                TextInput::make('premium_film_price')
                                    ->disabled(fn(Get $get) => $get('film_type') == 'free')
                                    ->label('Premium Film Price')
                                    ->default($film_project_data['premium_film_price'] ?? null)
                                    ->type('number')
                                    ->columnSpan(4)
                                    ->nullable(),
//                                --
                                Select::make('creator_id')
                                    ->label('Creator')
                                    ->default($film_project_data['creator_id'] ?? null)
                                    ->required()
                                    ->options(CreatorProfile::all()->pluck('name', 'user_id'))
                                    ->columnSpan(4)
                                    ->required(),
//                                --
                                Select::make('sponsor_id')
                                    ->label('Sponsored By')
                                    ->default($film_project_data['sponsor_id'] ?? null)
                                    ->options(SponsorProfile::all()->pluck('organization_name', 'user_id'))
                                    ->columnSpan(4)
                                    ->required(),
                                TextInput::make('call_to_action_text')
                                    ->columnSpan(4)
                                    ->label('Call to action button text')
                                    ->default($film_project_data['call_to_action_text'] ?? null)
                                    ->nullable(),
//                                --
                                TextInput::make('call_to_action_link')
                                    ->url()
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->columnSpan(4)
                                    ->label('Call to Action URL')
                                    ->default($film_project_data['call_to_action_link'] ?? null)
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
        $admins_only = auth()->user()->hasRole(['admin', 'super_admin']);

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
                CheckboxColumn::make('is_featured')->sortable()
                    ->label('Is Featured')
                    ->beforeStateUpdated(function (Model $record) {

                    })
                    ->afterStateUpdated(function (Model $record) {
                        $msg = '';
                        if ($record->is_featured) {
                            $msg = 'Video added to Featured Videos';
                            $record->featured_at = Carbon::now();
                            $record->save();
                        }
                        else {
                            $msg = 'Video removed from Featured Videos';
                            $record->featured_at = null;
                            $record->save();
                        }
                        Notification::make()->title($msg)->success()->send();
                    }),
                TextColumn::make('featured_at')->sortable()->dateTime(),
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
                    ->visible(function () use ($admins_only) {
                        return $admins_only;
                    })
                    ->searchable()
                    ->preload()
                    ->label('Sponsor')
                    ->relationship('sponsor', 'organization_name'),
                SelectFilter::make('film_type')
                    ->options(['free' => 'free', 'premium' => 'premium'])
                    ->label('Film Type'),
                Filter::make('release_date')
                    ->form([
                        DatePicker::make('release_from')->label('Release Date From'),
                        DatePicker::make('release_until')->label('Release Date To'),
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
                Filter::make('is_featured')
                    ->label('Featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),
                Tables\Filters\TrashedFilter::make()
                    ->visible(function () use ($admins_only) {
                        return $admins_only;
                    }),
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
