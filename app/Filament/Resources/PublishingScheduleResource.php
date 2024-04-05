<?php

namespace App\Filament\Resources;

use App\{
    Filament\Resources\PublishingScheduleResource\Pages,
    Jobs\UploadVideoToVimeo,
    Models\CreatorProfile,
    Models\CreatorProposal,
    Models\FilmTopic,
    Models\PublishingSchedule,
    Models\SponsorProfile
};
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\{
    Forms\Components\Card,
    Forms\Components\DateTimePicker,
    Forms\Components\Select,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Form,
    Notifications\Notification,
    Resources\Resource,
    Tables,
    Tables\Columns\TextColumn,
    Tables\Table
};
use Illuminate\Database\Eloquent\Model;
use function auth;
use function dispatch_sync;

class PublishingScheduleResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = PublishingSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-s-clock';

    protected static ?string $modelLabel = 'Film Schedules';


//    public static function canEdit(Model $record): bool
//    {
//        return auth()->user()->can('update_publishing::schedule');
//    }



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
                                ->label('Select Film')
                                ->options(
                                        CreatorProposal::all()->pluck('working_title', 'id')
                                )->live()
                                ->columnSpan(5)
                                ->nullable(),
//                            --
                                DateTimePicker::make('release_date')
                                ->label('Premier On')
                                ->columnSpan(3)->nullable(),
//                                --
                                TextInput::make('film_title')
                                ->columnSpan(4)
                                ->required(),
                                TagsInput::make('topics')
                                ->separator(',')
                                ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                ->label('Topics (Select All Related Topics)')->columnSpan(4)->nullable(),
//                                --
                                Textarea::make('synopsis')->label('Synopsis')->columnSpanFull()->nullable(),
                                Select::make('film_type')->label('Film Type')->options([
                                    'free' => 'Free',
                                    'premium' => 'Premium',
                                ])->columnSpan(4)->nullable(),
//                                --
                                TextInput::make('premium_film_price')->label('Premium Film Price')->type('number')->columnSpan(4)->nullable(),
//                                --
                                Select::make('creator_id')
                                ->label('Created By')
                                ->options(
                                        CreatorProfile::all()->pluck('name', 'user_id')
                                )->columnSpan(4)->nullable(),
//                                --
                                Select::make('sponsor_id')
                                ->label('Sponsored By')
                                ->options(
                                        SponsorProfile::all()->pluck('organization_name', 'user_id')
                                )->columnSpan(4)->nullable(),
                                TextInput::make('call_to_action_text')
                                ->columnSpan(4)
                                ->label('Call to action button text')->nullable(),
//                                --
                                TextInput::make('call_to_action_link')
                                ->url()
                                ->suffixIcon('heroicon-m-globe-alt')
                                ->columnSpan(4)
                                ->label('Call to Action URL')->nullable(),
                            ])->columns(8),
//                            --
                        ])->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
                        ->columns([
                            TextColumn::make('film_title'),
                            TextColumn::make('release_date')
                            ->date(),
                            TextColumn::make('film_type.genre_name'),
                            TextColumn::make('sponsor.organization_name'),
                            TextColumn::make('creator.name'),
                        ])
                        ->recordUrl(function () {
                            if (!auth()->user()->can('update_publishing::schedule')) {
                                return null;
                            }
                           
                        })
                        ->filters([
                                //
                        ])
                        ->actions([
                            Tables\Actions\EditAction::make()
                            ->visible(auth()->user()->can('update_publishing::schedule')),
                            Tables\Actions\ViewAction::make()
                            ->fillForm(function (PublishingSchedule $schedule) {
                                $data = $schedule->toArray();

                                return $data;
                            })->form([
                                TextInput::make('film_title')
                                ->required()
                                ->maxLength(255),
                                DateTimePicker::make('release_date')
                                ->label('Premier On'),
                                Textarea::make('synopsis')->label('Synopsis')->columnSpanFull()->nullable()
                            ]),
                            Tables\Actions\Action::make('upload_to_vimeo')
                            ->visible(auth()->user()->can('upload_to_vimeo_publishing::schedule'))
                            ->requiresConfirmation(function (PublishingSchedule $schedule) {
                                return $schedule->proposal->vimeo_link != null;
                            })
                            ->modalHeading('Overwrite Video')
                            ->modalDescription('This schedule has a video on vimeo. Do you want ot overwrite it?')
                            ->action(function (PublishingSchedule $schedule): void {
                                $job = (new UploadVideoToVimeo($schedule->proposal));
                                dispatch_sync($job);

                                Notification::make()
                                ->title('upload has been queued')
                                ->success()
                                ->send();
                            })
                        ])
                        ->bulkActions([
        ]);
    }

    public static function getRelations(): array
    {
        return [
                //
        ];
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
