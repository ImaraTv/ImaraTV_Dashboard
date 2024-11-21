<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CreatorProposalResource;
use App\Models\CreatorProposal;
use App\Models\PotentialSponsor;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class SponsorFilmsSelectedForFunding extends Page implements HasTable
{
    use InteractsWithTable,
        HasPageShield;

    protected static string $resource = CreatorProposalResource::class;
    protected static ?string $slug = 'films-selected-for-funding';
    protected static ?string $modelLabel = 'Film Project';
    protected static string $view = 'filament.pages.sponsor-film-projects';
    protected static ?string $navigationIcon = 'heroicon-s-film';
    protected static ?string $navigationLabel = 'Films Selected For Funding';
    protected static ?string $title = 'Films Selected For Funding';
    protected static ?int $navigationSort = 3;

    #[\Override]
    public static function canAccess(array $parameters = []): bool
    {
        return boolval(auth()->user()->approved) && auth()->user()->hasRole('sponsor');
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected static function table(Table $table): Table {
        $proposal_ids = PotentialSponsor::query()->select(['proposal_id'])
            ->where('sponsor_id', auth()->id())
            ->whereNotNull('proposal_id')
            ->get()->pluck('proposal_id')->toArray();

        $query = CreatorProposal::query()->with(['sponsor', 'sponsorUser', 'genre', 'creator', 'assigned_creator']);
        $query = $query->whereIn('id', $proposal_ids);

        $query->orderBy('id', 'desc');

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('working_title')
                    ->label('Working Title'),
                TextColumn::make('user.name')
                    ->label('Created By')
                    ->name('user.name'),
                TextColumn::make('sponsor_user')
                    ->name('sponsorUser.name')
                    ->label('Sponsor User Name'),
                TextColumn::make('sponsor_orgname')
                    ->name('sponsor.organization_name')
                    ->label('Sponsor Org Name'),
                TextColumn::make('assigned_creator')
                    ->label('Assigned Creator')
                    ->name('assigned_creator.name'),
                TextColumn::make('genre')
                    ->name('genre.genre_name'),
                TextColumn::make('status')
                    ->label('Proposal Status')
                    ->name('proposal_status.status'),
                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->date()
            ])->actions(SponsorFilmProjects::tableActions());
    }
}
