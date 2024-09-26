<?php

namespace App\Filament\Resources\FilmRatingResource\Pages;

use App\Filament\Resources\FilmRatingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilmRatings extends ListRecords
{
    protected static string $resource = FilmRatingResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
