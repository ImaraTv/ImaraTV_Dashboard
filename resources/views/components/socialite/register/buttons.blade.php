<div class="flex flex-col gap-y-6">
    @if ($messageBag->isNotEmpty())
        @foreach($messageBag->all() as $value)
            <p class="fi-fo-field-wrp-error-message text-danger-600 dark:text-danger-400">{{ __($value) }}</p>
        @endforeach
    @endif

    @if (count($providers))
        @if($showDivider)
            <div class="relative flex items-center justify-center text-center">
                <div class="absolute border-t border-gray-200 w-full h-px"></div>
                <p class="inline-block relative bg-white text-sm p-2 rounded-full font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-100">
                    {{ __('or Register via') }}
                </p>
            </div>
        @endif

        <div class="grid @if(count($providers) > 1) grid-cols-2 @endif gap-4">
            @foreach($providers as $key => $provider)
                <x-filament::button
                    :color="$provider['color'] ?? 'gray'"
                    :outlined="$provider['outlined'] ?? true"
                    :icon="$provider['icon'] ?? null"
                    tag="a"
                    :href="route($socialiteRoute, $key)"
                    :spa-mode="false"
                >
                    {{ 'Register with ' . $provider['label'] }}
                </x-filament::button>
            @endforeach
        </div>

        @if($showDivider)
            <div class="relative flex items-center justify-center text-center">
                <div class="absolute border-t border-gray-200 w-full h-px"></div>
                <p class="inline-block relative bg-white text-sm p-2 rounded-full font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-100"></p>
            </div>
        @endif
    @else
        <span></span>
    @endif
</div>
