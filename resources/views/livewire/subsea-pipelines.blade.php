<div class="p-5">
    <table class="w-full">
        <thead>
        <tr class="border-b border-indigo-500">
            <th class="text-start">Name</th>
            <th class="text-start">Health</th>
            <th class="text-start md:table-cell hidden">Anomalies</th>
            <th class="text-start md:table-cell hidden">Pressure</th>
            <th class="text-start md:table-cell hidden">Temperature</th>
            <th class="text-start md:table-cell hidden">Flow Rate</th>
        </tr>
        </thead>
        <tbody>
        @foreach($this->pipelines as $asset)
            <tr class="border-b border-gray-200 relative full-link-header hover:bg-purple-50 cursor-pointer {{$asset->health->textColour()}}">
                <td class="p-2">
                    <a
                        class="full-link"
                        wire:navigate.hover
                        href="{{route('pipelines.show', $asset)}}"
                    >
                        <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>
                        {{ $asset->name }}
                    </a>
                </td>
                <td>
                    <i class="{{$asset->health->icon()}} me-2"></i>

                    {{$asset->health->display()}}
                </td>
                <td class="p-2 md:table-cell hidden">{{$asset->open_anomaly_count}}</td>
                <td class="p-2 md:table-cell hidden">{{$asset->pressure}}</td>
                <td class="p-2 md:table-cell hidden">{{$asset->temperature}}</td>
                <td class="p-2 md:table-cell hidden">{{$asset->flow_rate}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
