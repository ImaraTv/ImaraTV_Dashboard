<x-mail::message>
Dear {{$admin_name}},

    You have received a new Enquiry at Imara TV with the following details:

    Name: {{$name}}
    Email/Phone: {{$email_or_phone}}
    Message: {{$message}}

Regards,<br>

{{ config('app.name') }}
</x-mail::message>
