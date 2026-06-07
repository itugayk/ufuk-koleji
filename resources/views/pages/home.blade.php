<x-layouts.app>
    {{-- ============================ HERO ============================ --}}
    <section class="relative overflow-hidden bg-navy-900 text-white">
        <x-img :src="setting('hero_image')" alt="Ufuk Koleji kampüs" class="absolute inset-0 h-full w-full opacity-30" />
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 via-navy-900/95 to-navy-800/70"></div>
        <div class="absolute -left-20 top-1/3 h-72 w-72 rounded-full bg-accent-500/15 blur-3xl"></div>
        <div class="absolute -right-10 -top-10 h-72 w-72 rounded-full bg-navy-500/30 blur-3xl"></div>

        <div class="container-x relative py-20 sm:py-28 lg:py-32">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-accent-300 ring-1 ring-white/20">
                    @svg('heroicon-s-sparkles', 'h-4 w-4')
                    {{ setting('founded_year', '1998') }}'den beri eğitimde güven
                </span>
                <h1 class="mt-6 text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl">
                    {{ setting('hero_title', 'Çocuğunuzun Ufkunu Birlikte Genişletelim') }}
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-navy-100 sm:text-xl">
                    {{ setting('hero_subtitle', 'Anaokulundan liseye akademik başarıyı sosyal gelişim ve değerler eğitimiyle harmanlıyoruz.') }}
                </p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ url('/kayit') }}" class="btn-primary text-base">
                        @svg('heroicon-m-pencil-square', 'h-5 w-5')
                        Kayıt Başvurusu
                    </a>
                    <a href="{{ url('/kampus') }}" class="btn-ghost text-base">
                        @svg('heroicon-m-play-circle', 'h-5 w-5')
                        Kampüsü Gezin
                    </a>
                </div>

                {{-- Mini stats --}}
                <dl class="mt-14 grid max-w-2xl grid-cols-2 gap-6 border-t border-white/15 pt-8 sm:grid-cols-4">
                    @foreach ($stats->take(4) as $stat)
                        <div>
                            <dt class="text-3xl font-extrabold text-accent-400">{{ number_format($stat->value) }}{{ $stat->suffix }}</dt>
                            <dd class="mt-1 text-sm text-navy-200">{{ $stat->title }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>

        <div class="h-6 bg-gradient-to-b from-transparent to-white/0"></div>
    </section>

    {{-- ============================ KADEMELER ============================ --}}
    <section class="bg-navy-50 py-20 sm:py-24">
        <div class="container-x">
            <x-section-heading
                eyebrow="Kademelerimiz"
                title="Her yaşa uygun, bütüncül eğitim yolculuğu"
                subtitle="Anaokulundan liseye kadar her kademede çocuğunuzun gelişimine özel, modern bir eğitim programı." />

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($levels as $level)
                    <a href="{{ url('/kademeler/'.$level->slug) }}" class="group card relative flex flex-col overflow-hidden">
                        <div class="relative h-40 overflow-hidden">
                            <x-img :src="$level->image_url" :alt="$level->name" class="h-full w-full transition duration-500 group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/80 to-transparent"></div>
                            <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-navy-800">
                                {{ $level->age_range }}
                            </span>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <div class="-mt-10 mb-3 flex h-12 w-12 items-center justify-center rounded-xl text-white shadow-lg ring-4 ring-white" style="background: {{ $level->color }}">
                                @svg($level->icon ?: 'heroicon-o-academic-cap', 'h-6 w-6')
                            </div>
                            <h3 class="text-lg font-bold text-navy-900">{{ $level->name }}</h3>
                            <p class="mt-1.5 flex-1 text-sm leading-relaxed text-navy-500">{{ $level->summary }}</p>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-navy-700 transition group-hover:gap-2.5 group-hover:text-accent-600">
                                İncele @svg('heroicon-m-arrow-right', 'h-4 w-4')
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================ EĞİTİM MODELİ / FARKIMIZ ============================ --}}
    <section class="py-20 sm:py-24">
        <div class="container-x">
            <div class="grid items-end gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <span class="eyebrow">Eğitim Modelimiz</span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-navy-900 sm:text-4xl">Farkımızı yaratan eğitim yaklaşımımız</h2>
                </div>
                <p class="text-navy-600 lg:text-right">Akademik mükemmeliyeti çağın becerileriyle birleştiren, çocuğu merkeze alan bir model.</p>
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="group card p-7">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl text-white transition group-hover:scale-110" style="background: {{ $feature->color }}">
                            @svg($feature->icon ?: 'heroicon-o-sparkles', 'h-7 w-7')
                        </div>
                        <h3 class="mt-5 text-xl font-bold text-navy-900">{{ $feature->title }}</h3>
                        <p class="mt-2.5 text-sm leading-relaxed text-navy-500">{{ $feature->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================ SAYAÇLAR ============================ --}}
    <section class="relative overflow-hidden bg-navy-800 py-16 text-white">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 30%, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        <div class="container-x relative">
            <div class="grid gap-8 text-center sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($stats as $stat)
                    <div x-data="counter({{ (int) $stat->value }})">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-accent-400">
                            @svg($stat->icon ?: 'heroicon-o-trophy', 'h-7 w-7')
                        </div>
                        <div class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                            <span x-text="formatted">0</span>{{ $stat->suffix }}
                        </div>
                        <div class="mt-2 text-sm font-medium text-navy-200">{{ $stat->title }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================ HABERLER & DUYURULAR ============================ --}}
    @if ($latestNews->isNotEmpty())
        <section class="py-20 sm:py-24">
            <div class="container-x">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="eyebrow">Haberler & Duyurular</span>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-navy-900 sm:text-4xl">Okulumuzdan son gelişmeler</h2>
                    </div>
                    <a href="{{ url('/haberler') }}" class="btn-outline py-2.5">Tümünü Gör @svg('heroicon-m-arrow-right', 'h-4 w-4')</a>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($latestNews->take(3) as $news)
                        <x-news-card :news="$news" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============================ KAMPÜS GALERİ ============================ --}}
    @if ($gallery->isNotEmpty())
        <section class="bg-navy-50 py-20 sm:py-24">
            <div class="container-x">
                <x-section-heading
                    eyebrow="Kampüsümüz"
                    title="Öğrenmenin keyifli olduğu modern bir yaşam alanı"
                    subtitle="Geniş bahçeler, donanımlı laboratuvarlar, sanat ve spor alanlarıyla öğrencilerimize ilham veren bir kampüs." />

                <div class="mt-12 grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-4">
                    @foreach ($gallery->take(8) as $i => $item)
                        <a href="{{ url('/kampus') }}" @class([
                            'group relative overflow-hidden rounded-2xl',
                            'col-span-2 row-span-2' => $i === 0,
                            'aspect-square' => $i !== 0,
                        ])>
                            <x-img :src="$item->image_url" :alt="$item->title" class="h-full w-full transition duration-500 group-hover:scale-110 {{ $i === 0 ? 'aspect-square md:aspect-auto md:h-full' : '' }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/70 via-transparent to-transparent opacity-0 transition group-hover:opacity-100"></div>
                            <span class="absolute bottom-3 left-3 text-sm font-semibold text-white opacity-0 transition group-hover:opacity-100">{{ $item->title }}</span>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ url('/kampus') }}" class="btn-navy">Tüm Galeriyi Gör @svg('heroicon-m-photo', 'h-5 w-5')</a>
                </div>
            </div>
        </section>
    @endif

    {{-- ============================ VELİ YORUMLARI ============================ --}}
    @if ($testimonials->isNotEmpty())
        <section class="py-20 sm:py-24">
            <div class="container-x">
                <x-section-heading
                    eyebrow="Veli Görüşleri"
                    title="Velilerimiz bizi anlatıyor"
                    subtitle="Güvenin ve memnuniyetin en güzel ifadesi, ailelerimizin sözleri." />

                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($testimonials->take(6) as $t)
                        <figure class="card flex flex-col p-7">
                            <div class="flex gap-0.5 text-accent-500">
                                @for ($i = 0; $i < 5; $i++)
                                    @svg('heroicon-s-star', 'h-5 w-5 '.($i < $t->rating ? 'text-accent-500' : 'text-navy-200'))
                                @endfor
                            </div>
                            <blockquote class="mt-4 flex-1 text-navy-700">“{{ $t->body }}”</blockquote>
                            <figcaption class="mt-6 flex items-center gap-3 border-t border-navy-100 pt-5">
                                <x-img :src="$t->image_url" :alt="$t->name" class="h-11 w-11 rounded-full" />
                                <div>
                                    <div class="font-bold text-navy-900">{{ $t->name }}</div>
                                    <div class="text-xs text-navy-400">{{ $t->role }}</div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============================ BAŞVURU CTA ============================ --}}
    <section class="container-x pb-24">
        <div class="relative overflow-hidden rounded-3xl bg-navy-800 px-8 py-14 text-center sm:px-16 sm:py-20">
            <div class="absolute -right-10 -top-10 h-60 w-60 rounded-full bg-accent-500/20 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-10 h-60 w-60 rounded-full bg-navy-500/30 blur-3xl"></div>
            <div class="relative">
                <h2 class="mx-auto max-w-2xl text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Çocuğunuz için doğru adımı bugün atın
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-navy-200">
                    Kayıt başvurunuzu birkaç dakikada tamamlayın; uzman ekibimiz en kısa sürede sizinle iletişime geçsin.
                </p>
                <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="{{ url('/kayit') }}" class="btn-primary text-base">Kayıt Başvurusu Yap</a>
                    <a href="{{ url('/iletisim') }}" class="btn-ghost text-base">Bize Ulaşın</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
