<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Assets extends Component
{
    use WithPagination;

    #[Url]
    public $asset_type = 'subsea_assets';


    public function render()
    {
        return view('livewire.assets');
    }
}
