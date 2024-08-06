
<h3>Preview {{ $video['type'] }} for <b>{{ $video['title'] }}</b></h3>
<div>
    @if(!empty($video['vimeo_url']))
        @php
            $segments = explode('/', $video['vimeo_url']);
            $video_id = $segments[2];
        @endphp
        <div class="plyr__video-embed" id="player">
            <iframe
                src="https://player.vimeo.com/video/{{$video_id}}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                allowfullscreen
                allowtransparency
                allow="autoplay"
                width="100%" height="360"
            ></iframe>
        </div>
        <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    @else

        <video
            id="my-video"
            class="video-js"
            controls
            preload="auto"
            width="100%"
            height="360"
            poster=""
            data-setup="{}">
            <source src="{{$video['url']}}" type="video/mp4" />
            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a
                web browser that
                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>
        <script src="https://vjs.zencdn.net/8.16.1/video.min.js"></script>

    @endif

</div>
