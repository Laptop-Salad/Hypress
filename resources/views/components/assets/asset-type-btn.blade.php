@props([
    'active'
])

<button
    @class([
        'p-2 w-full hover:bg-purple-100 text-start border-b',
        'bg-purple-100' => $active
    ])
    {{$attributes}}
>
    {{$slot}}
</button>
