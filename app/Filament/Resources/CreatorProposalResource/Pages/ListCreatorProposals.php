<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreatorProposals extends ListRecords
{
    protected static string $resource = CreatorProposalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create New Proposal'),
        ];
    }
}
