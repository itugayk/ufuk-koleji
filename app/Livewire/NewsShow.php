<?php

namespace App\Livewire;

use App\Models\News;
use Livewire\Component;

class NewsShow extends Component
{
    public News $news;

    public function mount(string $slug): void
    {
        $this->news = News::published()->with('category')->where('slug', $slug)->firstOrFail();
        $this->news->incrementQuietly('views');
    }

    public function render()
    {
        $related = News::published()
            ->where('id', '!=', $this->news->id)
            ->when($this->news->news_category_id, fn ($q) => $q->where('news_category_id', $this->news->news_category_id))
            ->latest('published_at')
            ->limit(3)
            ->get();

        if ($related->count() < 3) {
            $related = News::published()->where('id', '!=', $this->news->id)->latest('published_at')->limit(3)->get();
        }

        return view('livewire.news-show', ['related' => $related])
            ->layout('components.layouts.app', [
                'title' => $this->news->title,
                'description' => $this->news->excerpt,
                'ogImage' => $this->news->image_url,
            ]);
    }
}
