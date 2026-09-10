@props(['title' => 'Dashboard', 'crumb' => null])

@php
    $unread = \App\Models\ContactSubmission::where('is_read', false)->count();
    $nav = [
        ['home', 'Dashboard', route('admin.dashboard'), request()->routeIs('admin.dashboard'), null],
        ['rectangle-stack', 'Proyek', route('admin.projects.index'), request()->routeIs('admin.projects.*'), null],
        ['squares-2x2', 'Layanan', route('admin.services.index'), request()->routeIs('admin.services.*'), null],
        ['envelope', 'Pesan Kontak', route('admin.messages.index'), request()->routeIs('admin.messages.*'), $unread ?: null],
        ['cog-6-tooth', 'Pengaturan', route('admin.settings'), request()->routeIs('admin.settings*'), null],
    ];
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $title }} — Panel Admin MaiHarta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-brand-light font-sans text-brand-dark antialiased" x-data="{ sidebar: false }">

    {{-- Sidebar --}}
    <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed left-0 top-0 z-40 flex h-dvh w-[248px] flex-col overflow-y-auto bg-brand-dark p-4 pb-16 text-white transition-transform duration-300">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-2 pb-5">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-normal font-heading text-body-sm font-semibold">M</span>
            <span><span class="block text-label font-semibold tracking-wider">MAIHARTA</span><span class="block text-caption text-brand-on-dark">Panel Admin</span></span>
        </a>
        <p class="overline mb-2 px-2 text-brand-accent-on-dark">Menu</p>
        <nav class="space-y-1.5">
            @foreach ($nav as [$icon, $label, $href, $active, $badge])
                <a href="{{ $href }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-label font-medium transition {{ $active ? 'border border-brand-border-on-dark bg-brand-surface-on-dark text-white' : 'text-brand-on-dark hover:bg-brand-surface-on-dark hover:text-white' }}">
                    <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-[18px] w-[18px]" />
                    <span class="flex-1">{{ $label }}</span>
                    @if ($badge)<span class="rounded-full bg-brand-normal px-1.5 py-px text-chip font-medium text-white">{{ $badge }}</span>@endif
                </a>
            @endforeach
        </nav>
        <div class="mt-auto space-y-3 pt-6">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-lg bg-brand-surface-on-dark px-3 py-2.5 text-label font-medium hover:bg-white/15">
                <x-heroicon-o-arrow-top-right-on-square class="h-[18px] w-[18px] text-brand-on-dark" /> Lihat Website
            </a>
            <div class="flex items-center gap-2.5 px-2 pt-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-normal text-label-sm font-medium">{{ Str::of(auth()->user()->name)->explode(' ')->map(fn ($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}</span>
                <span class="min-w-0 flex-1"><span class="block truncate text-label font-medium">{{ auth()->user()->name }}</span><span class="block truncate text-caption text-brand-on-dark">{{ auth()->user()->email }}</span></span>
                <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit" title="Keluar" class="text-brand-on-dark hover:text-white"><x-heroicon-o-power class="h-[18px] w-[18px]" /></button></form>
            </div>
        </div>
    </aside>
    <div x-show="sidebar" x-cloak @click="sidebar = false" class="fixed inset-0 z-30 bg-brand-darker/50 lg:hidden"></div>

    {{-- Main --}}
    <div class="flex min-h-full flex-col lg:pl-[248px]">
        <header class="sticky top-0 z-20 flex items-center gap-4 border-b border-brand-border bg-white px-5 py-3.5 lg:px-8">
            <button type="button" @click="sidebar = true" class="rounded-lg border border-brand-border p-2 lg:hidden" aria-label="Buka menu"><x-heroicon-o-bars-3 class="h-5 w-5" /></button>
            <div class="min-w-0 flex-1">
                @if ($crumb)<p class="truncate text-caption text-brand-muted">{{ $crumb }}</p>@endif
                <h1 class="truncate font-heading text-h4 font-medium">{{ $title }}</h1>
            </div>
            @if (isset($actions))<div class="flex items-center gap-2">{{ $actions }}</div>@endif
        </header>

        <main class="flex-1 p-5 lg:p-8">
            @if (session('status'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-5 flex items-center gap-3 rounded-[10px] border border-success/30 bg-success-bg px-4 py-3 text-body-sm text-success-text">
                    <x-heroicon-o-check-circle class="h-5 w-5 shrink-0" /><span class="flex-1">{{ session('status') }}</span>
                    <button type="button" @click="show = false" aria-label="Tutup"><x-heroicon-o-x-mark class="h-4 w-4" /></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-5 flex items-start gap-3 rounded-[10px] border border-error/30 bg-error-bg px-4 py-3 text-body-sm text-error">
                    <x-heroicon-o-exclamation-circle class="mt-0.5 h-5 w-5 shrink-0" /><span>Beberapa isian belum benar. Periksa kembali kolom yang ditandai.</span>
                </div>
            @endif
            {{ $slot }}
        </main>
    </div>
</body>
</html>
