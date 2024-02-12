<?php

namespace App\Livewire\Home\Components;

use App\Models\HeaderAndFooter;
use Livewire\Component;

class AboutBlock extends Component
{
    public $home;

    public function render()
    {
        $socials = HeaderAndFooter::select('footer_facebook','footer_telegram', 'footer_instagram', 'footer_youtube')->first();

        return view('livewire.home.components.about-block', compact('socials'));
    }
}
