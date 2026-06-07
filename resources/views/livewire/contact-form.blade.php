<div>
    @php
        $inputClass = 'w-full rounded-xl border border-navy-200 px-4 py-3 text-navy-900 placeholder-navy-300 transition focus:border-navy-500 focus:ring-2 focus:ring-navy-500/30 focus:outline-none';
        $labelClass = 'mb-1.5 block text-sm font-semibold text-navy-700';
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-900 text-white">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 to-navy-800"></div>
        <div class="absolute -left-10 bottom-0 h-60 w-60 rounded-full bg-accent-500/15 blur-3xl"></div>
        <div class="container-x relative py-14 sm:py-16">
            <nav class="flex items-center gap-2 text-sm text-navy-300">
                <a href="{{ url('/') }}" class="hover:text-accent-400">Ana Sayfa</a>
                @svg('heroicon-m-chevron-right', 'h-4 w-4 text-navy-500')
                <span class="text-white">İletişim</span>
            </nav>
            <span class="eyebrow mt-6">Bize Ulaşın</span>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">İletişim</h1>
            <p class="mt-3 max-w-2xl text-navy-200">Sorularınız, randevu ve bilgi talepleriniz için bize ulaşın. Size yardımcı olmaktan mutluluk duyarız.</p>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="container-x grid gap-10 lg:grid-cols-5">
            {{-- Bilgiler --}}
            <div class="space-y-4 lg:col-span-2">
                <div class="card flex items-start gap-4 p-5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-navy-50 text-navy-800">@svg('heroicon-o-map-pin', 'h-6 w-6')</span>
                    <div>
                        <h3 class="font-bold text-navy-900">Adres</h3>
                        <p class="mt-1 text-sm text-navy-500">{{ setting('contact_address', 'Atatürk Mah. Eğitim Cad. No: 42, İstanbul') }}</p>
                    </div>
                </div>
                <div class="card flex items-start gap-4 p-5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-navy-50 text-navy-800">@svg('heroicon-o-phone', 'h-6 w-6')</span>
                    <div>
                        <h3 class="font-bold text-navy-900">Telefon</h3>
                        <p class="mt-1 text-sm text-navy-500">
                            <a href="tel:{{ preg_replace('/\s+/', '', setting('contact_phone', '')) }}" class="hover:text-navy-800">{{ setting('contact_phone', '0212 555 00 00') }}</a><br>
                            <a href="tel:{{ preg_replace('/\s+/', '', setting('contact_phone_2', '')) }}" class="hover:text-navy-800">{{ setting('contact_phone_2', '0533 555 00 00') }}</a>
                        </p>
                    </div>
                </div>
                <div class="card flex items-start gap-4 p-5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-navy-50 text-navy-800">@svg('heroicon-o-envelope', 'h-6 w-6')</span>
                    <div>
                        <h3 class="font-bold text-navy-900">E-posta</h3>
                        <p class="mt-1 text-sm text-navy-500"><a href="mailto:{{ setting('contact_email', '') }}" class="hover:text-navy-800">{{ setting('contact_email', 'info@ufukkoleji.com') }}</a></p>
                    </div>
                </div>

                @if (setting('contact_map'))
                    <div class="card overflow-hidden">
                        <iframe src="{{ setting('contact_map') }}" class="h-56 w-full" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Harita"></iframe>
                    </div>
                @endif
            </div>

            {{-- Form --}}
            <div class="lg:col-span-3">
                <div class="card p-6 sm:p-8">
                    @if ($sent)
                        <div class="rounded-2xl bg-green-50 p-5 text-green-800" role="alert">
                            <div class="flex items-center gap-3">
                                @svg('heroicon-o-check-circle', 'h-7 w-7 text-green-600')
                                <div>
                                    <p class="font-bold">Mesajınız iletildi!</p>
                                    <p class="text-sm">En kısa sürede size geri dönüş yapacağız.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h2 class="text-xl font-bold text-navy-900">Bize yazın</h2>
                    <form wire:submit="submit" class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="{{ $labelClass }}">Adınız Soyadınız *</label>
                            <input type="text" wire:model="name" class="{{ $inputClass }}" placeholder="Adınız Soyadınız">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Telefon</label>
                            <input type="tel" wire:model="phone" class="{{ $inputClass }}" placeholder="05XX XXX XX XX">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">E-posta</label>
                            <input type="email" wire:model="email" class="{{ $inputClass }}" placeholder="ornek@eposta.com">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Konu</label>
                            <input type="text" wire:model="subject" class="{{ $inputClass }}" placeholder="Konu başlığı">
                            @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="{{ $labelClass }}">Mesajınız *</label>
                            <textarea wire:model="message" rows="5" class="{{ $inputClass }}" placeholder="Mesajınızı yazın..."></textarea>
                            @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" wire:loading.attr="disabled" class="btn-primary w-full sm:w-auto">
                                <span wire:loading.remove wire:target="submit">Mesajı Gönder</span>
                                <span wire:loading wire:target="submit">Gönderiliyor...</span>
                                @svg('heroicon-m-paper-airplane', 'h-4 w-4')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
