<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$this->asset->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="md:grid grid-cols-[2fr_3fr]">
                <div class="space-y-4">
                    <x-card>
                        <x-slot:header>
                            Asset Health
                        </x-slot:header>

                        <div class="p-5 flex items-center space-x-2">
                            <i class="{{$this->asset->health->icon()}} fa-2xl me-2"></i>

                            <p class="text-lg font-semibold">{{$this->asset->health->display()}}</p>
                        </div>
                    </x-card>

                    <x-card>
                        <x-slot:header>
                            <i class="fa-solid fa-sensor-triangle-exclamation me-2"></i>
                            Alerts
                        </x-slot:header>

                        <div>
                            @forelse($this->asset->alerts as $alert)
                                <p class="border-b px-5 py-2">{{$alert->alert}}</p>
                            @empty
                                <p class="px-5 py-2">No alerts</p>
                            @endforelse
                        </div>
                    </x-card>

                    <x-card>
                        <div class="md:flex justify-center text-sm">
                            <div class="md:border-e py-2 px-4 md:border-b-0 border-b">
                                <p class="font-semibold pb-2">Temperature</p>

                                <p>
                                    <i class="fa-solid fa-temperature-three-quarters me-2"></i>
                                    {{$this->asset->temperature}}
                                </p>
                            </div>
                            <div class="md:border-e py-2 px-4 md:border-b-0 border-b">
                                <p class="font-semibold pb-2">Flow Rate</p>

                                <p>
                                    <i class="fa-solid fa-monitor-waveform me-2"></i>
                                    {{$this->asset->flow_rate}}
                                </p>
                            </div>
                            <div class="md:border-e md:border-b-0 border-b py-2 px-4">
                                <p class="font-semibold pb-2">Anomalies</p>

                                <p>
                                    <i class="fa-solid fa-question me-2"></i>
                                    {{$this->asset->open_anomaly_count}}
                                </p>
                            </div>
                            <div class="py-2 px-4 md:border-b-0 border-b">
                                <p class="font-semibold pb-2">Pressure</p>
                                <p>
                                    <i class="fa-solid fa-tire-pressure-warning me-2"></i>
                                    {{$this->asset->pressure}}
                                </p>
                            </div>
                        </div>
                    </x-card>
                </div>

                <div class="md:px-5 md:my-0 my-2">
                    <x-card>
                        <x-slot:header>Important Dates</x-slot:header>
                        <div class="md:grid grid-cols-2 p-2 md:space-y-0 space-y-2">
                            <p class="border-e">Last Inspection Date</p>
                            <p class="md:px-2 font-semibold md:border-b-0 border-b md:pb-0 pb-2">{{$this->asset->last_inspection->format('d-m-Y')}}</p>
                        </div>
                        <div class="md:grid grid-cols-2 p-2 md:space-y-0 space-y-2">
                            <p class="border-e">Next Date of Maintenance</p>
                            <p class="md:px-2 font-semibold">{{$this->asset->next_maintenance->format('d-m-Y')}}</p>
                        </div>
                    </x-card>

                    <x-card class="mt-4">
                        <x-slot:header>Connected Assets</x-slot:header>

                        <livewire:subsea-assets :connected="$this->asset" />
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</div>
