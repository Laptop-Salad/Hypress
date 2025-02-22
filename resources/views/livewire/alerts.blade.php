<div>
    <div class="bg-white rounded-md shadow-md">
        <div class="border-b px-5 py-2">
            <h2 class="text-lg font-semibold">
                <i class="fa-solid fa-sensor-triangle-exclamation me-2"></i>
                Alerts
            </h2>
        </div>

        <div>
            @foreach($this->alerts as $alert)
                <div class="border-b py-2 px-5">
                   <p>{{$alert->alert}}</p>
                    <p class="text-sm text-gray-400">{{\App\Enums\AssetType::fromClass($alert->alertable_type)->display()}}</p>
                </div>
            @endforeach

            <div class="mt-4 px-5 py-2">
                {{$this->alerts->links()}}
            </div>
        </div>
    </div>
</div>
