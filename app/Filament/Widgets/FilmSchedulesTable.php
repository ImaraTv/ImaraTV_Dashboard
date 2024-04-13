<?php

namespace App\Filament\Widgets;

use App\Models\PublishingSchedule;
use Filament\{
    Tables\Columns\TextColumn,
    Tables\Table,
    Widgets\TableWidget as BaseWidget
};

class FilmSchedulesTable extends BaseWidget
{

     public function getTableHeading(): string
    {
        return "Latest Film Schedules (5)";
    }

    public function getColumnSpan(): string
    {
        return 'full';
    }
    public function table(Table $table): Table
    {
        $query = (new PublishingSchedule())
                ->orderBy('created_at', 'desc')
                ->limit(5);
        return $table
                        ->paginated(false)
                        ->query(
                                $query
                        )
                        ->columns([
                            TextColumn::make('film_title'),
                            TextColumn::make('release_date')
                            ->date(),
                            TextColumn::make('film_type.genre_name'),
                            TextColumn::make('sponsor.organization_name'),
                            TextColumn::make('creator.name'),
        ]);
    }
}
