<?php

namespace App\Livewire;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Politic extends Component
{
    public function render()
    {
        $politic = \App\Models\Politic::first();

        SEOMeta::setTitle($politic->seo['title']);
        SEOMeta::setDescription($politic->seo['meta_description']);
        SEOMeta::addKeyword($politic->seo['keywords']);

        OpenGraph::setTitle($politic->seo['og_title']);
        OpenGraph::setDescription($politic->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $politic->seo['og_image']));
        OpenGraph::setType($politic->seo['og_type']);
        OpenGraph::setUrl($politic->seo['og_url']);

        return view('livewire.politic', compact('politic'));
    }
}
