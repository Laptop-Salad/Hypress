<div class="p-5">
    <table class="w-full">
        <thead>
        <tr class="border-b border-indigo-500">
            <th class="text-start">Name</th>
            <th class="text-start md:table-cell hidden">Status</th>
            <th class="text-start md:table-cell hidden">Destination</th>
            <th class="text-start md:table-cell hidden">ETA</th>
        </tr>
        </thead>
        <tbody>
        @foreach($this->vessels as $asset)
            <tr class="border-b border-gray-200 relative full-link-header hover:bg-purple-50 cursor-pointer">
                <td class="p-2">
                    <a
                        class="full-link"
                        wire:navigate.hover
                        href="{{route('vessels.show', $asset)}}"
                    >
                        <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>
                        {{ $asset->name }}
                    </a>
                </td>
                <td class="p-2 md:table-cell hidden">{{$asset->status}}</td>
                <td class="p-2 md:table-cell hidden">{{$asset->destination}}</td>
                <td class="p-2 md:table-cell hidden">{{$asset->eta->format('d-m-Y h:m:s')}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
