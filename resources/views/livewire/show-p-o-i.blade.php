<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$this->poi->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="md:grid grid-cols-[2fr_3fr]">
                <div class="space-y-4">
                    <x-card class="p-5">
                        <p>{{$this->poi->description}}</p>
                    </x-card>
                </div>

                <div class="md:px-5 md:my-0 my-2">
                </div>
            </div>
        </div>
    </div>
</div>
