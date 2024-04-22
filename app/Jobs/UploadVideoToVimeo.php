<?php

namespace App\Jobs;

use App\Models\CreatorProposal;
use Illuminate\{
    Bus\Queueable,
    Contracts\Queue\ShouldQueue,
    Foundation\Bus\Dispatchable,
    Queue\InteractsWithQueue,
    Queue\SerializesModels
};
use Vimeo\Laravel\Facades\Vimeo;
use function env;

class UploadVideoToVimeo implements ShouldQueue
{

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected CreatorProposal $proposal)
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
            $video = $proposal->getMedia("videos")->first();

            $path = $video->getPath();

            if (file_exists($path)) {
                $this->upload($path, $proposal->working_title);
            }
        }
        return;
    }

    public function upload($file, $name = ""): string
    {


        try {

            if ($this->proposal->vimeo_link != null) {

                $response = Vimeo::replace($this->proposal->vimeo_link, $file);
            } else {
                $response = Vimeo::upload($file);
            }
            
            $this->proposal->vimeo_link = $response;
            $saved = $this->proposal->save();
           
            return $response;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
