<?php

namespace App\Livewire;

use App\Models\Alert;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Alerts extends Component
{
    use WithPagination;

    #[Computed]
    public function alerts() {
        return Alert::query()
            ->with('alertable')
            ->paginate(5);
    }

    public function render(){
        return view('livewire.alerts');
    }
}
