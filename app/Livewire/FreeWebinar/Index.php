<?php

namespace App\Livewire\FreeWebinar;

use App\Models\FreeWebinar;
use App\Models\FreeWebinarPage;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Index extends Component
{
    public $title;

    public function render()
    {
        $freeWebinar = FreeWebinarPage::first();

        SEOMeta::setTitle($freeWebinar->seo['title']);
        SEOMeta::setDescription($freeWebinar->seo['meta_description']);
        SEOMeta::addKeyword($freeWebinar->seo['keywords']);

        OpenGraph::setTitle($freeWebinar->seo['og_title']);
        OpenGraph::setDescription($freeWebinar->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $freeWebinar->seo['og_image']));
        OpenGraph::setType($freeWebinar->seo['og_type']);
        OpenGraph::setUrl($freeWebinar->seo['og_url']);

        $this->title = $freeWebinar->title;

        $webinars = FreeWebinar::orderBy('order', 'asc')->get();

        return view('livewire.free-webinar.index', compact('webinars'));
    }
}
