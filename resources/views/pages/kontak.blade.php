<x-layout title="Kontak — MaiHarta">
    <div class="mx-auto max-w-[1440px] px-5 py-16 md:px-20 md:py-24">
        <p class="text-sm font-medium text-brand-normal">KONTAK</p>
        <h1 class="mt-2 font-heading text-3xl font-bold text-brand-darker md:text-4xl">Hubungi Kami</h1>
        <p class="mt-3 max-w-xl text-brand-darker/70">
            Ceritakan kebutuhan bisnis Anda — tim kami akan merespons dalam 1x24 jam kerja.
        </p>

        @if (session('status'))
            <div class="mt-6 rounded-lg border border-brand-border bg-brand-light px-4 py-3 text-sm text-brand-dark">
                {{ session('status') }}
            </div>
        @endif

        <div class="mt-10 grid grid-cols-1 gap-12 md:grid-cols-[1fr_320px]">
            <form method="POST" action="{{ route('kontak.store') }}" class="space-y-5">
                @csrf

                {{-- honeypot: hidden from real users, bots tend to fill every field --}}
                <div class="hidden">
                    <label for="website">Website</label>
                    <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                </div>

                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-brand-darker">Nama</label>
                    <input
                        type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Masukkan nama"
                        class="w-full rounded-lg border border-brand-border px-4 py-3 text-sm outline-none focus:border-brand-normal"
                    >
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-brand-darker">Email</label>
                    <input
                        type="email" name="email" id="email" value="{{ old('email') }}" required
                        placeholder="Masukkan email"
                        class="w-full rounded-lg border border-brand-border px-4 py-3 text-sm outline-none focus:border-brand-normal"
                    >
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="company" class="mb-1.5 block text-sm font-medium text-brand-darker">Nama Perusahaan (Opsional)</label>
                    <input
                        type="text" name="company" id="company" value="{{ old('company') }}"
                        placeholder="Masukkan nama perusahaan (opsional)"
                        class="w-full rounded-lg border border-brand-border px-4 py-3 text-sm outline-none focus:border-brand-normal"
                    >
                </div>

                <div>
                    <label for="message" class="mb-1.5 block text-sm font-medium text-brand-darker">Kebutuhan / Pesan</label>
                    <textarea
                        name="message" id="message" rows="5" required
                        placeholder="Ceritakan kebutuhan proyek Anda..."
                        class="w-full rounded-lg border border-brand-border px-4 py-3 text-sm outline-none focus:border-brand-normal"
                    >{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <x-button type="submit" class="w-full">Kirim Pesan</x-button>
            </form>

            <div>
                <h2 class="font-heading text-lg font-bold text-brand-darker">Info Kontak Langsung</h2>
                <ul class="mt-4 space-y-3 text-sm text-brand-darker/80">
                    <li>info@maiharta.com</li>
                    <li>+62 812-3630-0562</li>
                    <li>Denpasar, Bali</li>
                    <li>Senin–Jumat, 09.00–17.00 WITA</li>
                </ul>
            </div>
        </div>
    </div>
</x-layout>
