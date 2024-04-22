<?php

namespace App\Filament\Pages;

use App\Models\FilmTopic as Topic;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\{
    Actions\CreateAction,
    Forms\Components\TextInput,
    Pages\Page,
    Tables\Actions\BulkActionGroup,
    Tables\Actions\DeleteAction,
    Tables\Actions\DeleteBulkAction,
    Tables\Actions\EditAction,
    Tables\Columns\TextColumn,
    Tables\Concerns\InteractsWithTable,
    Tables\Contracts\HasTable,
    Tables\Table
};

class FilmTopic extends Page implements HasTable
{

    use InteractsWithTable,
        HasPageShield;

//    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.film-topic';

    protected static ?string $navigationGroup = 'Settings';

    protected function getHeaderActions(): array
    {

        return [
                    CreateAction::make()
                    ->visible(auth()->user()->can('create_topics_user'))
                    ->form([
                        TextInput::make('topic_name')
                        ->label('Topic')
                        ->name('topic_name')
                        ->required()
                        ->maxLength(255),
                    ])
                    ->using(function (array $data): Topic {
                        return Topic::create($data);
                    })
        ];
    }

    protected static function table(Table $table): Table
    {

        return $table
                        ->query(Topic::query())
                        ->columns([
                            TextColumn::make('film_topic')
                            ->name('topic_name'),
                            TextColumn::make('created_at')
                            ->date()
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            EditAction::make()
                            ->visible(auth()->user()->can('update_topics_user'))
                            ->form([
                                TextInput::make('topic_name')
                                ->label('Topic')
                                ->name('topic_name')
                                ->maxLength(255)
                            ])
                            ->using(function (Topic $record, array $data): Topic {
                                $record->update($data);

                                return $record;
                            }),
                            DeleteAction::make()
                            ->visible(auth()->user()->can('delete_topics_user')),
                        ])
                        ->bulkActions([
                            BulkActionGroup::make([
                                DeleteBulkAction::make(),
                            ]),
        ]);
    }
}
