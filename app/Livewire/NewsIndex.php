<?php

namespace App\Livewire;

use App\Models\News;
use App\Models\NewsCategory;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Haberler & Duyurular')]
class NewsIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $kategori = '';

    #[Url]
    public string $tur = '';

    public function updating($name): void
    {
        if (in_array($name, ['search', 'kategori', 'tur'])) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'kategori', 'tur']);
        $this->resetPage();
    }

    public function render()
    {
        $query = News::query()
            ->with('category')
            ->published()
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w
                ->where('title', 'like', "%{$this->search}%")
                ->orWhere('excerpt', 'like', "%{$this->search}%")))
            ->when($this->tur, fn ($q) => $q->where('type', $this->tur))
            ->when($this->kategori, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $this->kategori)))
            ->latest('published_at');

        return view('livewire.news-index', [
            'news' => $query->paginate(9),
            'categories' => NewsCategory::withCount(['news' => fn ($q) => $q->published()])->get(),
        ])->layout('components.layouts.app');
    }
}
