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

class SponsorFilmsEOI extends Page implements HasTable
{
    use InteractsWithTable,
        HasPageShield;

    protected static string $resource = CreatorProposalResource::class;
    protected static ?string $slug = 'sponsorship-requests';
    protected static ?string $modelLabel = 'Sponsorship Request';
    protected static string $view = 'filament.pages.sponsor-film-projects';
    protected static ?string $navigationIcon = 'heroicon-s-film';
    protected static ?string $navigationLabel = 'Sponsorship Requests';
    protected static ?string $title = 'Sponsorship Requests';
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
        $query = PotentialSponsor::query()->with(['sponsor', 'creator'])
            ->where('sponsor_id', auth()->id())
            ->whereNotNull('creator_id');

        $query->orderBy('id', 'desc');

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('creator_user')
                    ->label('Creator')
                    ->name('creator.name'),
                TextColumn::make('sponsor_user')
                    ->name('sponsor.name')
                    ->label('Sponsor User Name'),
                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->date()
            ]);
    }
}
