<footer class="bg-brand-darker text-white">
    <div class="mx-auto max-w-[1440px] px-5 py-16 md:px-20">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-[280px_1fr_1fr]">
            <div>
                <img src="{{ asset('images/logo-maiharta-white.png') }}" alt="MaiHarta" class="h-9 w-auto">
                <p class="mt-3 text-sm text-white/60">
                    Mitra pengembangan produk digital yang profesional, aman, dan terpercaya.
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold text-white">Navigasi</p>
                <ul class="mt-4 space-y-3 text-sm text-white/60">
                    <li><a href="{{ route('layanan.index') }}" class="hover:text-white">Solusi Kita</a></li>
                    <li><a href="{{ route('portofolio.index') }}" class="hover:text-white">Portofolio</a></li>
                    <li><a href="{{ route('sertifikasi') }}" class="hover:text-white">Sertifikasi</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-white">Tentang</a></li>
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-white">Kontak</p>
                <ul class="mt-4 space-y-3 text-sm text-white/60">
                    <li><a href="mailto:{{ site('umum.brand.email') }}" class="hover:text-white">{{ site('umum.brand.email') }}</a></li>
                    <li><a href="https://wa.me/{{ site('umum.brand.whatsapp') }}" class="hover:text-white">{{ site('umum.brand.phone') }}</a></li>
                    <li>{{ site('umum.brand.address') }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-2 border-t border-white/10 pt-6 text-xs text-white/50 md:flex-row md:items-center md:justify-between">
            <span>&copy; {{ date('Y') }} Maiharta. Seluruh hak cipta dilindungi.</span>
            <span>Dibuat dengan standar keamanan ISO/IEC 27001</span>
        </div>
    </div>
</footer>
