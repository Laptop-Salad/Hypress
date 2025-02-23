<div {{$attributes->merge(['class' => 'bg-white shadow-sm rounded-md'])}}>
    @isset($header)
        <div class="p-5 border-b">
            <h2 class="font-semibold text-lg">{{$header}}</h2>
        </div>
    @endisset
    {{$slot}}
</div>
