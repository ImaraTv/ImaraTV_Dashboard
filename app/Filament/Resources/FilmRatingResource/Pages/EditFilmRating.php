<?php

namespace App\Filament\Resources\FilmRatingResource\Pages;

use App\Filament\Resources\FilmRatingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFilmRating extends EditRecord
{
    protected static string $resource = FilmRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
