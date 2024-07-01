<?php

namespace App\Filament\Resources\PublishingScheduleResource\Pages;

use App\Filament\Resources\PublishingScheduleResource;
use App\Mail\FilmScheduleCreatedEmail;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreatePublishingSchedule extends CreateRecord
{

    protected static string $resource = PublishingScheduleResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['topics'] = collect($data['topics'])->implode(',');

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $users = array_filter([$record->user, $record?->creator?->user, $record?->sponsor?->user]);
        foreach ( $users as $user) {
            Mail::to($user)->send(new FilmScheduleCreatedEmail($user, $record));
        }
    }
}
