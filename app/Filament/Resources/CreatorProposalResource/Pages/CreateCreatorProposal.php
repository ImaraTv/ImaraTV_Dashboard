<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCreatorProposal extends CreateRecord
{

    protected static string $resource = CreatorProposalResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['topics'] = collect($data['topics'])->implode(',');

        return $data;
    }
}
