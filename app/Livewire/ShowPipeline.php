<?php

namespace App\Livewire;

use App\Models\SubseaPipeline;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowPipeline extends Component
{
    #[Locked]
    public SubseaPipeline $pipeline;

    public function render()
    {
        return view('livewire.show-pipeline');
    }
}
