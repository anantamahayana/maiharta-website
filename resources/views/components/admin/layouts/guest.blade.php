@props(['title', 'heading', 'subheading' => null])
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $title }} — Panel Admin MaiHarta</title>
    <meta name="theme-color" content="#2155cd">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('images/icon-maiharta.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-hero-gradient flex min-h-full items-center justify-center p-5 font-sans text-brand-dark antialiased">
    <div data-animate="scale" class="w-full max-w-[440px] rounded-panel border border-brand-border bg-white p-8 shadow-elevated md:p-10">
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('home') }}"><img src="{{ asset(site('umum.brand.logo')) }}" alt="MaiHarta" class="h-10 w-auto"></a>
            <h1 class="mt-5 font-heading text-h3 font-semibold">{{ $heading }}</h1>
            @if ($subheading)<p class="mt-1 text-body-sm text-brand-muted">{{ $subheading }}</p>@endif
        </div>

        @if (session('status'))
            <div class="mt-6 flex items-start gap-2 rounded-lg bg-success-bg px-3.5 py-3 text-body-sm text-success-text"><x-heroicon-o-check-circle class="mt-0.5 h-4 w-4 shrink-0" />{{ session('status') }}</div>
        @endif

        {{ $slot }}
    </div>
</body>
</html>
