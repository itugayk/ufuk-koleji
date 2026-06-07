<x-layouts.app title="Kampüs" description="Ufuk Koleji kampüsünden kareler.">
    <x-page-hero
        eyebrow="Kampüsümüz"
        title="İlham veren bir öğrenme ortamı"
        subtitle="Modern derslikler, donanımlı laboratuvarlar, sanat atölyeleri ve geniş spor alanları."
        :image="setting('hero_image')"
        :crumbs="['Kampüs' => null]" />

    <section class="py-20 sm:py-24" x-data="{ filter: 'all' }">
        <div class="container-x">
            {{-- Filtreler --}}
            <div class="flex flex-wrap items-center justify-center gap-2">
                <button @click="filter = 'all'"
                        :class="filter === 'all' ? 'bg-navy-800 text-white' : 'bg-navy-50 text-navy-600 hover:bg-navy-100'"
                        class="rounded-full px-5 py-2 text-sm font-semibold transition">Tümü</button>
                @foreach ($categories as $cat)
                    <button @click="filter = '{{ $cat }}'"
                            :class="filter === '{{ $cat }}' ? 'bg-navy-800 text-white' : 'bg-navy-50 text-navy-600 hover:bg-navy-100'"
                            class="rounded-full px-5 py-2 text-sm font-semibold transition">{{ $cat }}</button>
                @endforeach
            </div>

            {{-- Grid --}}
            <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($gallery as $item)
                    <figure
                        x-show="filter === 'all' || filter === '{{ $item->category }}'"
                        x-transition.opacity
                        class="group relative aspect-square overflow-hidden rounded-2xl">
                        <x-img :src="$item->image_url" :alt="$item->title" class="h-full w-full transition duration-500 group-hover:scale-110" />
                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-navy-900/80 via-transparent to-transparent p-4 opacity-0 transition group-hover:opacity-100">
                            <figcaption>
                                <span class="block text-sm font-bold text-white">{{ $item->title }}</span>
                                <span class="text-xs text-accent-300">{{ $item->category }}</span>
                            </figcaption>
                        </div>
                    </figure>
                @endforeach
            </div>

            @if ($gallery->isEmpty())
                <p class="mt-12 text-center text-navy-400">Henüz galeri görseli eklenmemiş.</p>
            @endif
        </div>
    </section>
</x-layouts.app>
