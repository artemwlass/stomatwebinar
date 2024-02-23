<?php

namespace App\Livewire\FreeWebinarPreorder;

use App\Models\FreeWebinarPreorder;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Index extends Component
{
    public $webinar;

    public function mount($slug)
    {
        $this->webinar = FreeWebinarPreorder::where('slug', $slug)->first();

        if (!$this->webinar) {
            abort(404);
        }

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
        return view('livewire.free-webinar-preorder.index');
    }
}
