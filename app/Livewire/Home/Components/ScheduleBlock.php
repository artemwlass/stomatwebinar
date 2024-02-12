<?php

namespace App\Livewire\Home\Components;

use Livewire\Component;

class ScheduleBlock extends Component
{
    public $home;
    public function render()
    {
        return view('livewire.home.components.schedule-block');
    }
}
