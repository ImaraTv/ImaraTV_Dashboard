<x-mail::message>
Dear {{$name}},

The film {{$film_name}} has been scheduled for release on {{$release_date}} at Imara TV.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
