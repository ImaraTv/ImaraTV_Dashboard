<?php

namespace App\Filament\Resources\CreatorProposalResource\Pages;

use App\Filament\Resources\CreatorProposalResource;
use Filament\{
    Actions,
    Resources\Pages\EditRecord
};
use App\Mail\ProposalStatusChange;
use App\Models\CreatorProposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Override;

class EditCreatorProposal extends EditRecord
{

    protected static string $resource = CreatorProposalResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        return $data;
    }

    #[Override]
    protected function mutateFormDataBeforeSave(array $data):array
    {
        if (auth()->user()->hasRole('creator')) {
            $data['creator_id'] = auth()->id();
        }
        if (auth()->user()->hasRole('sponsor')) {
            $data['sponsored_by'] = auth()->id();
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }

    protected function beforeSave(): void
    {
        // Runs before the form fields are saved to the database.
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.

        // send email if status is changed
        $record = $this->record;
        if($record->wasChanged('status')) {
            $users = array_filter([$record->user, $record?->assigned_creator?->user, $record?->sponsor?->user]);
            foreach ( $users as $user) {
                Mail::to($user)->send(new ProposalStatusChange($user, $record));
            }
        }
    }
}
