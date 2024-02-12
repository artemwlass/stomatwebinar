<?php

namespace App\Livewire\Home\Components;

use App\Models\Webinar;
use Livewire\Component;

class ServicesBlock extends Component
{
    public $home;
    public function render()
    {
        $webinars = Webinar::orderByDesc('order')->select('id', 'title', 'order', 'image', 'slug')->where('is_active', true)->get();

        return view('livewire.home.components.services-block', compact('webinars'));
    }
}
