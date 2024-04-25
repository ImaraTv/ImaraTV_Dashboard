<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use Filament\Resources\Pages\CreateRecord;
use function auth;
use function collect;

class CreateCreatorProposal extends CreateRecord
{

    protected static string $resource = CreatorProposalResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        if (auth()->user()->hasRole('creator')) {
            $data['creator_id'] = auth()->id();
        }
        if (auth()->user()->hasRole('sponsor')) {
            $data['sponsored_by'] = auth()->id();
        }
        $data['topics'] = collect($data['topics'])->implode(',');

        return $data;
    }
}
