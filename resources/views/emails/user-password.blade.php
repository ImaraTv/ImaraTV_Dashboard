<x-mail::message>
{{-- Greeting --}}
# Dear {{ $name }},

Thank you for registering with Imara TV, your go-to destination for impactful and inspiring
content.

We have automatically generated a password for you. Use the Password below to login to your account at Imara TV:

# {{ $password }}

You can also change or reset it at any time on this link:

{{-- Action Button --}}
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

Thank you for being a part of our community. We look forward to bringing you meaningful
content!

{{-- Salutation --}}
Warm Regards,<br>
Imara TV Team

<a href="https://imara.tv">https://imara.tv</a>

</x-mail::message>
