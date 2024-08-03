<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};
use Spatie\MediaLibrary\{
    HasMedia,
    InteractsWithMedia
};

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

        $video_id = $segments[2];
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
}
