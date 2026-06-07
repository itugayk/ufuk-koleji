@php
    $s = $siteSettings ?? [];
    $socials = array_filter([
        'facebook' => $s['social_facebook'] ?? null,
        'instagram' => $s['social_instagram'] ?? null,
        'youtube' => $s['social_youtube'] ?? null,
        'linkedin' => $s['social_linkedin'] ?? null,
    ]);
@endphp

<footer class="relative mt-24 overflow-hidden bg-navy-900 text-navy-100">
    <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full bg-navy-700/40 blur-3xl"></div>
    <div class="absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-accent-500/10 blur-3xl"></div>

    <div class="container-x relative py-16">
        <div class="grid gap-10 lg:grid-cols-12">
            {{-- Brand --}}
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-500 text-navy-900">
                        @svg('heroicon-s-academic-cap', 'h-7 w-7')
                    </span>
                    <span class="font-display text-xl font-extrabold text-white">{{ $s['site_name'] ?? 'Ufuk Koleji' }}</span>
                </div>
                <p class="mt-5 max-w-sm text-sm leading-relaxed text-navy-300">
                    {{ $s['site_description'] ?? 'Anaokulundan liseye akademik başarı ve karakter eğitimini bir arada sunuyoruz.' }}
                </p>
                <div class="mt-6 flex gap-3">
                    @foreach ($socials as $net => $href)
                        <a href="{{ $href }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($net) }}"
                           class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-accent-500 hover:text-navy-900">
                            @svg('heroicon-o-globe-alt', 'h-5 w-5')
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Kurumsal --}}
            <div class="lg:col-span-2">
                <h4 class="text-sm font-bold uppercase tracking-wider text-white">Kurumsal</h4>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="{{ url('/kurumsal') }}" class="text-navy-300 transition hover:text-accent-400">Hakkımızda</a></li>
                    <li><a href="{{ url('/egitim-modeli') }}" class="text-navy-300 transition hover:text-accent-400">Eğitim Modeli</a></li>
                    <li><a href="{{ url('/basarilarimiz') }}" class="text-navy-300 transition hover:text-accent-400">Başarılarımız</a></li>
                    <li><a href="{{ url('/kampus') }}" class="text-navy-300 transition hover:text-accent-400">Kampüs</a></li>
                    <li><a href="{{ url('/haberler') }}" class="text-navy-300 transition hover:text-accent-400">Haberler</a></li>
                </ul>
            </div>

            {{-- Kademeler --}}
            <div class="lg:col-span-2">
                <h4 class="text-sm font-bold uppercase tracking-wider text-white">Kademeler</h4>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ($navLevels as $lvl)
                        <li><a href="{{ url('/kademeler/'.$lvl->slug) }}" class="text-navy-300 transition hover:text-accent-400">{{ $lvl->name }}</a></li>
                    @endforeach
                    <li><a href="{{ url('/kayit') }}" class="font-semibold text-accent-400 transition hover:text-accent-300">Kayıt Başvurusu →</a></li>
                </ul>
            </div>

            {{-- İletişim --}}
            <div class="lg:col-span-4">
                <h4 class="text-sm font-bold uppercase tracking-wider text-white">İletişim</h4>
                <ul class="mt-5 space-y-4 text-sm">
                    <li class="flex gap-3">
                        @svg('heroicon-o-map-pin', 'h-5 w-5 shrink-0 text-accent-400')
                        <span class="text-navy-300">{{ $s['contact_address'] ?? 'Atatürk Mah. Eğitim Cad. No: 42, İstanbul' }}</span>
                    </li>
                    <li class="flex gap-3">
                        @svg('heroicon-o-phone', 'h-5 w-5 shrink-0 text-accent-400')
                        <a href="tel:{{ preg_replace('/\s+/', '', $s['contact_phone'] ?? '') }}" class="text-navy-300 transition hover:text-white">{{ $s['contact_phone'] ?? '0212 555 00 00' }}</a>
                    </li>
                    <li class="flex gap-3">
                        @svg('heroicon-o-envelope', 'h-5 w-5 shrink-0 text-accent-400')
                        <a href="mailto:{{ $s['contact_email'] ?? '' }}" class="text-navy-300 transition hover:text-white">{{ $s['contact_email'] ?? 'info@ufukkoleji.com' }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-sm text-navy-400 sm:flex-row">
            <p>© {{ date('Y') }} {{ $s['site_name'] ?? 'Ufuk Koleji' }}. Tüm hakları saklıdır.</p>
            <p class="flex items-center gap-2">
                <a href="{{ url('/admin') }}" class="transition hover:text-accent-400">Yönetim Paneli</a>
                <span class="opacity-40">•</span>
                <span>Dijifa tarafından geliştirildi</span>
            </p>
        </div>
    </div>
</footer>
