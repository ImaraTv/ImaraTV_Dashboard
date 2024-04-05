<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Vimeo\Vimeo;
use function ddd;
use function env;
use function storage_path;


class UploadToVimeo extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upload-to-vimeo {--video=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client_id = env('VIMEO_CLIENT_ID');
        $client_secret = env('VIMEO_CLIENT_SECRET');
        $token = env('VIMEO_CLIENT_ACCESS');
        $lib = new Vimeo(client_id: $client_id, client_secret: $client_secret, access_token: $token);

        $file_path = $this->option('video');
        
        
        if(file_exists($file_path)){
       
        $response = $lib->upload($file, [ 'name' => 'Girl with the picture', 'privacy' => [ 'view' =>'anybody' ] ]);

        return $response;
        }
        return false;
    }
}
