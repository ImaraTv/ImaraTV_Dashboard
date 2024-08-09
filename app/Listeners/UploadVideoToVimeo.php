<?php

namespace App\Listeners;

use App\{
    Jobs\UploadVideoToVimeo as UploadVidJob,
    Models\CreatorProposal
};
use Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;
use function dispatch;
use function logger;

class UploadVideoToVimeo
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if ($media->collection_name === 'videos' || $media->collection_name === 'trailers') {
            $proposal = CreatorProposal::whereId($media->model_id)->first();
            if ($proposal) {
                $job = (new UploadVidJob($proposal, $media->collection_name));
                dispatch($job);
            }
        }
        $path = $media->getPath();
        Log::info("file {$path} has been saved for media {$media->id}");
    }
}
