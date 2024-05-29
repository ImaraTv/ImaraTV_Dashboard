<x-mail::message>
    {{-- Greeting --}}
    @if (! empty($greeting))
    # {{ $greeting }}
    @else
    @if ($level === 'error')
    # @lang('Whoops!')
    @else
    # @lang('Hello!')
    @endif
    @endif
    <p>
        You requested to reset your password. Click on the link below to reset.
        <br/>
        if you did not request a reset password, you can ignore this email
    </p>
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

    {{-- Salutation --}}
    @if (! empty($salutation))
    {{ $salutation }}
    @else
    @lang('Regards'),<br>
    {{ config('app.name') }}
    @endif

    {{-- Subcopy --}}
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
