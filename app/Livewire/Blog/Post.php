<?php

namespace App\Livewire\Blog;

use App\Support\AchievementPoints;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Post extends Component
{
    public $post;

    public function mount($slug)
    {
        $this->post = \App\Models\Post::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$this->post) {
            abort(404);
        }

        AchievementPoints::awardOnce(auth()->id(), 'article_read', $this->post, 'Прочитано статтю: ' . $this->post->title);

        SEOMeta::setTitle(data_get($this->post, 'seo.title', $this->post->title));
        SEOMeta::setDescription(data_get($this->post, 'seo.meta_description', ''));

        $keywords = data_get($this->post, 'seo.keywords');
        if ($keywords) {
            SEOMeta::addKeyword($keywords);
        }

        OpenGraph::setTitle(data_get($this->post, 'seo.og_title', $this->post->title));
        OpenGraph::setDescription(data_get($this->post, 'seo.og_description', ''));

        $ogImage = data_get($this->post, 'seo.og_image');
        if ($ogImage) {
            OpenGraph::addImage(asset('storage/' . $ogImage));
        }
    }
    public function render()
    {
        return view('livewire.blog.post')
            ->layout('components.layouts.account');
    }
}
