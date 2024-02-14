<?php

namespace App\Livewire;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use GuzzleHttp\Exception\InvalidArgumentException;
use Livewire\Component;

class Payments extends Component
{
    public function render()
    {

        $payment = \App\Models\Payment::first();

        SEOMeta::setTitle($payment->seo['title']);
        SEOMeta::setDescription($payment->seo['meta_description']);
        SEOMeta::addKeyword($payment->seo['keywords']);

        OpenGraph::setTitle($payment->seo['og_title']);
        OpenGraph::setDescription($payment->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $payment->seo['og_image']));
        OpenGraph::setType($payment->seo['og_type']);
        OpenGraph::setUrl($payment->seo['og_url']);

        return view('livewire.payments', compact('payment'));
    }
}
