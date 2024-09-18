<x-filament-panels::page>

    <div wire:loading.class="opacity-50"
         wire:target="tableFilters,applyTableFilters,resetTableFiltersForm, nextPage, gotoPage, previousPage">

        <div class="loading_indicator items-center justify-center p-4"
             wire:loading.delay wire:loading wire:target="tableFilters,applyTableFilters,resetTableFiltersForm, nextPage, gotoPage, previousPage">
            <x-filament::loading-indicator class="h-5 w-5" />
        </div>

        {{ $this->table }}

    </div>

</x-filament-panels::page>
