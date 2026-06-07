@props(['src' => null, 'alt' => ''])

@php
    $fallbackSvg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 600'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0' stop-color='#13315c'/><stop offset='1' stop-color='#1c4178'/></linearGradient></defs><rect width='800' height='600' fill='url(#g)'/><circle cx='400' cy='250' r='70' fill='#f5b301' opacity='0.85'/><text x='400' y='420' fill='#ffffff' opacity='0.55' font-size='46' font-family='sans-serif' text-anchor='middle'>Ufuk Koleji</text></svg>";
    $fallback = 'data:image/svg+xml;utf8,'.rawurlencode($fallbackSvg);
@endphp

<img
    src="{{ $src ?: $fallback }}"
    alt="{{ $alt }}"
    loading="lazy"
    onerror="this.onerror=null;this.src='{{ $fallback }}';"
    {{ $attributes->merge(['class' => 'object-cover']) }}
>
