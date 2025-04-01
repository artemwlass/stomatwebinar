<?php

namespace App\Livewire\Home\Components;

use App\Models\AnswerQuestion;
use Livewire\Component;

class FaqBlock extends Component
{
    public $data;

    public function mount()
    {
        $this->data = AnswerQuestion::all();
    }
    public function render()
    {
        return view('livewire.home.components.faq-block');
    }
}
