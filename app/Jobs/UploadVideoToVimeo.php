<?php

namespace App\Jobs;

use App\Models\CreatorProposal;
use Exception;
use Illuminate\{
    Bus\Queueable,
    Contracts\Queue\ShouldQueue,
    Foundation\Bus\Dispatchable,
    Queue\InteractsWithQueue,
    Queue\SerializesModels
};
use Vimeo\Laravel\Facades\Vimeo;

class UploadVideoToVimeo implements ShouldQueue
{

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected CreatorProposal $proposal, protected $media = '')
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $proposal = $this->proposal;
        if ($proposal) {

            $path = $this->media->getPath();

            if (file_exists($path)) {
                $this->upload($path, $proposal->working_title);
            }
        }
        return;
    }

    public function upload(?string $file, ?string $name = ""): string
    {


        try {

            if ($this->proposal->vimeo_link != null) {

                $response = Vimeo::replace($this->proposal->vimeo_link, $file);
            } else {
                $response = Vimeo::upload($file, ['name' => $name, 'privacy' => ['view' => 'anybody']]);
            }

            $this->proposal->vimeo_link = $response;
            $saved = $this->proposal->save();
            if ($saved) {
                $this->removeMedia();
            }
            return $response;
        } catch (Exception $exc) {
            logger($exc->getTraceAsString());
        }
    }

    public function removeMedia()
    {
        $this->media->delete();
    }
}
