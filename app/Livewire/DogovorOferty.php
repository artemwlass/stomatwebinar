<?php

namespace App\Livewire;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class DogovorOferty extends Component
{
    public function render()
    {
        $dogovor = \App\Models\DogovorOferty::first();

        SEOMeta::setTitle($dogovor->seo['title']);
        SEOMeta::setDescription($dogovor->seo['meta_description']);
        SEOMeta::addKeyword($dogovor->seo['keywords']);

        OpenGraph::setTitle($dogovor->seo['og_title']);
        OpenGraph::setDescription($dogovor->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $dogovor->seo['og_image']));
        OpenGraph::setType($dogovor->seo['og_type']);
        OpenGraph::setUrl($dogovor->seo['og_url']);

        return view('livewire.dogovor-oferty', compact('dogovor'));
    }
}
