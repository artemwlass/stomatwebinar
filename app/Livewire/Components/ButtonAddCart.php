<?php

namespace App\Livewire\Components;


use App\Models\Webinar;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ButtonAddCart extends Component
{
    public $webinar_id;
    public $color_button;

    public function store()
    {
        // Поиск вебинара в корзине по его идентификатору
        $exists = Cart::search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->webinar_id;
        })->isNotEmpty();
        if (!$exists) {
            $webinar = Webinar::find($this->webinar_id);
            Cart::add(
                $webinar->id,
                $webinar->title,
                1,
                $webinar->price,
                ['date' => $webinar->date, 'time' => $webinar->time]
            )->associate('\App\Models\Webinar');
            $this->dispatch('cartUpdated');
            $this->dispatch('openCart');
        }

    }




    public function render()
    {
        return view('livewire.components.button-add-cart');
    }
}
