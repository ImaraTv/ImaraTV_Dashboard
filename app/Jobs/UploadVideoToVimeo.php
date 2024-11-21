<?php

namespace App\Jobs;

use App\Models\CreatorProposal;
use Exception;
use Illuminate\{Bus\Queueable,
    Contracts\Queue\ShouldQueue,
    Foundation\Bus\Dispatchable,
    Queue\InteractsWithQueue,
    Queue\SerializesModels,
    Support\Facades\Storage};
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Vimeo\Laravel\Facades\Vimeo;

class UploadVideoToVimeo implements ShouldQueue
{

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    public $timeout = 3600;

    const MEDIA_HD_VIDEO = 'videos';
    const MEDIA_TRAILER_VIDEO = 'trailers';

    /**
     * Create a new job instance.
     */
    public function __construct(protected CreatorProposal $proposal, protected $collection = '')
    {
        if (empty($this->collection)) {
            $this->collection = self::MEDIA_HD_VIDEO;
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $proposal = $this->proposal;
        if ($proposal) {
            $type = '';
            if ($this->collection == self::MEDIA_HD_VIDEO) {
                $media = $proposal->getMedia('videos')->last();
                $type = "HD Video";
            }
            else {
                $media = $proposal->getMedia('trailers')->last();
                $type = "Trailer";
            }
            $path = $media->getPath();

            if (file_exists($path)) {
                $this->upload($media, $this->collection, $proposal->working_title . ' (' . $type . ')');
            }
        }
    }

    public function upload( Media $media, ?string $collection = "" , ?string $name = "")
    {
        try {
            $path = $media->getPath();
            logger($path);
            $success = false;

            if ($collection == self::MEDIA_HD_VIDEO) {
                $vimeo_link = $this->proposal->vimeo_link ? $this->proposal->vimeo_link : $media->getCustomProperty('vimeo_link');
                if (!empty($vimeo_link)) {
                    $response = Vimeo::replace($vimeo_link, $path);
                } else {
                    $response = Vimeo::upload($path, ['name' => $name, 'privacy' => ['view' => 'anybody']]);
                }
                $this->proposal->vimeo_link = $response;
                $success = $this->proposal->save();
            }
            else {
                if ($media->getCustomProperty('vimeo_link')) {
                    $response = Vimeo::replace($media->getCustomProperty('vimeo_link'), $path);
                }
                else {
                    $response = Vimeo::upload($path, ['name' => $name, 'privacy' => ['view' => 'anybody']]);
                }

                $success = true;
            }

            if ($success) {
                $media->setCustomProperty('vimeo_link', $response);
                $media->save();
                $this->removeMedia($media);
                // send notification that video is uploaded
                logger($this->proposal->id);
                CreatorProposal::notifyOnVimeoUploadCompletion($this->proposal, $name, $response);
            }

            logger($response);
        } catch (Exception $exc) {
            logger($exc->getTraceAsString());
            $error_message = $exc->getMessage();
            CreatorProposal::notifyOnVimeoUploadFailed($this->proposal, $name, $error_message);
        }
    }

    public function removeMedia(Media $media): void
    {
        # keep media record in db while deleting the file itself from storage
        //$media->delete();
        //$path = public_path($media->getPath());
        Storage::delete($media->getPath());
    }
}
