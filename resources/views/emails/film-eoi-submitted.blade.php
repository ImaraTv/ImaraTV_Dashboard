<x-mail::message>
Dear {{$name}},

@if($is_admin)
A new Expression of Interest to Sponsor the Film {{$proposal->working_title}} has been submitted by {{$sponsor->name}} at Imara TV.
@else
We have received your Expression of Interest to Sponsor the Film {{$proposal->working_title}} at Imara TV.
@endif

Warm Regards,<br>
Imara TV Team

<a href="https://imara.tv">https://imara.tv</a>
</x-mail::message>
