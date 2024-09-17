<?php

namespace App\Filament\Resources\PublishingScheduleResource\Pages;

use App\Filament\Resources\PublishingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublishingSchedules extends ListRecords
{
    protected static string $resource = PublishingScheduleResource::class;

    protected static string $view = 'filament.pages.tables.publishing-schedules';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
