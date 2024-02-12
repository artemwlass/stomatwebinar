<?php

namespace App\Livewire\Components;

use App\Models\AnswerQuestion;
use Livewire\Component;

class Faq extends Component
{
    public $webinar;
    public $faq;

    public function render()
    {
        if ($this->webinar['active'] == true)
        {
            $this->faq = AnswerQuestion::all();
        }
        return view('livewire.components.faq');
    }
}
