<x-mail::message>

Dear {{$name}},

The video {{$video_title}} for {{$proposal_title}} has been successfully uploaded on Vimeo with id "{{$video_id}}".

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
