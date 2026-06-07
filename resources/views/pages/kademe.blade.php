<x-layouts.app :title="$level->name" :description="$level->summary" :ogImage="$level->image_url">
    <x-page-hero
        :eyebrow="$level->age_range"
        :title="$level->name"
        :subtitle="$level->tagline"
        :image="$level->image_url"
        :crumbs="['Kademeler' => url('/kademeler'), $level->name => null]" />

    <section class="py-20 sm:py-24">
        <div class="container-x grid gap-12 lg:grid-cols-3">
            {{-- İçerik --}}
            <div class="lg:col-span-2">
                <span class="eyebrow">Kademe Hakkında</span>
                <h2 class="mt-4 text-3xl font-bold tracking-tight text-navy-900">{{ $level->summary }}</h2>
                <div class="prose-school mt-6 text-base">{!! nl2br(e($level->body)) !!}</div>

                <div class="mt-10 grid gap-5 sm:grid-cols-3">
                    @foreach ($features as $f)
                        <div class="rounded-2xl bg-navy-50 p-5">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl text-white" style="background: {{ $f->color }}">
                                @svg($f->icon ?: 'heroicon-o-sparkles', 'h-6 w-6')
                            </div>
                            <h3 class="mt-4 font-bold text-navy-900">{{ $f->title }}</h3>
                            <p class="mt-1 text-sm text-navy-500">{{ \Illuminate\Support\Str::limit($f->description, 80) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <div class="card overflow-hidden">
                    <div class="p-6" style="background: {{ $level->color }}">
                        <h3 class="text-lg font-bold text-white">Bu kademeye başvurun</h3>
                        <p class="mt-1 text-sm text-white/85">Hemen ön kayıt formunu doldurun.</p>
                    </div>
                    <div class="p-6">
                        <a href="{{ url('/kayit') }}?level_id={{ $level->id }}" class="btn-primary w-full">Kayıt Başvurusu</a>
                        <a href="{{ url('/iletisim') }}" class="btn-outline mt-3 w-full">Bilgi Al</a>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="font-bold text-navy-900">Diğer Kademeler</h3>
                    <div class="mt-4 space-y-2">
                        @foreach ($others as $o)
                            <a href="{{ url('/kademeler/'.$o->slug) }}" class="flex items-center gap-3 rounded-xl p-2.5 transition hover:bg-navy-50">
                                <span class="flex h-9 w-9 items-center justify-center rounded-lg text-white" style="background: {{ $o->color }}">
                                    @svg($o->icon ?: 'heroicon-o-academic-cap', 'h-5 w-5')
                                </span>
                                <span>
                                    <span class="block text-sm font-semibold text-navy-800">{{ $o->name }}</span>
                                    <span class="block text-xs text-navy-400">{{ $o->age_range }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
