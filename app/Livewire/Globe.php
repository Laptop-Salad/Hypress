<?php

namespace App\Livewire;

use App\Models\PointsOfInterest;
use App\Models\SubseaAsset;
use App\Models\SubseaPipeline;
use App\Models\SurfVessel;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Globe extends Component
{
    #[Computed]
    public function pipelines() {
        return SubseaPipeline::all()->toArray();
    }

    #[Computed]
    public function assets() {
        return SubseaAsset::all()->toArray();
    }

    #[Computed]
    public function pointsOfInterest() {
        return PointsOfInterest::all()->toArray();
    }

    #[Computed]
    public function vessels() {
        return SurfVessel::all()->toArray();
    }

    public function render() {
        return view('livewire.globe');
    }
}
