<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class Assets extends Component
{
    public $asset_type = 'subsea_assets';

    #[Computed]
    public function assets() {

    }

    public function render()
    {
        return view('livewire.assets');
    }
}
