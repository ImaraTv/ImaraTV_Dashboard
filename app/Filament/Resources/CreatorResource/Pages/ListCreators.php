<?php

namespace App\Filament\Resources\CreatorResource\Pages;

use App\Filament\Resources\CreatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreators extends ListRecords
{
    protected static string $resource = CreatorResource::class;

    protected static string $view = 'filament.pages.tables.creators';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
