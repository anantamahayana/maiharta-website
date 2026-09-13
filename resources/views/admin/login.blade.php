<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Masuk — Panel Admin MaiHarta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-hero-gradient flex min-h-full items-center justify-center p-5 font-sans text-brand-dark antialiased">
    <div data-animate="scale" class="w-full max-w-[440px] rounded-panel border border-brand-border bg-white p-8 shadow-elevated md:p-10">
        <div class="flex flex-col items-center text-center">
            <img src="{{ asset(site('umum.brand.logo')) }}" alt="MaiHarta" class="h-10 w-auto">
            <h1 class="mt-5 font-heading text-h3 font-semibold">Panel Admin</h1>
            <p class="mt-1 text-body-sm text-brand-muted">Masuk untuk mengelola konten website</p>
        </div>

        <form method="POST" action="{{ route('admin.login.store') }}" class="mt-7 space-y-4" x-data="{ show: false }">
            @csrf
            <x-admin.field label="Email" name="email" type="email" placeholder="admin@maiharta.com" required autofocus autocomplete="email" />
            <div>
                <label for="password" class="mb-1.5 block text-label font-medium">Kata Sandi</label>
                <div class="flex items-center overflow-hidden rounded-lg border bg-brand-input transition focus-within:border-brand-normal focus-within:bg-white focus-within:ring-[3px] focus-within:ring-brand-normal/20 {{ $errors->has('password') ? 'border-error' : 'border-brand-border' }}">
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required autocomplete="current-password" placeholder="••••••••••" class="w-full bg-transparent px-3.5 py-2.5 text-body-sm outline-none placeholder:text-brand-placeholder">
                    <button type="button" @click="show = !show" class="px-3 text-brand-muted hover:text-brand-dark" :aria-label="show ? 'Sembunyikan' : 'Tampilkan'">
                        <x-heroicon-o-eye x-show="!show" class="h-4 w-4" /><x-heroicon-o-eye-slash x-show="show" x-cloak class="h-4 w-4" />
                    </button>
                </div>
                @error('password')<p class="mt-1.5 text-caption text-error">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-body-sm"><input type="checkbox" name="remember" class="h-[18px] w-[18px] rounded border-brand-border text-brand-normal focus:ring-brand-normal">Ingat saya</label>
                <a href="mailto:info@maiharta.com?subject=Reset%20kata%20sandi%20admin" class="text-label font-medium text-brand-normal hover:text-brand-normal-hover">Lupa kata sandi?</a>
            </div>
            <x-admin.button type="submit" class="w-full py-3">Masuk</x-admin.button>
        </form>
        <p class="mt-6 text-center text-caption text-brand-muted">Akses terbatas untuk administrator. Aktivitas login tercatat.</p>
    </div>
</body>
</html>
