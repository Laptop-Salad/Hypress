@props([
    'active'
])

<button
    @class([
        'p-2 w-full hover:bg-purple-300 text-start border-b',
        'bg-purple-300' => $active
    ])
    {{$attributes}}
>
    {{$slot}}
</button>
