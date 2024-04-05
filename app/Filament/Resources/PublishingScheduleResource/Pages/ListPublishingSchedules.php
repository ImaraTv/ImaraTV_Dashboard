<?php

namespace App\Filament\Resources\PublishingScheduleResource\Pages;

use App\Filament\Resources\PublishingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublishingSchedules extends ListRecords
{
    protected static string $resource = PublishingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
