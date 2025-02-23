<?php

namespace App\Livewire;

use App\Models\SubseaAsset;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowAsset extends Component
{
    #[Locked]
    public SubseaAsset $asset;

    public function render()
    {
        return view('livewire.show-asset');
    }
}
