<?php

namespace App\Filament\Widgets;

use App\Models\CreatorProposal;
use Filament\{
    Tables\Columns\TextColumn,
    Tables\Table,
    Widgets\TableWidget as BaseWidget
};
use function auth;

class ProposalsTable extends BaseWidget
{

    public function getTableHeading(): string
    {
        return "Latest Film Projects (5)";
    }

    public function getColumnSpan(): string
    {
        return 'full';
    }

    public function table(Table $table): Table
    {
        $admins_only = auth()->user()->can('update');

        $query = CreatorProposal::query()->with(['sponsor', 'genre']);
        if (auth()->user()->hasRole('creator')) {
            $query = $query->where('user_id', auth()->id());
        }



        if (auth()->user()->hasRole('sponsor')) {
            $query = $query->where(function ($q) {
                $q->where('sponsored_by', auth()->id())
                        ->orWhere('user_id', auth()->id());
            });
        }

        $query = $query->orderBy('created_at', 'desc')->limit(5);
        return $table
                        ->paginated(false)
                        ->query(
                                $query
                        )
                        ->columns([
                            TextColumn::make('working_title')
                            ->label('Working Title'),
                            TextColumn::make('user.name')
                            ->name('user.name'),
                            TextColumn::make('sponsor')
                            ->name('sponsor.organization_name'),
                            TextColumn::make('genre')
                            ->name('genre.genre_name'),
                            TextColumn::make('status')
                            ->label('Proposal Status')
                            ->name('proposal_status.status'),
                            TextColumn::make('created_at')
                            ->label('Date Created')
                            ->date()
        ]);
    }
}
