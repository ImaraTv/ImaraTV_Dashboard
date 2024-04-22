<?php

namespace App\Filament\Widgets;

use App\Models\{
    CreatorProfile,
    CreatorProposal,
    SponsorProfile
};
use Filament\Widgets\{
    StatsOverviewWidget as BaseWidget,
    StatsOverviewWidget\Stat
};
use function auth;

class StatsOverview extends BaseWidget
{

    protected function getStats(): array
    {

        if (auth()->user()->hasRole('admin|super_admin')) {
            return $this->adminWidgets();
        }
        if (auth()->user()->hasRole('creator')) {
            return $this->creatorWidgets();
        }
        if (auth()->user()->hasRole('sponsor')) {
            return $this->sponsorWidgets();
        }
        return [];
    }

    protected function adminWidgets(): array
    {
        return [
            Stat::make('Total Sponsors', SponsorProfile::count()),
            Stat::make('Total Creators', CreatorProfile::count()),
            Stat::make('Total Projects', $this->getProjects()),
        ];
    }

    protected function sponsorWidgets(): array
    {
        return [
            Stat::make('Total Projects', $this->getProjects()),
        ];
    }

    protected function creatorWidgets(): array
    {
        return [
            Stat::make('Total Projects', $this->getProjects()),
        ];
    }

    protected function getProjects()
    {
        $projects = (new CreatorProposal());
        if (auth()->user()->hasRole('creator')) {
            $projects = $projects->where('user_id', auth()->id());
        }
        if (auth()->user()->hasRole('sponsor')) {
            $projects = $projects->where(function ($q) {
                $q->where('sponsored_by', auth()->id())
                ->orWhere('user_id', auth()->id());
            });
        }
        return $projects = $projects->count();
    }
}
