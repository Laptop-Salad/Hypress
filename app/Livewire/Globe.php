<?php

namespace App\Livewire;

use App\Models\SubseaPipeline;
use Livewire\Component;

class Globe extends Component
{
    public function assets() {
        $pipelines = SubseaPipeline::all();

        return $pipelines;
    }

    public function render() {
        return view('livewire.globe');
    }
}
