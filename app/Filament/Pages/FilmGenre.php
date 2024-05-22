<?php

namespace App\Filament\Pages;

use App\Models\FilmGenre as Genre;
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

class FilmGenre extends Page implements HasTable
{

    use InteractsWithTable,
        HasPageShield;

//    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.film-genre';

    protected static ?string $model = Genre::class;

    protected static ?string $navigationGroup = 'Settings';


    #[\Override]
    public static function canAccess(): bool
    {
        return auth()->user()->approved;
    }

    protected function getHeaderActions(): array
    {
        return [
                    CreateAction::make()
                    ->form([
                        TextInput::make('genre_name')
                        ->label('Genre')
                        ->name('genre_name')
                        ->required()
                        ->maxLength(255),
                    ])
                    ->using(function (array $data): Genre {
                        return Genre::create($data);
                    })
        ];
    }

    protected static function table(Table $table): Table
    {

        return $table
                        ->query(Genre::query())
                        ->columns([
                            TextColumn::make('film_genre')
                            ->name('genre_name'),
                            TextColumn::make('created_at')
                            ->date()
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            EditAction::make()
                            ->form([
                                TextInput::make('genre_name')
                                ->label('Genre')
                                ->name('genre_name')
                                ->maxLength(255)
                            ])
                            ->using(function (Genre $record, array $data): Genre {
                                $record->update($data);

                                return $record;
                            }),
                            DeleteAction::make(),
                        ])
                        ->bulkActions([
                            BulkActionGroup::make([
                                DeleteBulkAction::make(),
                            ]),
        ]);
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }
}
