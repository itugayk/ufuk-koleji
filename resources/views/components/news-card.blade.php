@props(['news'])

<article class="group card flex flex-col overflow-hidden">
    <a href="{{ url('/haberler/'.$news->slug) }}" class="block overflow-hidden">
        <div class="relative aspect-[16/10] overflow-hidden">
            <x-img :src="$news->image_url" :alt="$news->title" class="h-full w-full transition duration-500 group-hover:scale-105" />
            <span class="absolute left-3 top-3 rounded-full px-3 py-1 text-xs font-bold text-navy-900"
                  style="background: {{ $news->type === 'duyuru' ? '#f5b301' : '#ffffff' }}">
                {{ $news->type_label }}
            </span>
        </div>
    </a>
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-3 text-xs font-medium text-navy-400">
            @if ($news->category)
                <span class="inline-flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full" style="background: {{ $news->category->color }}"></span>
                    {{ $news->category->name }}
                </span>
                <span class="opacity-40">•</span>
            @endif
            <time>{{ optional($news->published_at)->translatedFormat('d F Y') }}</time>
        </div>
        <h3 class="mt-3 text-lg font-bold leading-snug text-navy-900 transition group-hover:text-navy-700">
            <a href="{{ url('/haberler/'.$news->slug) }}">{{ $news->title }}</a>
        </h3>
        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-navy-500">{{ $news->excerpt }}</p>
        <a href="{{ url('/haberler/'.$news->slug) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-navy-700 transition group-hover:gap-2.5 group-hover:text-accent-600">
            Devamını oku
            @svg('heroicon-m-arrow-right', 'h-4 w-4')
        </a>
    </div>
</article>
