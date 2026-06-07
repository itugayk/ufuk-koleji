<div>
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-900 text-white">
        <x-img :src="$news->image_url" :alt="$news->title" class="absolute inset-0 h-full w-full opacity-25" />
        <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-900/90 to-navy-800/70"></div>
        <div class="container-x relative py-16 sm:py-20">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-navy-300">
                <a href="{{ url('/') }}" class="hover:text-accent-400">Ana Sayfa</a>
                @svg('heroicon-m-chevron-right', 'h-4 w-4 text-navy-500')
                <a href="{{ url('/haberler') }}" class="hover:text-accent-400">Haberler</a>
            </nav>
            <div class="mt-6 flex flex-wrap items-center gap-3 text-sm">
                <span class="rounded-full bg-accent-500 px-3 py-1 font-bold text-navy-900">{{ $news->type_label }}</span>
                @if ($news->category)
                    <span class="rounded-full bg-white/10 px-3 py-1 font-semibold">{{ $news->category->name }}</span>
                @endif
                <span class="flex items-center gap-1.5 text-navy-300">@svg('heroicon-m-calendar-days', 'h-4 w-4') {{ optional($news->published_at)->translatedFormat('d F Y') }}</span>
                <span class="flex items-center gap-1.5 text-navy-300">@svg('heroicon-m-clock', 'h-4 w-4') {{ $news->reading_time }} dk okuma</span>
            </div>
            <h1 class="mt-5 max-w-4xl text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl lg:text-5xl">{{ $news->title }}</h1>
        </div>
    </section>

    {{-- İçerik --}}
    <section class="py-16 sm:py-20">
        <div class="container-x grid gap-12 lg:grid-cols-3">
            <article class="lg:col-span-2">
                @if ($news->image_url)
                    <x-img :src="$news->image_url" :alt="$news->title" class="mb-10 aspect-[16/9] w-full rounded-3xl shadow-lg" />
                @endif
                @if ($news->excerpt)
                    <p class="mb-6 text-xl font-medium leading-relaxed text-navy-800">{{ $news->excerpt }}</p>
                @endif
                <div class="prose-school max-w-none text-base [&_h2]:mt-8 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-navy-900 [&_ul]:list-disc [&_ul]:pl-6">
                    {!! $news->body !!}
                </div>

                @if ($news->tags)
                    <div class="mt-10 flex flex-wrap gap-2 border-t border-navy-100 pt-6">
                        @foreach ($news->tags as $tag)
                            <span class="rounded-full bg-navy-50 px-3 py-1 text-sm text-navy-600">#{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <a href="{{ url('/haberler') }}" class="mt-10 inline-flex items-center gap-2 text-sm font-semibold text-navy-700 hover:text-accent-600">
                    @svg('heroicon-m-arrow-left', 'h-4 w-4') Tüm haberlere dön
                </a>
            </article>

            {{-- İlgili --}}
            <aside>
                <div class="sticky top-24 space-y-6">
                    <div class="card overflow-hidden">
                        <div class="bg-navy-800 p-6">
                            <h3 class="text-lg font-bold text-white">İlgili İçerikler</h3>
                        </div>
                        <div class="divide-y divide-navy-100">
                            @foreach ($related as $r)
                                <a href="{{ url('/haberler/'.$r->slug) }}" class="flex gap-3 p-4 transition hover:bg-navy-50">
                                    <x-img :src="$r->image_url" :alt="$r->title" class="h-16 w-20 shrink-0 rounded-lg" />
                                    <div>
                                        <div class="line-clamp-2 text-sm font-semibold text-navy-800">{{ $r->title }}</div>
                                        <div class="mt-1 text-xs text-navy-400">{{ optional($r->published_at)->translatedFormat('d F Y') }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl bg-accent-500 p-6 text-navy-900">
                        <h3 class="text-lg font-bold">Kayıt başvurusu</h3>
                        <p class="mt-1 text-sm text-navy-800/80">Çocuğunuz için yerinizi ayırtın.</p>
                        <a href="{{ url('/kayit') }}" class="btn-navy mt-4 w-full">Hemen Başvur</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</div>
