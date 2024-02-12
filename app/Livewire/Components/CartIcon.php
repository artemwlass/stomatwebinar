<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CartIcon extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.components.cart-icon');
    }
}
