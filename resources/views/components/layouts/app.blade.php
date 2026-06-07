@props([
    'title' => null,
    'description' => null,
    'ogImage' => null,
])

@php
    $settings = $siteSettings ?? [];
    $siteName = $settings['site_name'] ?? 'Ufuk Koleji';
    $pageTitle = $title ? $title.' — '.$siteName : $siteName.' — '.($settings['site_slogan'] ?? 'Geleceğe Açılan Ufuk');
    $metaDesc = $description ?? ($settings['site_description'] ?? '');
    $share = $ogImage ?? ($settings['hero_image'] ?? null);
@endphp
<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    @if ($share)<meta property="og:image" content="{{ $share }}">@endif
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Kurum JSON-LD (EducationalOrganization / School) --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'School',
        'name' => $siteName,
        'slogan' => $settings['site_slogan'] ?? null,
        'description' => $settings['site_description'] ?? null,
        'url' => url('/'),
        'foundingDate' => $settings['founded_year'] ?? null,
        'telephone' => $settings['contact_phone'] ?? null,
        'email' => $settings['contact_email'] ?? null,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $settings['contact_address'] ?? null,
            'addressCountry' => 'TR',
        ],
        'sameAs' => array_values(array_filter([
            $settings['social_facebook'] ?? null,
            $settings['social_instagram'] ?? null,
            $settings['social_youtube'] ?? null,
            $settings['social_linkedin'] ?? null,
        ])),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    @stack('jsonld')
    @stack('head')
</head>
<body class="bg-white">
    @include('partials.navbar')

    <main>
        {{ $slot }}
    </main>

    @include('partials.footer')
    @include('partials.floating')

    @livewireScripts
    @stack('scripts')
</body>
</html>
