<?php

namespace App\Livewire;

use App\Models\SubseaAsset;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SubseaAssets extends Component
{
    #[Computed]
    public function assets() {
        return SubseaAsset::query()
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.subsea-assets');
    }
}
