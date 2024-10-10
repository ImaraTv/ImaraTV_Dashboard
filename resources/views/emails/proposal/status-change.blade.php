<x-mail::message>

Dear {{$name}},

The status of the Film {{$proposal_title}} has changed to {{$status}}.

Click below to view the film project:

<x-mail::button :url="'#'">
    View Film Project
</x-mail::button>

If you have any concerns or need further assistance, please don't hesitate to contact us at

star@imara.tv


Warm Regards,<br>
Imara TV Team

<a href="https://imara.tv">https://imara.tv</a>

</x-mail::message>
