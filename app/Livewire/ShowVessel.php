<?php

namespace App\Livewire;

use App\Models\SurfVessel;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowVessel extends Component
{
    #[Locked]
    public SurfVessel $vessel;

    public function render()
    {
        return view('livewire.show-vessel');
    }
}
