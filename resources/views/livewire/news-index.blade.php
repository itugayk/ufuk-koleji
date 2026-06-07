<div>
    {{-- Başlık --}}
    <section class="relative overflow-hidden bg-navy-900 text-white">
        <x-img :src="setting('hero_image')" alt="Haberler" class="absolute inset-0 h-full w-full opacity-20" />
        <div class="absolute inset-0 bg-gradient-to-r from-navy-950 to-navy-800/80"></div>
        <div class="container-x relative py-16 sm:py-20">
            <nav class="flex items-center gap-2 text-sm text-navy-300">
                <a href="{{ url('/') }}" class="hover:text-accent-400">Ana Sayfa</a>
                @svg('heroicon-m-chevron-right', 'h-4 w-4 text-navy-500')
                <span class="text-white">Haberler & Duyurular</span>
            </nav>
            <span class="eyebrow mt-6">Güncel</span>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl">Haberler & Duyurular</h1>
            <p class="mt-4 max-w-2xl text-lg text-navy-200">Okulumuzdaki gelişmeler, etkinlikler ve önemli duyurular.</p>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="container-x">
            {{-- Filtre çubuğu --}}
            <div class="mb-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap gap-2">
                    <button wire:click="$set('kategori', '')"
                            @class(['rounded-full px-4 py-2 text-sm font-semibold transition', 'bg-navy-800 text-white' => $kategori === '', 'bg-navy-50 text-navy-600 hover:bg-navy-100' => $kategori !== ''])>
                        Tüm Kategoriler
                    </button>
                    @foreach ($categories as $cat)
                        <button wire:click="$set('kategori', '{{ $cat->slug }}')"
                                @class(['rounded-full px-4 py-2 text-sm font-semibold transition', 'bg-navy-800 text-white' => $kategori === $cat->slug, 'bg-navy-50 text-navy-600 hover:bg-navy-100' => $kategori !== $cat->slug])>
                            {{ $cat->name }} <span class="opacity-60">({{ $cat->news_count }})</span>
                        </button>
                    @endforeach
                </div>

                <div class="flex items-center gap-3">
                    {{-- Tür --}}
                    <div class="flex rounded-full bg-navy-50 p-1">
                        @foreach (['' => 'Hepsi', 'haber' => 'Haber', 'duyuru' => 'Duyuru'] as $val => $label)
                            <button wire:click="$set('tur', '{{ $val }}')"
                                    @class(['rounded-full px-3.5 py-1.5 text-sm font-semibold transition', 'bg-white text-navy-900 shadow-sm' => $tur === $val, 'text-navy-500' => $tur !== $val])>
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                    {{-- Arama --}}
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-navy-400">@svg('heroicon-m-magnifying-glass', 'h-5 w-5')</span>
                        <input type="search" wire:model.live.debounce.400ms="search" placeholder="Haber ara..."
                               class="w-full rounded-full border border-navy-200 py-2.5 pl-10 pr-4 text-sm focus:border-navy-500 focus:ring-navy-500 lg:w-64">
                    </div>
                </div>
            </div>

            {{-- Sonuçlar --}}
            <div wire:loading.class="opacity-40" class="transition">
                @if ($news->isNotEmpty())
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($news as $item)
                            <x-news-card :news="$item" wire:key="news-{{ $item->id }}" />
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $news->links() }}
                    </div>
                @else
                    <div class="rounded-3xl bg-navy-50 py-20 text-center">
                        @svg('heroicon-o-inbox', 'mx-auto h-14 w-14 text-navy-300')
                        <p class="mt-4 text-lg font-semibold text-navy-700">Sonuç bulunamadı</p>
                        <p class="mt-1 text-navy-400">Arama veya filtre kriterlerinizi değiştirmeyi deneyin.</p>
                        <button wire:click="clearFilters" class="btn-outline mt-6 py-2.5">Filtreleri Temizle</button>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
