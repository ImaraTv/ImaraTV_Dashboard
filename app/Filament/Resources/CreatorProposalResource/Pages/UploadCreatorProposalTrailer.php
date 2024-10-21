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

class UploadCreatorProposalTrailer extends EditRecord
{

    protected static string $resource = CreatorProposalResource::class;
    protected static string $view = 'filament.pages.proposal-videos';
    protected static ?string $navigationLabel = 'Upload Trailer';
    protected static ?string $navigationIcon = 'heroicon-m-arrow-up-tray';


    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function getViewData(): array
    {
        $proposal = $this->record;
        $media = $proposal->getMedia('trailers')->last();
        return [
            'proposal_id' => $proposal->id,
            'collection' => 'trailers',
            'collection_title' => 'Trailer',
            'creatorProposal' => $proposal,
            'video' => [
                'url' => $media?->getFullUrl(),
                'vimeo_url' => $media?->getCustomProperty('vimeo_link'),
                'title' => $proposal->working_title,
                'type' => 'Trailer',
            ],
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

    }
}
