<?php

namespace App\Models;

use App\Mail\VimeoUploadComplete;
use App\Mail\VimeoUploadFail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\HasOneThrough, SoftDeletes};
use Spatie\MediaLibrary\{
    HasMedia,
    InteractsWithMedia
};
use Illuminate\Support\Facades\Mail;

class CreatorProposal extends Model implements HasMedia
{

    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(CreatorProfile::class, 'user_id', 'user_id');
    }

    public function genre()
    {
        return $this->belongsTo(FilmGenre::class, 'film_genre', 'id');
    }

    public function sponsor()
    {
        return $this->belongsTo(SponsorProfile::class, 'sponsored_by', 'user_id');
    }
    public function sponsorProfile()
    {
        return $this->belongsTo(SponsorProfile::class, 'sponsored_by', 'user_id');
    }

    public function sponsorUser()
    {
        return $this->belongsTo(User::class, 'sponsored_by', 'id');
    }

    public function proposal_status()
    {
        return $this->belongsTo(ProposalStatus::class, 'status', 'id');
    }

    public function potential_sponsors()
    {
        return $this->hasMany(PotentialSponsor::class, 'proposal_id', 'id');
    }

    public function assigned_creator()
    {
       return $this->belongsTo(CreatorProfile::class, 'creator_id', 'user_id');
    }

    public static function getVimeoVideoDetails(string $url): array
    {
        # url format = '/videos/951068539'

        $vimeo_api_key = env('VIMEO_CLIENT_ACCESS');

        $params = substr(parse_url($url, PHP_URL_PATH), 1);
        $segments = explode('/', $params);

        $video_id = $segments[1];
        //$video_h = @$segments[1];
        $video_h = '';

        $options = array('http' => array(
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $vimeo_api_key
        ));
        $context = stream_context_create($options);

        $hash = json_decode(file_get_contents("https://api.vimeo.com/videos/{$video_id}", false, $context));

        return array(
            'provider' => 'Vimeo',
            'video_id' => $video_id,
            'title' => $hash->name,
            'description' => str_replace(array("<br>", "<br/>", "<br />"), NULL, $hash->description),
            'description_nl2br' => str_replace(array("\n", "\r", "\r\n", "\n\r"), NULL, $hash->description),
            'thumbnail' => $hash->pictures->sizes[0]->link,
            'video' => $hash->link,
            //'embed_video' => "https://player.vimeo.com/video/" . $video_id,
            'embed_video' => empty($video_h) ? "https://player.vimeo.com/video/" . $video_id : "https://player.vimeo.com/video/" . $video_id . '?h=' . $video_h,
            'duration' => gmdate("H:i:s", $hash->duration)
        );

    }

    public static function notifyOnVimeoUploadCompletion(CreatorProposal $proposal, string $video_title, string $vimeo_id)
    {
        $model = $proposal;
        $mail = new VimeoUploadComplete($model, $video_title, $vimeo_id);
        Mail::to(['support@imara.tv', env('APP_CONTACT_EMAIL')])->send($mail);
    }

    public static function notifyOnVimeoUploadFailed(CreatorProposal $proposal, string $video_title, string $failure_message){
        $model = CreatorProposal::where($proposal->id)->first();
        $mail = new VimeoUploadFail($model, $video_title, $failure_message);
        Mail::to(['support@imara.tv', env('APP_CONTACT_EMAIL')])->send($mail);
    }

    public function assignCreator(int $creator_id)
    {
        $this->creator_id = $creator_id;
        $saved = $this->save();
        if ($saved) {
            // notify creator
        }
        return $saved;
    }

    public function assignSponsor(int $sponsored_by)
    {
        $this->sponsored_by = $sponsored_by;
        $saved = $this->save();
        if ($saved) {
            // notify sponsor
        }
        return $saved;
    }
}
