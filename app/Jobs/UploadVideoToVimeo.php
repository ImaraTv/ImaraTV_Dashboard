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
use Vimeo\Vimeo;
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
        $client_id = env('VIMEO_CLIENT_ID');
        $client_secret = env('VIMEO_CLIENT_SECRET');
        $token = env('VIMEO_CLIENT_ACCESS');
        $lib = new Vimeo(client_id: $client_id, client_secret: $client_secret, access_token: $token);
        if ($this->proposal->vimeo_link != null) {
            $response = $lib->replace($this->proposal->vimeo_link, $file);
        } else {
            $response = $lib->upload($file, ['name' => $name, 'privacy' => ['view' => 'anybody']]);
        }
        $this->proposal->vimeo_link = $response;
        $this->proposal->save();
        return $response;
    }
}
