<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$this->vessel->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="md:grid grid-cols-[2fr_3fr]">
                <div class="space-y-4">
                    <x-card>
                        <x-slot:header>
                            <i class="fa-solid fa-sensor-triangle-exclamation me-2"></i>
                            Alerts
                        </x-slot:header>

                        <div>
                            @forelse($this->vessel->alerts as $alert)
                                <p class="border-b px-5 py-2">{{$alert->alert}}</p>
                            @empty
                                <p class="px-5 py-2">No alerts</p>
                            @endforelse
                        </div>
                    </x-card>

                    <x-card>
                        <x-slot:header>
                            Asset Status
                        </x-slot:header>

                        <div class="p-5 flex items-center space-x-2">
                            <p class="text-lg font-semibold">{{$this->vessel->status}}</p>
                        </div>
                    </x-card>

                    <x-card>
                        <x-slot:header>
                            Asset Destination
                        </x-slot:header>

                        <div class="p-5 flex items-center space-x-2">
                            <p class="text-lg font-semibold">{{$this->vessel->destination}}</p>
                        </div>
                    </x-card>
                </div>

                <div class="md:px-5 md:my-0 my-2 space-y-4">
                    <x-card>
                        <x-slot:header>Important Dates</x-slot:header>
                        <div class="md:grid grid-cols-2 p-2 md:space-y-0 space-y-2">
                            <p class="border-e">Last Inspection Date</p>
                            <p class="md:px-2 font-semibold md:border-b-0 border-b md:pb-0 pb-2">{{$this->vessel->last_inspection->format('d-m-Y')}}</p>
                        </div>
                        <div class="md:grid grid-cols-2 p-2 md:space-y-0 space-y-2">
                            <p class="border-e">ETA</p>
                            <p class="md:px-2 font-semibold">{{$this->vessel->eta->format('d-m-Y h:m:s')}}</p>
                        </div>
                    </x-card>

                    <x-card>
                        <div class="md:flex justify-center text-sm">
                            <div class="md:border-e py-2 px-4 md:border-b-0 border-b">
                                <p class="font-semibold pb-2">Temperature</p>

                                <p>
                                    <i class="fa-solid fa-temperature-three-quarters me-2"></i>
                                    {{$this->vessel->temperature}}
                                </p>
                            </div>
                            <div class="md:border-e py-2 px-4 md:border-b-0 border-b">
                                <p class="font-semibold pb-2">Wind Speed</p>

                                <p>
                                    <i class="fa-solid fa-wind me-2"></i>
                                    {{$this->vessel->wind_speed}}
                                </p>
                            </div>
                            <div class="md:border-e md:border-b-0 border-b py-2 px-4">
                                <p class="font-semibold pb-2">Wave Height</p>

                                <p>
                                    <i class="fa-solid fa-wave me-2"></i>
                                    {{$this->vessel->wave_height}}
                                </p>
                            </div>
                            <div class="py-2 px-4 md:border-b-0 border-b">
                                <p class="font-semibold pb-2">Fuel Level</p>
                                <p>
                                    <i class="fa-solid fa-gas-pump me-2"></i>
                                    {{$this->vessel->fuel_level}}
                                </p>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</div>
