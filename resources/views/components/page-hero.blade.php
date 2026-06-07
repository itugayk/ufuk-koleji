@props([
    'title' => '',
    'subtitle' => null,
    'eyebrow' => null,
    'image' => null,
    'crumbs' => [],
])

<section class="relative overflow-hidden bg-navy-900">
    @if ($image)
        <x-img :src="$image" alt="{{ $title }}" class="absolute inset-0 h-full w-full opacity-25" />
    @endif
    <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-900/95 to-navy-800/80"></div>
    <div class="absolute -right-16 top-10 h-64 w-64 rounded-full bg-accent-500/10 blur-3xl"></div>

    <div class="container-x relative py-16 sm:py-20">
        <nav class="flex items-center gap-2 text-sm text-navy-300">
            <a href="{{ url('/') }}" class="transition hover:text-accent-400">Ana Sayfa</a>
            @foreach ($crumbs as $label => $href)
                @svg('heroicon-m-chevron-right', 'h-4 w-4 text-navy-500')
                @if ($href)
                    <a href="{{ $href }}" class="transition hover:text-accent-400">{{ $label }}</a>
                @else
                    <span class="text-white">{{ $label }}</span>
                @endif
            @endforeach
        </nav>

        @if ($eyebrow)
            <span class="eyebrow mt-6">{{ $eyebrow }}</span>
        @endif
        <h1 class="mt-4 max-w-3xl text-4xl font-extrabold tracking-tight text-white sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-4 max-w-2xl text-lg leading-relaxed text-navy-200">{{ $subtitle }}</p>
        @endif
    </div>
</section>
