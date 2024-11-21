<?php

namespace App\Filament\Resources\PublishingScheduleResource\Pages;

use App\Filament\Resources\PublishingScheduleResource;
use App\Mail\FilmScheduleCreatedEmail;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreatePublishingSchedule extends CreateRecord
{

    protected static string $resource = PublishingScheduleResource::class;

    protected function beforeFill(): void
    {
        // Runs before the form fields are populated with their default values.

    }

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
        // mark the CreatorProposal as published
        $proposal = $record->proposal;
        if ($proposal) {
            $proposal->is_published = 1;
            $proposal->published_at = Carbon::now();
            $proposal->save();
        }
    }
}
