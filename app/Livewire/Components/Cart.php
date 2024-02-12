<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Cart extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function destroy($id)
    {
        \Gloudemans\Shoppingcart\Facades\Cart::remove($id);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.components.cart');
    }
}
