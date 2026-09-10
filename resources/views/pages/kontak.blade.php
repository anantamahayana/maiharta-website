@php
    $serviceOptions = ['Software Development', 'Graphics Design', 'Digital Marketing', 'UI/UX Design', 'Konsultasi', 'Lainnya'];
    $sent = session('status');
    $inputClass = 'w-full rounded-[10px] border bg-brand-input px-3.5 py-3 text-body-sm text-brand-dark placeholder:text-brand-placeholder outline-none transition focus:border-brand-normal focus:bg-white focus:ring-[3px] focus:ring-brand-normal/20';
@endphp

<x-layout title="Kontak — MaiHarta" description="Hubungi tim Maiharta — kami merespons dalam 1×24 jam kerja.">

    <x-page-hero eyebrow="Kontak" title="Hubungi Kami" description="Ceritakan kebutuhan bisnis Anda — tim kami akan merespons dalam 1×24 jam kerja.">
        <x-slot:aside>
            <span class="inline-flex items-center gap-2.5 rounded-full border border-brand-border bg-white px-4 py-3 text-label font-medium text-brand-dark">
                <span class="relative flex h-2.5 w-2.5"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-success opacity-60"></span><span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-success"></span></span>
                Tim kami online · Senin–Jumat 09.00–17.00 WITA
            </span>
        </x-slot:aside>
    </x-page-hero>

    <section class="container-site grid grid-cols-1 gap-8 pb-16 md:pb-20 lg:grid-cols-[1fr_420px]">

        {{-- Form / success --}}
        <div data-animate="scale" class="rounded-panel border border-brand-border bg-white p-6 shadow-elevated md:p-9">
            @if ($sent)
                <div class="flex flex-col items-center py-8 text-center" x-data x-init="$el.querySelector('[data-count]')">
                    <span class="flex h-20 w-20 items-center justify-center rounded-full bg-success-bg"><x-heroicon-o-check-circle class="h-10 w-10 text-success" /></span>
                    <h2 class="mt-6 font-heading text-h3 font-semibold text-brand-dark">Pesan Terkirim!</h2>
                    <p class="mt-2 max-w-[420px] text-body-sm text-brand-muted">{{ $sent }}</p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <x-button :href="route('home')" icon="arrow-right">Kembali ke Beranda</x-button>
                        <x-button :href="route('kontak')" variant="outline">Kirim Pesan Lain</x-button>
                    </div>
                </div>
            @else
                <h2 class="font-heading text-h3 font-semibold text-brand-dark">Kirim Pesan</h2>
                <p class="mt-1 text-body-sm text-brand-muted">Isi formulir di bawah, kami akan menghubungi Anda kembali.</p>

                @if ($errors->any())
                    <div class="mt-5 flex items-start gap-3 rounded-[10px] border border-error/30 bg-error-bg px-4 py-3 text-body-sm text-error">
                        <x-heroicon-o-exclamation-circle class="mt-0.5 h-4 w-4 shrink-0" />
                        <span>Beberapa isian belum benar. Periksa kembali kolom yang ditandai.</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('kontak.store') }}" x-data="{ service: @js(old('service', $serviceOptions[0])) }" class="mt-6 space-y-5">
                    @csrf
                    <div class="hidden" aria-hidden="true"><label for="website">Website</label><input type="text" name="website" id="website" tabindex="-1" autocomplete="off"></div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1.5 block text-label font-medium text-brand-dark">Nama <span class="text-error">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Masukkan nama" class="{{ $inputClass }} @error('name') !border-error @enderror">
                            @error('name')<p class="mt-1.5 flex items-center gap-1 text-caption text-error"><x-heroicon-o-exclamation-circle class="h-3.5 w-3.5" />{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-label font-medium text-brand-dark">Email <span class="text-error">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="nama@perusahaan.com" class="{{ $inputClass }} @error('email') !border-error @enderror">
                            @error('email')<p class="mt-1.5 flex items-center gap-1 text-caption text-error"><x-heroicon-o-exclamation-circle class="h-3.5 w-3.5" />{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="company" class="mb-1.5 block text-label font-medium text-brand-dark">Nama Perusahaan <span class="font-normal text-brand-muted">(Opsional)</span></label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" placeholder="Masukkan nama perusahaan" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <p class="mb-2 text-label font-medium text-brand-dark">Layanan yang Dibutuhkan</p>
                        <input type="hidden" name="service" :value="service">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($serviceOptions as $opt)
                                <button type="button" @click="service = @js($opt)" :class="service === @js($opt) ? 'border-brand-dark bg-brand-dark text-white' : 'border-brand-border bg-white text-brand-dark hover:bg-brand-light'" class="rounded-full border px-3.5 py-2 text-label font-medium transition-colors">{{ $opt }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="message" class="mb-1.5 block text-label font-medium text-brand-dark">Kebutuhan / Pesan <span class="text-error">*</span></label>
                        <textarea name="message" id="message" rows="5" required placeholder="Ceritakan kebutuhan proyek Anda..." class="{{ $inputClass }} @error('message') !border-error @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1.5 flex items-center gap-1 text-caption text-error"><x-heroicon-o-exclamation-circle class="h-3.5 w-3.5" />{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <x-button type="submit" icon="arrow-right">Kirim Pesan</x-button>
                        <p class="text-caption text-brand-muted">Dengan mengirim, Anda menyetujui kebijakan privasi kami.</p>
                    </div>
                </form>
            @endif
        </div>

        {{-- Sidebar --}}
        <div data-animate-group class="space-y-5">
            <div data-animate class="rounded-panel bg-brand-dark p-7 text-white">
                <p class="overline text-brand-accent-on-dark">Info Kontak Langsung</p>
                <ul class="mt-5 space-y-4">
                    @foreach ([['envelope', 'Email', 'info@maiharta.com', 'mailto:info@maiharta.com'], ['phone', 'Telepon / WhatsApp', '+62 812-3630-0562', 'tel:+6281236300562'], ['map-pin', 'Alamat Kantor', 'Jl. Tukad Ayung No.5, Denpasar Selatan, Kota Denpasar, Bali', 'https://maps.google.com/?q=Jl.+Tukad+Ayung+No.5,+Denpasar+Selatan,+Kota+Denpasar,+Bali'], ['clock', 'Jam Operasional', 'Senin–Jumat, 09.00–17.00 WITA', null]] as [$icon, $l, $v, $href])
                        <li class="flex items-center gap-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[10px] bg-brand-surface-on-dark"><x-dynamic-component :component="'heroicon-o-' . $icon" class="h-[18px] w-[18px]" /></span>
                            <span><span class="block text-caption text-brand-on-dark">{{ $l }}</span>@if ($href)<a href="{{ $href }}" class="block text-body-sm font-semibold hover:text-brand-accent-on-dark">{{ $v }}</a>@else<span class="block text-body-sm font-semibold">{{ $v }}</span>@endif</span>
                        </li>
                    @endforeach
                </ul>
                <a href="https://wa.me/6281236300562" target="_blank" rel="noopener" class="mt-6 flex items-center justify-center gap-2 rounded-lg bg-success px-5 py-3.5 text-body-sm font-medium text-white transition hover:-translate-y-0.5 hover:brightness-110">Chat via WhatsApp <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" /></a>
            </div>

            <div data-animate class="overflow-hidden rounded-panel border border-brand-border bg-white">
                <iframe title="Peta lokasi Maiharta" src="https://www.google.com/maps?q=Jl.+Tukad+Ayung+No.5,+Denpasar+Selatan,+Kota+Denpasar,+Bali&output=embed" class="h-[200px] w-full border-0 grayscale-[30%]" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="flex items-center justify-between gap-3 px-5 py-4">
                    <span><span class="block text-body-sm font-medium text-brand-dark">Kantor Maiharta</span><span class="block text-caption text-brand-muted">Jl. Tukad Ayung No.5, Denpasar Selatan, Kota Denpasar, Bali</span></span>
                    <a href="https://maps.google.com/?q=Jl.+Tukad+Ayung+No.5,+Denpasar+Selatan,+Kota+Denpasar,+Bali" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-label font-medium text-brand-normal">Buka di Maps <x-heroicon-o-arrow-top-right-on-square class="h-3.5 w-3.5" /></a>
                </div>
            </div>

            <div data-animate class="flex items-center gap-3 rounded-panel bg-brand-light px-5 py-4">
                <span class="flex-1 text-body-sm font-medium text-brand-dark">Media Sosial</span>
                @foreach ([['Instagram', '#'], ['Facebook', '#'], ['LinkedIn', '#'], ['WhatsApp', 'https://wa.me/6281236300562']] as [$name, $href])
                    <a href="{{ $href }}" aria-label="{{ $name }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-brand-border bg-white text-brand-dark transition hover:-translate-y-0.5 hover:border-brand-normal hover:text-brand-normal">
                        <span class="text-label font-semibold">{{ Str::substr($name, 0, 2) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
