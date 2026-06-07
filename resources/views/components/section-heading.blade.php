@props([
    'eyebrow' => null,
    'title' => '',
    'subtitle' => null,
    'align' => 'center',
    'light' => false,
])

<div @class([
    'max-w-3xl',
    'mx-auto text-center' => $align === 'center',
    'text-left' => $align === 'left',
])>
    @if ($eyebrow)
        <span class="eyebrow">{{ $eyebrow }}</span>
    @endif
    <h2 @class([
        'mt-4 text-3xl font-bold tracking-tight sm:text-4xl',
        'text-white' => $light,
        'text-navy-900' => ! $light,
    ])>
        {{ $title }}
    </h2>
    @if ($subtitle)
        <p @class([
            'mt-4 text-lg leading-relaxed',
            'text-navy-200' => $light,
            'text-navy-600' => ! $light,
        ])>
            {{ $subtitle }}
        </p>
    @endif
</div>
