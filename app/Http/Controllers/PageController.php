<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Event;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\Level;
use App\Models\News;
use App\Models\Page;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'levels' => Level::active()->get(),
            'features' => Feature::active()->get(),
            'stats' => Achievement::active()->stats()->get(),
            'achievements' => Achievement::active()->where('is_stat', false)->limit(4)->get(),
            'featuredNews' => News::published()->where('is_featured', true)->latest('published_at')->limit(3)->get(),
            'latestNews' => News::published()->latest('published_at')->limit(6)->get(),
            'gallery' => GalleryItem::active()->limit(8)->get(),
            'testimonials' => Testimonial::active()->get(),
            'events' => Event::upcoming()->limit(3)->get(),
        ]);
    }

    public function about()
    {
        return view('pages.kurumsal', [
            'pages' => Page::orderBy('sort')->get()->keyBy('key'),
            'stats' => Achievement::active()->stats()->get(),
            'levels' => Level::active()->get(),
        ]);
    }

    public function levels()
    {
        return view('pages.kademeler', [
            'levels' => Level::active()->get(),
        ]);
    }

    public function levelShow(Level $level)
    {
        abort_unless($level->is_active, 404);

        return view('pages.kademe', [
            'level' => $level,
            'others' => Level::active()->where('id', '!=', $level->id)->get(),
            'features' => Feature::active()->limit(3)->get(),
        ]);
    }

    public function educationModel()
    {
        return view('pages.egitim-modeli', [
            'features' => Feature::active()->get(),
            'page' => Page::byKey('egitim-modeli'),
            'stats' => Achievement::active()->stats()->get(),
        ]);
    }

    public function campus()
    {
        $items = GalleryItem::active()->get();

        return view('pages.kampus', [
            'gallery' => $items,
            'categories' => $items->pluck('category')->filter()->unique()->values(),
        ]);
    }

    public function achievements()
    {
        return view('pages.basarilarimiz', [
            'stats' => Achievement::active()->stats()->get(),
            'stories' => Achievement::active()->where('is_stat', false)->get(),
        ]);
    }
}
