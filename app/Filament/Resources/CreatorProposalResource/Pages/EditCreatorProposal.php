<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use Filament\{
    Actions,
    Resources\Pages\EditRecord
};
use Override;

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

        return $data;
    }

    #[Override]
    protected function mutateFormDataBeforeSave(array $data):array
    {
        if (auth()->user()->hasRole('creator')) {
            $data['creator_id'] = auth()->id();
        }
        if (auth()->user()->hasRole('sponsor')) {
            $data['sponsored_by'] = auth()->id();
        }
        return $data;
    }
}
