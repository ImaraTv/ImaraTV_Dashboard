<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use App\Filament\Traits\HasParentResource;
use App\Models\CreatorProposal;
use App\Models\PotentialSponsor;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListCreatorProposalEOI extends ListRecords
{

    protected static string $resource = CreatorProposalResource::class;
    protected ?string $maxWidth = '5xl';

    protected static string $view = 'filament.pages.tables.creator-proposals';
    protected static ?string $navigationLabel = 'Expressions of Interest';
    protected static ?string $navigationIcon = 'heroicon-s-film';
    protected static ?string $title = 'Expressions of Interest';

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    public function getBreadcrumbs(): array
    {
        $proposal_id = request('record');
        $proposal = CreatorProposal::find($proposal_id);
        $resource = static::getResource();
        $parentResource = static::getResource();

        $breadcrumbs = [
            $parentResource::getUrl() => $parentResource::getBreadCrumb(),
            EditCreatorProposal::getUrl(['record' => $proposal_id]) => $proposal->working_title,
            $this->getTitle(),
        ];

        if (isset($this->record)) {
            $breadcrumbs[] = $resource::getRecordTitle($this->record);
        }

        return $breadcrumbs;
    }

    public function table(Table $table): Table
    {
        $proposal_id = request('record');

        $query = PotentialSponsor::query()->with(['sponsor', 'proposal'])
            ->where('proposal_id', $proposal_id);
        $query->orderBy('id', 'desc');
        return $table
            ->query($query)
            ->columns([
                TextColumn::make('film_project')
                    ->name('proposal.working_title')
                    ->label('Film Project'),
                TextColumn::make('sponsor_name')
                    ->name('sponsor.name')
                    ->label('Name'),
                TextColumn::make('sponsor')
                    ->name('sponsor.organization_name')
                    ->label('Organization'),
                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->date()
            ]);
    }
}
