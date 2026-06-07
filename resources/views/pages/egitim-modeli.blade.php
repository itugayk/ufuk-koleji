<x-layouts.app title="Eğitim Modeli" description="Ufuk Koleji'nin yenilikçi eğitim modeli ve farkı.">
    <x-page-hero
        eyebrow="Eğitim Modelimiz"
        title="Öğrenciyi merkeze alan yenilikçi eğitim"
        subtitle="Akademik başarıyı; yabancı dil, STEM, sanat-spor ve değerler eğitimiyle dengeleyen bütüncül bir model."
        :image="setting('hero_image')"
        :crumbs="['Eğitim Modeli' => null]" />

    @if ($page && $page->body)
        <section class="py-16">
            <div class="container-x max-w-3xl">
                <div class="prose-school text-lg">{!! nl2br(e($page->body)) !!}</div>
            </div>
        </section>
    @endif

    <section class="{{ $page && $page->body ? 'pb-20' : 'py-20' }} sm:pb-24">
        <div class="container-x">
            <x-section-heading eyebrow="Farkımız" title="Programımızı güçlendiren temel unsurlar" />
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

    {{-- Rakamlar bandı --}}
    <section class="bg-navy-800 py-16 text-white">
        <div class="container-x grid gap-8 text-center sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <div x-data="counter({{ (int) $stat->value }})">
                    <div class="text-4xl font-extrabold sm:text-5xl"><span x-text="formatted">0</span>{{ $stat->suffix }}</div>
                    <div class="mt-2 text-sm text-navy-200">{{ $stat->title }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container-x py-20 text-center">
        <h2 class="mx-auto max-w-2xl text-3xl font-bold text-navy-900">Eğitim modelimizi yakından görmek ister misiniz?</h2>
        <p class="mx-auto mt-3 max-w-xl text-navy-600">Kampüsümüzü ziyaret edin, öğretmenlerimizle tanışın.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ url('/kayit') }}" class="btn-primary">Kayıt Başvurusu</a>
            <a href="{{ url('/iletisim') }}" class="btn-outline">Randevu Al</a>
        </div>
    </section>
</x-layouts.app>
