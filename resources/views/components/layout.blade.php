<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MaiHarta — Ngga Ada Habisnya' }}</title>
    <meta name="theme-color" content="#2155cd">
    {{-- Penanda "bukan halaman pertama di sesi ini" — dipakai CSS agar elemen persisten tidak beranimasi ulang saat navigasi --}}
    <script>try{if(sessionStorage.getItem('wa-seen'))document.documentElement.classList.add('wa-seen');sessionStorage.setItem('wa-seen','1')}catch(e){}</script>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('images/icon-maiharta.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="description" content="{{ $description ?? site('umum.tagline.text') }}">

    <link rel="preload" as="image" href="{{ asset(site('umum.brand.logo')) }}" fetchpriority="high">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    {{ $head ?? '' }}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-brand-darker font-sans antialiased">

    <x-navbar />

    <main class="pb-24 lg:pb-0">
        {{ $slot }}
    </main>

    <x-footer />

    <x-bottom-nav />

    <x-whatsapp-fab />

</body>
</html>
