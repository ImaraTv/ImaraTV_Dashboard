<x-mail::message>

### Dear {{$name}},

We have received a request to reset the password for your account at Imara TV.

To reset your password, please click on the following link:


@isset($actionText)
<?php
$color = match ($level) {
    'success', 'error' => $level,
    default => 'primary',
};
?>
<x-mail::button :url="$actionUrl" :color="$color">
    {{ $actionText }}
</x-mail::button>
@endisset

If you did not request this change, please disregard this email.

If you have any concerns or need further assistance, please don't hesitate to contact us at

star@imara.tv

Warm Regards,<br>
Imara TV Team

<a href="https://imara.tv">https://imara.tv</a>



@isset($actionText)
<x-slot name="subcopy">
    @lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
    'actionText' => $actionText,
    ]
    ) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot>
@endisset
</x-mail::message>
