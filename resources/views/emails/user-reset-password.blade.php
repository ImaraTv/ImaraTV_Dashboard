<x-mail::message>

    # Hello!

    You requested to reset your password. Click on the link below to reset.

    if you did not request a reset password, you can ignore this email


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


    Regards,<br>
    {{ config('app.name') }}


   
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
