<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Assets') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl py-4 px-4">
        <div class="md:grid grid-cols-[1fr_4fr]">
            <div class="bg-white rounded-md shadow-md overflow-hidden h-min">
                <h2 class="font-semibold text-lg border-b p-2">Asset Types</h2>
                <x-assets.asset-type-btn wire:click="$set('asset_type', 'subsea_assets')" :active="$this->asset_type === 'subsea_assets'">Subsea Assets</x-assets.asset-type-btn>
                <x-assets.asset-type-btn wire:click="$set('asset_type', 'surf_vessels')" :active="$this->asset_type === 'surf_vessels'">Surf Vessels</x-assets.asset-type-btn>
                <x-assets.asset-type-btn wire:click="$set('asset_type', 'subsea_pipelines')" :active="$this->asset_type === 'subsea_pipelines'">Subsea Pipelines</x-assets.asset-type-btn>
                <x-assets.asset-type-btn wire:click="$set('asset_type', 'points_of_interest')" :active="$this->asset_type === 'points_of_interest'">Points of Interest</x-assets.asset-type-btn>
            </div>

            <div>
                @switch($this->asset_type)
                    @case('subsea_assets')
                        <livewire:subsea-assets />
                        @break
                    @case('surf_vessels')
                        <livewire:surf-vessels />
                        @break
                    @case('subsea_pipelines')
                        <livewire:subsea-pipelines />
                        @break
                    @case('points_of_interest')
                        <livewire:all-points-of-interest />
                        @break
                @endswitch
            </div>
        </div>
    </div>
</div>
