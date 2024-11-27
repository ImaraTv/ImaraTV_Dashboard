<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-m-calendar-days';

    protected static ?int $navigationSort = 6;

    public static function canAccess(): bool
    {
        return boolval(auth()->user()->approved);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole(['admin', 'super_admin']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->columnSpan(1)
                    ->options(Event::statusOptions()),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('poster')
                    ->label('Event Poster')
                    ->collection('event_posters')
                    ->acceptedFileTypes(['image/*'])
                    ->maxSize(100000)
                    ->columnSpan(1)->nullable(),
                Forms\Components\TextInput::make('link')
                    ->maxLength(255)->hint('Link to Twitter, Facebook, Zoom, Google Meet etc'),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Start Date and Time')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('End Date and Time')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $admins_only = auth()->user()->hasRole(['admin', 'super_admin']);

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('poster')
                    ->searchable(false)
                    ->width(100)
                    ->height(100)
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->checkFileExistence(false)
                    ->defaultImageUrl(function (Event $model) {
                        /* @var $media Media */
                        $media = $model->getMedia('event_posters')->last();
                        return $media?->getFullUrl();
                    }),
                Tables\Columns\TextColumn::make('link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions(
                ActionGroup::make([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('publishEvent')
                    ->action(function (Event $record) {
                        $saved = $record->publishEvent();

                        if ($saved) {
                            Notification::make()
                                ->success()
                                ->title('Event has been Published');
                        } else {
                            Notification::make()
                                ->warning()
                                ->title('Failed to publish Event');
                        }
                    })
                    ->visible(function (Event $record) use ($admins_only) {
                        return $admins_only && $record->status != Event::STATUS_PUBLISHED;
                    })
                    ->label('Publish Event')
                    ->icon('heroicon-m-clock'),
                Action::make('unpublishEvent')
                    ->action(function (Event $record) {
                        $saved = $record->unpublishEvent();

                        if ($saved) {
                            Notification::make()
                                ->success()
                                ->title('Event has been unpublished');
                        } else {
                            Notification::make()
                                ->warning()
                                ->title('Failed to unpublish Event');
                        }
                    })
                    ->visible(function (Event $record) use ($admins_only) {
                        return $admins_only && $record->status != Event::STATUS_UNPUBLISHED;
                    })
                    ->label('Unpublish Event')
                    ->icon('heroicon-o-clock'),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button())
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}/view'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
