<?php

namespace App\Livewire;

use App\Models\SubseaPipeline;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SubseaPipelines extends Component
{

    #[Computed]
    public function pipelines() {
        return SubseaPipeline::query()
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.subsea-pipelines');
    }
}
