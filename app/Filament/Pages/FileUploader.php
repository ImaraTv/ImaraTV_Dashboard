<?php

namespace App\Filament\Pages;

use App\Models\CreatorProposal;
use Filament\Pages\SimplePage;

class FileUploader extends SimplePage
{
    protected static string $view = 'uploader';
    protected ?string $maxWidth = '5xl';

    public function getTitle(): \Illuminate\Contracts\Support\Htmlable|string
    {
        return 'Upload Video';
    }

    protected function getViewData(): array
    {
        $proposal_id = request()->get('proposal_id');
        $collection = request()->get('collection');
        $creatorProposal = null;
        if ($proposal_id) {
            $creatorProposal = CreatorProposal::find($proposal_id);
        }
        return [
            'proposal_id' => $proposal_id,
            'collection' => $collection,
            'collection_title' => $collection == 'videos' ? 'HD Video' : 'Trailer',
            'creatorProposal' => $creatorProposal,

        ];
    }

}
