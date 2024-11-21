<x-mail::message>

Dear {{$name}},

A new {{$role}} has been registered at Imara TV with the below details.

Name: {{$user->name}}

Email: {{$user->email}}

To view more details follow the link: <a href="{{$link}}">Profile Link</a>

Warm Regards,<br>
Imara TV Team

<a href="https://imara.tv">https://imara.tv</a>

</x-mail::message>
