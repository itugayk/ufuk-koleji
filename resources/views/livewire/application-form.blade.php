<div>
    @php
        $steps = [1 => 'Kademe', 2 => 'Öğrenci', 3 => 'Veli', 4 => 'Onay'];
        $inputClass = 'w-full rounded-xl border border-navy-200 px-4 py-3 text-navy-900 placeholder-navy-300 transition focus:border-navy-500 focus:ring-2 focus:ring-navy-500/30 focus:outline-none';
        $labelClass = 'mb-1.5 block text-sm font-semibold text-navy-700';
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-900 text-white">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 to-navy-800"></div>
        <div class="absolute -right-10 top-0 h-60 w-60 rounded-full bg-accent-500/15 blur-3xl"></div>
        <div class="container-x relative py-14 sm:py-16">
            <span class="eyebrow">Kayıt Başvurusu</span>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">Ön Kayıt Başvuru Formu</h1>
            <p class="mt-3 max-w-2xl text-navy-200">Birkaç adımda başvurunuzu tamamlayın; ekibimiz en kısa sürede size dönüş yapsın.</p>
        </div>
    </section>

    <section class="py-14 sm:py-20">
        <div class="container-x max-w-3xl">
            @if ($submitted)
                {{-- Başarı durumu --}}
                <div class="card p-10 text-center sm:p-14">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600">
                        @svg('heroicon-o-check-circle', 'h-12 w-12')
                    </div>
                    <h2 class="mt-6 text-2xl font-bold text-navy-900">Başvurunuz alındı!</h2>
                    <p class="mx-auto mt-3 max-w-md text-navy-600">
                        Teşekkür ederiz. Başvurunuz başarıyla iletildi. Kayıt ofisimiz en kısa sürede sizinle iletişime geçecektir.
                    </p>
                    <div class="mt-8 flex justify-center gap-3">
                        <a href="{{ url('/') }}" class="btn-navy">Ana Sayfaya Dön</a>
                        <a href="{{ url('/haberler') }}" class="btn-outline">Haberlerimiz</a>
                    </div>
                </div>
            @else
                {{-- Adım göstergesi --}}
                <ol class="mb-10 flex items-center justify-between">
                    @foreach ($steps as $num => $label)
                        <li class="flex flex-1 items-center {{ $num < count($steps) ? '' : 'flex-none' }}">
                            <div class="flex flex-col items-center">
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold transition',
                                    'bg-navy-800 text-white' => $step >= $num,
                                    'bg-navy-100 text-navy-400' => $step < $num,
                                ])>
                                    @if ($step > $num) @svg('heroicon-m-check', 'h-5 w-5') @else {{ $num }} @endif
                                </span>
                                <span class="mt-2 text-xs font-semibold {{ $step >= $num ? 'text-navy-800' : 'text-navy-400' }}">{{ $label }}</span>
                            </div>
                            @if ($num < count($steps))
                                <span class="mx-2 h-0.5 flex-1 rounded {{ $step > $num ? 'bg-navy-800' : 'bg-navy-100' }}"></span>
                            @endif
                        </li>
                    @endforeach
                </ol>

                <div class="card p-6 sm:p-8">
                    {{-- ADIM 1: Kademe --}}
                    @if ($step === 1)
                        <h2 class="text-xl font-bold text-navy-900">Hangi kademe için başvuruyorsunuz?</h2>
                        <p class="mt-1 text-sm text-navy-500">Çocuğunuzun başlayacağı eğitim kademesini seçin.</p>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach ($levels as $level)
                                <button type="button" wire:click="selectLevel({{ $level->id }})"
                                        @class([
                                            'flex items-center gap-4 rounded-2xl border-2 p-4 text-left transition',
                                            'border-navy-800 bg-navy-50' => $level_id === $level->id,
                                            'border-navy-100 hover:border-navy-300' => $level_id !== $level->id,
                                        ])>
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-white" style="background: {{ $level->color }}">
                                        @svg($level->icon ?: 'heroicon-o-academic-cap', 'h-6 w-6')
                                    </span>
                                    <span>
                                        <span class="block font-bold text-navy-900">{{ $level->name }}</span>
                                        <span class="block text-sm text-navy-400">{{ $level->age_range }}</span>
                                    </span>
                                </button>
                            @endforeach
                        </div>
                        @error('level_id') <p class="mt-3 text-sm text-red-600">{{ $message }}</p> @enderror
                    @endif

                    {{-- ADIM 2: Öğrenci --}}
                    @if ($step === 2)
                        <h2 class="text-xl font-bold text-navy-900">Öğrenci Bilgileri</h2>
                        <div class="mt-6 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="{{ $labelClass }}">Adı *</label>
                                <input type="text" wire:model="student_first_name" class="{{ $inputClass }}" placeholder="Öğrencinin adı">
                                @error('student_first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Soyadı *</label>
                                <input type="text" wire:model="student_last_name" class="{{ $inputClass }}" placeholder="Öğrencinin soyadı">
                                @error('student_last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Doğum Tarihi</label>
                                <input type="date" wire:model="student_birth_date" class="{{ $inputClass }}">
                                @error('student_birth_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Cinsiyet</label>
                                <select wire:model="student_gender" class="{{ $inputClass }}">
                                    <option value="">Seçiniz</option>
                                    <option value="kiz">Kız</option>
                                    <option value="erkek">Erkek</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="{{ $labelClass }}">Mevcut Okulu (varsa)</label>
                                <input type="text" wire:model="current_school" class="{{ $inputClass }}" placeholder="Halen devam ettiği okul">
                            </div>
                        </div>
                    @endif

                    {{-- ADIM 3: Veli --}}
                    @if ($step === 3)
                        <h2 class="text-xl font-bold text-navy-900">Veli Bilgileri</h2>
                        <div class="mt-6 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="{{ $labelClass }}">Veli Adı Soyadı *</label>
                                <input type="text" wire:model="parent_name" class="{{ $inputClass }}" placeholder="Adınız Soyadınız">
                                @error('parent_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Yakınlık</label>
                                <select wire:model="parent_relation" class="{{ $inputClass }}">
                                    <option value="">Seçiniz</option>
                                    <option value="anne">Anne</option>
                                    <option value="baba">Baba</option>
                                    <option value="vasi">Vasi</option>
                                </select>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Telefon *</label>
                                <input type="tel" wire:model="parent_phone" class="{{ $inputClass }}" placeholder="05XX XXX XX XX">
                                @error('parent_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">E-posta</label>
                                <input type="email" wire:model="parent_email" class="{{ $inputClass }}" placeholder="ornek@eposta.com">
                                @error('parent_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Şehir</label>
                                <input type="text" wire:model="city" class="{{ $inputClass }}" placeholder="İstanbul">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Adres</label>
                                <input type="text" wire:model="address" class="{{ $inputClass }}" placeholder="Mahalle / İlçe">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="{{ $labelClass }}">Mesajınız / Notunuz</label>
                                <textarea wire:model="message" rows="3" class="{{ $inputClass }}" placeholder="İletmek istedikleriniz..."></textarea>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="flex items-start gap-3">
                                    <input type="checkbox" wire:model="consent" class="mt-1 h-5 w-5 rounded border-navy-300 text-navy-800 focus:ring-navy-500">
                                    <span class="text-sm text-navy-600">Kişisel verilerimin başvuru değerlendirme süreci kapsamında işlenmesine yönelik <span class="font-semibold text-navy-800">aydınlatma metnini</span> okudum ve onaylıyorum.</span>
                                </label>
                                @error('consent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif

                    {{-- ADIM 4: Onay --}}
                    @if ($step === 4)
                        <h2 class="text-xl font-bold text-navy-900">Başvuru Özeti</h2>
                        <p class="mt-1 text-sm text-navy-500">Bilgilerinizi kontrol edin ve başvurunuzu gönderin.</p>
                        <dl class="mt-6 divide-y divide-navy-100 rounded-2xl bg-navy-50 px-5">
                            <div class="flex justify-between py-3.5"><dt class="text-navy-500">Kademe</dt><dd class="font-semibold text-navy-900">{{ $this->selectedLevel?->name }}</dd></div>
                            <div class="flex justify-between py-3.5"><dt class="text-navy-500">Öğrenci</dt><dd class="font-semibold text-navy-900">{{ $student_first_name }} {{ $student_last_name }}</dd></div>
                            <div class="flex justify-between py-3.5"><dt class="text-navy-500">Veli</dt><dd class="font-semibold text-navy-900">{{ $parent_name }}</dd></div>
                            <div class="flex justify-between py-3.5"><dt class="text-navy-500">Telefon</dt><dd class="font-semibold text-navy-900">{{ $parent_phone }}</dd></div>
                            @if ($parent_email)
                                <div class="flex justify-between py-3.5"><dt class="text-navy-500">E-posta</dt><dd class="font-semibold text-navy-900">{{ $parent_email }}</dd></div>
                            @endif
                        </dl>
                    @endif

                    {{-- Navigasyon --}}
                    <div class="mt-8 flex items-center justify-between gap-3">
                        @if ($step > 1)
                            <button type="button" wire:click="prevStep" class="btn-outline py-2.5">
                                @svg('heroicon-m-arrow-left', 'h-4 w-4') Geri
                            </button>
                        @else
                            <span></span>
                        @endif

                        @if ($step === 1)
                            <button type="button" wire:click="nextStep" class="btn-navy py-2.5">Devam Et @svg('heroicon-m-arrow-right', 'h-4 w-4')</button>
                        @elseif ($step < 4)
                            <button type="button" wire:click="nextStep" class="btn-navy py-2.5">Devam Et @svg('heroicon-m-arrow-right', 'h-4 w-4')</button>
                        @else
                            <button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn-primary py-2.5">
                                <span wire:loading.remove wire:target="submit">Başvuruyu Gönder</span>
                                <span wire:loading wire:target="submit">Gönderiliyor...</span>
                                @svg('heroicon-m-paper-airplane', 'h-4 w-4')
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
