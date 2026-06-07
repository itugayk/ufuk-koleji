<x-layouts.app title="Başarılarımız" description="Ufuk Koleji öğrencilerinin akademik, sportif ve sosyal başarıları.">
    <x-page-hero
        eyebrow="Başarılarımız"
        title="Gururla anlattığımız başarı hikayeleri"
        subtitle="Sınav başarılarından olimpiyatlara, sporda şampiyonluklardan üniversite yerleşmelerine uzanan başarılarımız."
        :image="setting('hero_image')"
        :crumbs="['Başarılarımız' => null]" />

    {{-- Sayaçlar --}}
    <section class="py-16 sm:py-20">
        <div class="container-x grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="card p-7 text-center" x-data="counter({{ (int) $stat->value }})">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-navy-50 text-navy-800">
                        @svg($stat->icon ?: 'heroicon-o-trophy', 'h-7 w-7')
                    </div>
                    <div class="mt-4 text-4xl font-extrabold text-navy-900"><span x-text="formatted">0</span>{{ $stat->suffix }}</div>
                    <div class="mt-1 text-sm text-navy-500">{{ $stat->title }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Başarı hikayeleri --}}
    @if ($stories->isNotEmpty())
        <section class="bg-navy-50 py-20 sm:py-24">
            <div class="container-x">
                <x-section-heading eyebrow="Öne Çıkan Başarılar" title="Öğrencilerimizin parlayan başarıları" />
                <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
                    @foreach ($stories as $story)
                        <article class="card flex flex-col overflow-hidden sm:flex-row">
                            <div class="relative h-48 shrink-0 sm:h-auto sm:w-48">
                                <x-img :src="$story->image_url" :alt="$story->title" class="h-full w-full" />
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex items-center gap-2 text-xs font-bold">
                                    @if ($story->category)
                                        <span class="rounded-full bg-accent-100 px-3 py-1 text-accent-800">{{ $story->category }}</span>
                                    @endif
                                    @if ($story->year)
                                        <span class="text-navy-400">{{ $story->year }}</span>
                                    @endif
                                </div>
                                <h3 class="mt-3 text-xl font-bold text-navy-900">{{ $story->title }}</h3>
                                <p class="mt-2 flex-1 text-sm leading-relaxed text-navy-500">{{ $story->description }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="container-x py-20 text-center">
        <h2 class="mx-auto max-w-2xl text-3xl font-bold text-navy-900">Siz de bu başarı ailesinin parçası olun</h2>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ url('/kayit') }}" class="btn-primary">Kayıt Başvurusu</a>
            <a href="{{ url('/haberler') }}" class="btn-outline">Haberleri İncele</a>
        </div>
    </section>
</x-layouts.app>
