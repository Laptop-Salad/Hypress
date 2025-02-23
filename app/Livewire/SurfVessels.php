<?php

namespace App\Livewire;

use App\Models\SurfVessel;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SurfVessels extends Component
{

    #[Computed]
    public function vessels() {
        return SurfVessel::query()
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.surf-vessels');
    }
}
