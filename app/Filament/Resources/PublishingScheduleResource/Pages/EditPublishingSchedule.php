<?php

namespace App\Filament\Resources\PublishingScheduleResource\Pages;

use App\Filament\Resources\PublishingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublishingSchedule extends EditRecord
{
    protected static string $resource = PublishingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
