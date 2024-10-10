<x-mail::message>
Dear {{$name}},

@if($is_admin)
A new Expression of Interest to Sponsor the Film {{$proposal->working_title}} has been submitted by {{$sponsor->name}} at Imara TV.
@else
We have received your Expression of Interest to Sponsor the Film {{$proposal->working_title}} at Imara TV.
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
