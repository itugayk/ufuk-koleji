<x-layouts.app title="Kurumsal" description="Ufuk Koleji vizyonu, misyonu ve tarihçesi.">
    <x-page-hero
        eyebrow="Kurumsal"
        title="Köklü tecrübe, çağdaş eğitim anlayışı"
        subtitle="{{ setting('founded_year', '1998') }} yılından bu yana binlerce öğrenciyi geleceğe hazırlayan bir eğitim kurumu."
        :image="setting('hero_image')"
        :crumbs="['Kurumsal' => null]" />

    {{-- Vizyon & Misyon --}}
    <section class="py-20 sm:py-24">
        <div class="container-x grid gap-6 lg:grid-cols-2">
            @foreach (['vizyon', 'misyon'] as $key)
                @php $p = $pages[$key] ?? null; @endphp
                @if ($p)
                    <div class="card flex flex-col p-8 sm:p-10">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-navy-800 text-accent-400">
                            @svg($p->icon ?: 'heroicon-o-eye', 'h-7 w-7')
                        </div>
                        <h2 class="mt-6 text-2xl font-bold text-navy-900">{{ $p->title }}</h2>
                        @if ($p->subtitle)
                            <p class="mt-1 font-medium text-accent-700">{{ $p->subtitle }}</p>
                        @endif
                        <div class="prose-school mt-4">{!! nl2br(e($p->body)) !!}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- Tarihçe --}}
    @php $tarihce = $pages['tarihce'] ?? null; @endphp
    @if ($tarihce)
        <section class="bg-navy-50 py-20 sm:py-24">
            <div class="container-x grid items-center gap-12 lg:grid-cols-2">
                <div class="relative">
                    <x-img :src="setting('hero_image')" alt="Tarihçe" class="aspect-[4/3] w-full rounded-3xl shadow-xl" />
                    <div class="absolute -bottom-6 -right-4 rounded-2xl bg-accent-500 px-6 py-5 text-navy-900 shadow-lg sm:-right-6">
                        <div class="text-3xl font-extrabold">{{ (int) date('Y') - (int) setting('founded_year', 1998) }}+</div>
                        <div class="text-sm font-semibold">yıllık tecrübe</div>
                    </div>
                </div>
                <div>
                    <span class="eyebrow">{{ $tarihce->subtitle }}</span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-navy-900 sm:text-4xl">{{ $tarihce->title }}</h2>
                    <div class="prose-school mt-5 text-base">{!! nl2br(e($tarihce->body)) !!}</div>
                </div>
            </div>
        </section>
    @endif

    {{-- Rakamlar --}}
    <section class="py-20 sm:py-24">
        <div class="container-x">
            <x-section-heading eyebrow="Rakamlarla Ufuk Koleji" title="Başarımızı somut sonuçlarla anlatıyoruz" />
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
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
        </div>
    </section>

    {{-- Kademeler kısa --}}
    <section class="container-x pb-24">
        <div class="rounded-3xl bg-navy-800 p-8 text-center sm:p-12">
            <h2 class="text-2xl font-bold text-white sm:text-3xl">Eğitim kademelerimizi keşfedin</h2>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($levels as $level)
                    <a href="{{ url('/kademeler/'.$level->slug) }}" class="group rounded-2xl bg-white/5 p-5 text-left ring-1 ring-white/10 transition hover:bg-white/10">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl text-white" style="background: {{ $level->color }}">
                            @svg($level->icon ?: 'heroicon-o-academic-cap', 'h-6 w-6')
                        </div>
                        <div class="mt-4 font-bold text-white">{{ $level->name }}</div>
                        <div class="text-sm text-navy-300">{{ $level->age_range }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
