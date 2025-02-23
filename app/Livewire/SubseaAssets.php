<?php

namespace App\Livewire;

use App\Models\SubseaAsset;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SubseaAssets extends Component
{
    public SubseaAsset $connected;

    #[Computed]
    public function assets() {
        if (isset($this->connected)) {
            return $this->connected->connectedToAssets()
                ->orderBy('name')
                ->paginate();
        }

        return SubseaAsset::query()
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.subsea-assets');
    }
}
