<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\{
    FilmSchedulesTable,
    ProposalsTable,
    StatsOverview
};
use Filament\Pages\Dashboard as BaseDashboard;
use function auth;
use function filament;

class Dashboard extends BaseDashboard
{

    protected static ?string $navigationIcon = 'heroicon-m-chart-bar-square';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Dashboard';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $navigationSort = 1;


    #[\Override]
    public static function canAccess(): bool
    {
        return auth()->user()->approved;
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }

    public function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            ProposalsTable::class,
            FilmSchedulesTable::class
        ];
    }

    public function getTitle(): string
    {
        return "Welcome " . filament()->getUserName(auth()->user());
    }
}
