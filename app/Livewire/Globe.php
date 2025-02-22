<?php

namespace App\Livewire;

use App\Models\SubseaPipeline;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Globe extends Component
{
    #[Computed]
    public function assets() {
        $pipelines = SubseaPipeline::all();

        return $pipelines->toArray();
    }

    public function render() {
        return view('livewire.globe');
    }
}
