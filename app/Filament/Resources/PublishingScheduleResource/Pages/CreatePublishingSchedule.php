<?php

namespace App\Filament\Resources\PublishingScheduleResource\Pages;

use App\Filament\Resources\PublishingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePublishingSchedule extends CreateRecord
{

    protected static string $resource = PublishingScheduleResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['topics'] = collect($data['topics'])->implode(',');

        return $data;
    }
}
