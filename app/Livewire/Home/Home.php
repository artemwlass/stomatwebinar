<?php

namespace App\Livewire\Home;

use App\Models\HomePage;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $home = HomePage::first();

        SEOMeta::setTitle($home->seo['title']);
        SEOMeta::setDescription($home->seo['meta_description']);
        SEOMeta::addKeyword($home->seo['keywords']);

        OpenGraph::setTitle($home->seo['og_title']);
        OpenGraph::setDescription($home->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $home->seo['og_image']));
        OpenGraph::setType($home->seo['og_type']);
        OpenGraph::setUrl($home->seo['og_url']);

        return view('livewire.home.home', compact('home'));
    }
}
