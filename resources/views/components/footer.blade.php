<footer class="bg-brand-darker text-white">
    <div class="mx-auto max-w-[1440px] px-5 py-16 md:px-20">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-[280px_1fr_1fr]">
            <div>
                <img src="{{ asset('images/logo-maiharta-white.png') }}" alt="MaiHarta" class="h-9 w-auto">
                <p class="mt-3 text-sm text-white/60">
                    {{ site('umum.tagline.text') }}
                </p>
                @php
                    $wa = preg_replace('/\D+/', '', (string) site('umum.brand.whatsapp'));
                    $socials = array_filter([
                        ['Instagram', site('umum.brand.instagram'), 'social-instagram'],
                        ['Facebook', site('umum.brand.facebook'), 'social-facebook'],
                        ['LinkedIn', site('umum.brand.linkedin'), 'social-linkedin'],
                        ['WhatsApp', $wa ? 'https://wa.me/' . $wa : null, 'social-whatsapp'],
                    ], fn ($s) => filled($s[1]));
                @endphp
                @if ($socials)
                    <div class="mt-5 flex items-center gap-2.5">
                        @foreach ($socials as [$name, $url, $icon])
                            <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $name }}" title="{{ $name }}" class="grid size-10 place-items-center rounded-full bg-white/10 text-white/80 transition hover:-translate-y-0.5 hover:bg-brand-normal hover:text-white">
                                <x-dynamic-component :component="'icons.' . $icon" class="size-[18px]" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <p class="text-sm font-semibold text-white">Navigasi</p>
                <ul class="mt-4 space-y-3 text-sm text-white/60">
                    <li><a href="{{ route('layanan.index') }}" class="hover:text-white">Solusi Kita</a></li>
                    <li><a href="{{ route('portofolio.index') }}" class="hover:text-white">Portofolio</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-white">Tentang</a></li>
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-white">Kontak</p>
                <ul class="mt-4 space-y-3 text-sm text-white/60">
                    <li><a href="mailto:{{ site('umum.brand.email') }}" class="hover:text-white">{{ site('umum.brand.email') }}</a></li>
                    <li><a href="https://wa.me/{{ site('umum.brand.whatsapp') }}" class="hover:text-white">{{ site('umum.brand.phone') }}</a></li>
                    <li>@if (site('umum.brand.maps_link'))<a href="{{ site('umum.brand.maps_link') }}" target="_blank" rel="noopener" class="hover:text-white">{{ site('umum.brand.address') }}</a>@else{{ site('umum.brand.address') }}@endif</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-2 border-t border-white/10 pt-6 text-xs text-white/50 md:flex-row md:items-center md:justify-between">
            <span>&copy; {{ date('Y') }} Maiharta. Seluruh hak cipta dilindungi.</span>
            <span>Mitra pengembangan produk digital di Bali · Ilustrasi 3D <a href="https://www.magnific.com" target="_blank" rel="noopener" class="underline-offset-2 hover:text-white hover:underline">designed by Freepik - Magnific.com</a></span>
        </div>
    </div>
</footer>
