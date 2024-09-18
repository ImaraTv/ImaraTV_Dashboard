<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreatorProposals extends ListRecords
{
    protected static string $resource = CreatorProposalResource::class;

    protected static string $view = 'filament.pages.tables.creator-proposals';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create New Proposal'),
        ];
    }
}
