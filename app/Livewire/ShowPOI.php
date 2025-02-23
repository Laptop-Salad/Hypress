<?php

namespace App\Livewire;

use App\Models\PointsOfInterest;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowPOI extends Component
{
    #[Locked]
    public PointsOfInterest $poi;

    public function render()
    {
        return view('livewire.show-p-o-i');
    }
}
