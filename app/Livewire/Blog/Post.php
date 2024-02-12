<?php

namespace App\Livewire\Blog;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Post extends Component
{
    public $post;

    public function mount($slug)
    {
        $this->post = \App\Models\Post::where('slug', $slug)->first();

        if (!$this->post) {
            abort(404);
        }

        SEOMeta::setTitle($this->post->seo['title']);
        SEOMeta::setDescription($this->post->seo['meta_description']);
        SEOMeta::addKeyword($this->post->seo['keywords']);

        OpenGraph::setTitle($this->post->seo['og_title']);
        OpenGraph::setDescription($this->post->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $this->post->seo['og_image']));
        OpenGraph::setType($this->post->seo['og_type']);
        OpenGraph::setUrl($this->post->seo['og_url']);
    }
    public function render()
    {
        return view('livewire.blog.post');
    }
}
