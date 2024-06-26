<?php

namespace App\Filament\Resources\CreatorResource\Pages;

use App\Filament\Resources\CreatorResource;
use Filament\{
    Actions,
    Resources\Pages\EditRecord
};

class EditCreator extends EditRecord
{

    protected static string $resource = CreatorResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    
}
