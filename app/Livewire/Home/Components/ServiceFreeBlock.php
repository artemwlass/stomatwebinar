<?php

namespace App\Livewire\Home\Components;

use App\Models\FreeWebinar;
use Livewire\Component;

class ServiceFreeBlock extends Component
{
    public function render()
    {
        $webinars = FreeWebinar::latest()->take(3)->get();

        return view('livewire.home.components.service-free-block', compact('webinars'));
    }
}
