<div class="p-5">
    <table class="w-full">
        <thead>
        <tr class="border-b border-indigo-500">
            <th class="text-start">Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($this->points_of_interest as $asset)
            <tr class="border-b border-gray-200 relative full-link-header hover:bg-purple-50 cursor-pointer">
                <td class="p-2">
                    <a
                        class="full-link"
                        wire:navigate.hover
                        href="{{route('pois.show', $asset)}}"
                    >
                        <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>
                        {{ $asset->name }}
                    </a>

                    <p class="text-gray-400 text-sm">{{$asset->description}}</p>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
