<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreatorProposal extends EditRecord
{

    protected static string $resource = CreatorProposalResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
       info($data);
       return $data;
    }
}
