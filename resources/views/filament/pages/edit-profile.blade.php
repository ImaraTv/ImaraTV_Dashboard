<x-filament-panels::page>
    @php
        $user = auth()->user();
        $hasRoles = $user->hasRole(['sponsor', 'creator', 'admin', 'super_admin']);
    @endphp
    @if(!$hasRoles)
        <h3>Welcome {{auth()->user()->name}}. </h3>
        <p>You have successfully registered with Imara TV but we need to know whether you are a Creator or Sponsor</p>

        {{  $this->profileInfo }}
    @else
        @if(!auth()->user()->approved)
            <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <strong class="font-bold">Pending Approval</strong>
                <span class="block sm:inline">Your profile is yet to be approved. Update your profile to quicken the process.</span>
            </div>
            @if(!empty($incomplete_fields))
                <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                    <strong class="font-bold">Complete these fields:</strong>
                    <span class="block sm:inline">@php echo implode(',', $incomplete_fields) @endphp</span>
                </div>
            @endif
        @endif
        {{  $this->profileInfo }}
    @endif

</x-filament-panels::page>
