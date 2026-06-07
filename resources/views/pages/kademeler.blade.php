<x-layouts.app title="Kademeler" description="Anaokulu, ilkokul, ortaokul ve lise kademelerimiz.">
    <x-page-hero
        eyebrow="Kademelerimiz"
        title="Anaokulundan liseye bütüncül eğitim"
        subtitle="Her yaş grubunun gelişim ihtiyaçlarına göre tasarlanmış dört kademede kesintisiz eğitim."
        :image="setting('hero_image')"
        :crumbs="['Kademeler' => null]" />

    <section class="py-20 sm:py-24">
        <div class="container-x space-y-10">
            @foreach ($levels as $i => $level)
                <div class="card grid items-center gap-0 overflow-hidden lg:grid-cols-2 {{ $i % 2 ? 'lg:[&>div:first-child]:order-2' : '' }}">
                    <div class="relative h-64 lg:h-full lg:min-h-[22rem]">
                        <x-img :src="$level->image_url" :alt="$level->name" class="h-full w-full" />
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/40 to-transparent"></div>
                    </div>
                    <div class="p-8 sm:p-10">
                        <div class="flex items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl text-white" style="background: {{ $level->color }}">
                                @svg($level->icon ?: 'heroicon-o-academic-cap', 'h-6 w-6')
                            </span>
                            <span class="rounded-full bg-navy-50 px-3 py-1 text-xs font-bold text-navy-700">{{ $level->age_range }}</span>
                        </div>
                        <h2 class="mt-5 text-2xl font-bold text-navy-900">{{ $level->name }}</h2>
                        @if ($level->tagline)<p class="mt-1 font-medium text-accent-700">{{ $level->tagline }}</p>@endif
                        <p class="mt-3 leading-relaxed text-navy-600">{{ $level->summary }}</p>
                        <a href="{{ url('/kademeler/'.$level->slug) }}" class="btn-navy mt-6 py-2.5">
                            Detaylı İncele @svg('heroicon-m-arrow-right', 'h-4 w-4')
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
