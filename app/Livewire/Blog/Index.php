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

        SEOMeta::setTitle(data_get($blog, 'seo.title', 'Блог'));
        SEOMeta::setDescription(data_get($blog, 'seo.meta_description', 'Корисні матеріали для стоматологів.'));

        $keywords = data_get($blog, 'seo.keywords');
        if ($keywords) {
            SEOMeta::addKeyword($keywords);
        }

        OpenGraph::setTitle(data_get($blog, 'seo.og_title', 'Блог'));
        OpenGraph::setDescription(data_get($blog, 'seo.og_description', 'Корисні матеріали для стоматологів.'));

        $ogImage = data_get($blog, 'seo.og_image');
        if ($ogImage) {
            OpenGraph::addImage(asset('storage/' . $ogImage));
        }

        $this->title = $blog?->title ?: 'Блог';
        $this->description = $blog?->description ?: 'Корисні матеріали, клінічні випадки та новини стоматології.';

        $posts = \App\Models\Post::query()
            ->select('id', 'title', 'slug', 'image', 'created_at')
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('livewire.blog.index', compact('posts'))
            ->layout('components.layouts.account');
    }
}
