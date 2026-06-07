@php
    $links = [
        ['label' => 'Ana Sayfa', 'url' => url('/'), 'active' => request()->is('/')],
        ['label' => 'Kurumsal', 'url' => url('/kurumsal'), 'active' => request()->is('kurumsal')],
        ['label' => 'Eğitim Modeli', 'url' => url('/egitim-modeli'), 'active' => request()->is('egitim-modeli')],
        ['label' => 'Kampüs', 'url' => url('/kampus'), 'active' => request()->is('kampus')],
        ['label' => 'Haberler', 'url' => url('/haberler'), 'active' => request()->is('haberler*')],
        ['label' => 'Başarılarımız', 'url' => url('/basarilarimiz'), 'active' => request()->is('basarilarimiz')],
        ['label' => 'İletişim', 'url' => url('/iletisim'), 'active' => request()->is('iletisim')],
    ];
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 10"
    class="sticky top-0 z-50 bg-white/95 backdrop-blur transition-shadow"
    :class="scrolled ? 'shadow-md' : 'shadow-sm'"
>
    <div class="container-x">
        <nav class="flex h-18 items-center justify-between py-3" aria-label="Ana menü">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-navy-800 text-accent-400 shadow-lg shadow-navy-800/20">
                    @svg('heroicon-s-academic-cap', 'h-7 w-7')
                </span>
                <span class="flex flex-col leading-none">
                    <span class="font-display text-lg font-extrabold text-navy-800">{{ $siteSettings['site_name'] ?? 'Ufuk Koleji' }}</span>
                    <span class="text-[11px] font-medium tracking-wide text-navy-400">{{ $siteSettings['site_slogan'] ?? 'Geleceğe Açılan Ufuk' }}</span>
                </span>
            </a>

            {{-- Desktop menu --}}
            <div class="hidden items-center gap-1 lg:flex">
                @foreach ($links as $i => $link)
                    @if ($i === 2)
                        {{-- Kademeler dropdown --}}
                        <div class="relative" x-data="{ d: false }" @mouseenter="d = true" @mouseleave="d = false">
                            <button class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-semibold text-navy-700 transition hover:bg-navy-50 hover:text-navy-900 {{ request()->is('kademeler*') ? 'text-navy-900' : '' }}">
                                Kademeler
                                @svg('heroicon-m-chevron-down', 'h-4 w-4')
                            </button>
                            <div x-show="d" x-transition x-cloak class="absolute left-0 top-full w-60 pt-2">
                                <div class="overflow-hidden rounded-2xl bg-white p-2 shadow-xl ring-1 ring-navy-900/5">
                                    @foreach ($navLevels as $lvl)
                                        <a href="{{ url('/kademeler/'.$lvl->slug) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-navy-50">
                                            <span class="flex h-9 w-9 items-center justify-center rounded-lg text-white" style="background: {{ $lvl->color }}">
                                                @svg($lvl->icon ?: 'heroicon-o-academic-cap', 'h-5 w-5')
                                            </span>
                                            <span>
                                                <span class="block text-sm font-semibold text-navy-800">{{ $lvl->name }}</span>
                                                <span class="block text-xs text-navy-400">{{ $lvl->age_range }}</span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <a href="{{ $link['url'] }}" class="rounded-lg px-3 py-2 text-sm font-semibold transition hover:bg-navy-50 hover:text-navy-900 {{ $link['active'] ? 'text-navy-900' : 'text-navy-700' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="hidden items-center gap-3 lg:flex">
                <a href="{{ url('/kayit') }}" class="btn-primary px-5 py-2.5">
                    @svg('heroicon-m-pencil-square', 'h-4 w-4')
                    Kayıt Başvurusu
                </a>
            </div>

            {{-- Mobile toggle --}}
            <button @click="open = !open" class="inline-flex items-center justify-center rounded-lg p-2 text-navy-800 lg:hidden" aria-label="Menü">
                <span x-show="!open">@svg('heroicon-o-bars-3', 'h-7 w-7')</span>
                <span x-show="open" x-cloak>@svg('heroicon-o-x-mark', 'h-7 w-7')</span>
            </button>
        </nav>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition x-cloak class="border-t border-navy-100 bg-white lg:hidden">
        <div class="container-x space-y-1 py-4">
            <a href="{{ url('/') }}" class="block rounded-lg px-3 py-2 font-semibold text-navy-700 hover:bg-navy-50">Ana Sayfa</a>
            <a href="{{ url('/kurumsal') }}" class="block rounded-lg px-3 py-2 font-semibold text-navy-700 hover:bg-navy-50">Kurumsal</a>
            <div class="px-3 pt-2 text-xs font-bold uppercase tracking-wide text-navy-400">Kademeler</div>
            @foreach ($navLevels as $lvl)
                <a href="{{ url('/kademeler/'.$lvl->slug) }}" class="block rounded-lg px-3 py-2 text-navy-700 hover:bg-navy-50">— {{ $lvl->name }}</a>
            @endforeach
            <a href="{{ url('/egitim-modeli') }}" class="block rounded-lg px-3 py-2 font-semibold text-navy-700 hover:bg-navy-50">Eğitim Modeli</a>
            <a href="{{ url('/kampus') }}" class="block rounded-lg px-3 py-2 font-semibold text-navy-700 hover:bg-navy-50">Kampüs</a>
            <a href="{{ url('/haberler') }}" class="block rounded-lg px-3 py-2 font-semibold text-navy-700 hover:bg-navy-50">Haberler</a>
            <a href="{{ url('/basarilarimiz') }}" class="block rounded-lg px-3 py-2 font-semibold text-navy-700 hover:bg-navy-50">Başarılarımız</a>
            <a href="{{ url('/iletisim') }}" class="block rounded-lg px-3 py-2 font-semibold text-navy-700 hover:bg-navy-50">İletişim</a>
            <a href="{{ url('/kayit') }}" class="btn-primary mt-3 w-full">Kayıt Başvurusu</a>
        </div>
    </div>
</header>
