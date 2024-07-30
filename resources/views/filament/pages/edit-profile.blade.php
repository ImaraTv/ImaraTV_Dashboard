<x-filament-panels::page>
    @if(!auth()->user()->approved)
        <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <strong class="font-bold">Pending Approval</strong>
            <span class="block sm:inline">Your profile is yet to be approved. Update your profile to quicken the process.</span>
        </div>
    @endif
    {{  $this->profileInfo }}

</x-filament-panels::page>
