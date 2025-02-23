<div id="asset" class="mt-5">
    <x-card class="!bg-gray-100">
        <div class="md:flex justify-center text-sm">
            <div class="md:border-e py-2 px-4 md:border-b-0 border-b">
                <p class="font-semibold pb-2">Temperature</p>

                <p>
                    <i class="fa-solid fa-temperature-three-quarters me-2"></i>
                    <span id="assetTemperature"></span>
                </p>
            </div>
            <div class="md:border-e py-2 px-4 md:border-b-0 border-b">
                <p class="font-semibold pb-2">Flow Rate</p>

                <p>
                    <i class="fa-solid fa-monitor-waveform me-2"></i>
                    <span id="assetFlowrate"></span>
                </p>
            </div>
            <div class="md:border-e md:border-b-0 border-b py-2 px-4">
                <p class="font-semibold pb-2">Anomalies</p>

                <p>
                    <i class="fa-solid fa-question me-2"></i>
                    <span id="assetAnomalyCount"></span>
                </p>
            </div>
            <div class="py-2 px-4 md:border-b-0 border-b">
                <p class="font-semibold pb-2">Pressure</p>
                <p>
                    <i class="fa-solid fa-tire-pressure-warning me-2"></i>
                    <span id="assetPressure"></span>
                </p>
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-2 my-4">
        <x-card class="!bg-gray-100">
            <x-slot:header>
                Pipeline Health
            </x-slot:header>

            <div class="p-5 flex items-center space-x-2">
                <p class="text-lg font-semibold" id="assetHealth"></p>
            </div>
        </x-card>
    </div>
</div>
