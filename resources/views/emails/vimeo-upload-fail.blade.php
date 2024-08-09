<x-mail::message>
Dear {{$name}},

The video {{$video_title}} for {{$proposal_title}}} has failed uploading to Vimeo. You can retry again or check the server logs.
    Message:

    ```
    {{$message}}
    ```

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
