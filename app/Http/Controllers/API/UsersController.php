<?php

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Http\Resources\VideoBookmarks,
    Models\FilmRating,
    Models\PublishingSchedule,
    Models\VideoBookmark
};
use Illuminate\{
    Http\Request,
    Support\Facades\Validator
};
use function auth;
use function response;

class UsersController extends Controller
{

    public function rateVideo(Request $request)
    {
        $validator = Validator::make($request->only('video_id','stars'), ['video_id' => 'required', 'stars' => 'required|numeric']);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $user = auth('api')->user();

        $video = PublishingSchedule::whereId($request->video_id)->first();
        if ($user && $video) {
            $saved = (new FilmRating())->updateOrCreate(['user_id' => $user->id, 'video_id' => $video->id], [
                'user_id' => $user->id,
                'video_id' => $video->id,
                'stars' => $request->stars
            ]);
            if ($saved) {
                return response()->json(['status' => 'success', 'message' => 'video rating updated']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'failed to update video rating']);
    }

    public function bookmarkVideo(Request $request)
    {
        $validator = Validator::make($request->only('video_id'), ['video_id' => 'required']);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $user = auth('api')->user();

        $video = PublishingSchedule::whereId($request->video_id)->first();
        if ($user && $video) {
            $saved = (new VideoBookmark())->updateOrCreate(['user_id' => $user->id, 'video_id' => $video->id], [
                'user_id' => $user->id,
                'video_id' => $video->id
            ]);
            if ($saved) {
                return response()->json(['status' => 'success', 'message' => 'video bookmark updated']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'failed to update bookmark']);
    }

    public function videoBookmarks(Request $request): VideoBookmarks
    {
        $videos = VideoBookmark::where(['user_id' => auth('api')->id()])->paginate(10);

        return (new VideoBookmarks($videos));
    }
}
