<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilmRatingResource\Pages;
use App\Filament\Resources\FilmRatingResource\RelationManagers;
use App\Models\FilmRating;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FilmRatingResource extends Resource
{
    protected static ?string $model = FilmRating::class;

    protected static ?string $navigationIcon = 'heroicon-s-film';

    protected static ?string $navigationGroup = 'Statistics';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole(['admin', 'super_admin']);
    }

    public static function canAccess(): bool
    {
        return boolval(auth()->user()->hasRole('admin|super_admin'));
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $query = FilmRating::with(['user', 'film']);
        return $table
            ->defaultSort('id', 'desc')
            ->query($query)
            ->columns([
                TextColumn::make('user.name')
                    ->name('user.name')
                    ->label('User/Rated By'),
                TextColumn::make('film.film_title')
                    ->name('film.film_title')
                    ->label('Film'),
                TextColumn::make('stars')
                    ->label('Rating'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('video_id')
                    ->relationship('film', 'film_title')
                    ->label('Film'),
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User/Rated By'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('Rating Date From'),
                        DatePicker::make('to')->label('Rating Date To'),
                    ])
                    ->columns(2)
                    ->columnSpan(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['to'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(5)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFilmRatings::route('/'),
            //'create' => Pages\CreateFilmRating::route('/create'),
            //'edit' => Pages\EditFilmRating::route('/{record}/edit'),
        ];
    }
}
