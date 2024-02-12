<?php

namespace App\Livewire\Webinar;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Webinar extends Component
{
    public $webinar;

    public function mount($slug)
    {
        $this->webinar = \App\Models\Webinar::where('slug', $slug)->first();

        SEOMeta::setTitle($this->webinar->seo['title']);
        SEOMeta::setDescription($this->webinar->seo['meta_description']);
        SEOMeta::addKeyword($this->webinar->seo['keywords']);

        OpenGraph::setTitle($this->webinar->seo['og_title']);
        OpenGraph::setDescription($this->webinar->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $this->webinar->seo['og_image']));
        OpenGraph::setType($this->webinar->seo['og_type']);
        OpenGraph::setUrl($this->webinar->seo['og_url']);
    }

    public function render()
    {
        return view('livewire.webinar.webinar');
    }
}
