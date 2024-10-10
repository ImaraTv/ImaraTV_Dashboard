<x-mail::message>
{{-- Greeting --}}
# Dear {{ $name }},

Thank you for registering with Imara TV, your go-to destination for impactful and inspiring
content.

Imara TV educates the public through short, entertaining films made by young, self-employed
Kenyans using their talents in acting and animation. These films tackle important social themes
and are offered free to viewers. Imara TV emerged from the I-AM co-creation hackathon by the
UNFPA, Kenya’s Ministry of Health, UK Aid, and Nailab Accelerator to expand access to
youth-friendly information and services.

Our mission is to address issues like HIV and teenage pregnancy by creating jobs for young
people and providing engaging, relatable edutainment that inspires positive change.

Before you can start exploring our exclusive content, please verify your email by clicking the link
below:

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

Once verified, you’ll gain full access to our platform and the latest updates.

Stay connected with us on social media for news, updates, and behind-the-scenes content.

Thank you for being a part of our community. We look forward to bringing you meaningful
content!

{{-- Salutation --}}
Warm Regards,<br>
Imara TV Team

<a href="https://imara.tv">https://imara.tv</a>

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
    @lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
    'actionText' => $actionText,
    ]
    ) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
