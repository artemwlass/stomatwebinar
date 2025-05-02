<?php

namespace App\Livewire\Blog;

use App\Models\BlogPage;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Index extends Component
{
    public $title;
    public $description;

    public function render()
    {
        $blog = BlogPage::first();

        SEOMeta::setTitle($blog->seo['title']);
        SEOMeta::setDescription($blog->seo['meta_description']);
        SEOMeta::addKeyword($blog->seo['keywords']);

        OpenGraph::setTitle($blog->seo['og_title']);
        OpenGraph::setDescription($blog->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $blog->seo['og_image']));
        OpenGraph::setType($blog->seo['og_type']);
        OpenGraph::setUrl($blog->seo['og_url']);

        $this->title = $blog->title;
        $this->description = $blog->description;

        $posts = \App\Models\Post::select('title', 'slug', 'image')->where('is_active', true)->get();

        return view('livewire.blog.index', compact('posts'));
    }
}
