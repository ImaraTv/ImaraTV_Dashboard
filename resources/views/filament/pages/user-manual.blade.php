<x-filament-panels::page>
    @if(auth()->user()->hasRole('creator'))
        @include('creator-manual')
    @elseif (auth()->user()->hasRole('sponsor'))
        @include('sponsor-manual')
    @else
        @include('user-manual')
    @endif
</x-filament-panels::page>
