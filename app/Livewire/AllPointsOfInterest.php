<?php

namespace App\Livewire;

use App\Models\PointsOfInterest;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AllPointsOfInterest extends Component
{
    #[Computed]
    public function pointsOfInterest() {
        return PointsOfInterest::query()
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.points-of-interest');
    }
}
