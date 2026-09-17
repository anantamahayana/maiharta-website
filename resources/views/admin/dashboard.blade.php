<x-admin.layouts.app title="Dashboard" :crumb="'Selamat datang kembali, ' . auth()->user()->name . ' 👋'">
    <x-slot:actions><x-admin.button :href="route('admin.projects.create')" icon="plus">Tambah Proyek</x-admin.button></x-slot:actions>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-5">
        @foreach ([
            ['Total Proyek', $projectCount, ($projectsThisMonth ? '+' . $projectsThisMonth . ' bulan ini' : 'Tidak ada tambahan bulan ini'), 'rectangle-stack', 'bg-brand-light text-brand-dark'],
            ['Layanan Aktif', $serviceCount, 'Semua terpublikasi', 'squares-2x2', 'bg-brand-light text-brand-dark'],
            ['Pesan Belum Dibaca', $unreadCount, 'dari ' . $messageCount . ' pesan', 'envelope', 'bg-brand-normal text-white'],
            ['Halaman Publik', 9, 'Beranda hingga kontak', 'globe-alt', 'bg-success-bg text-success-text'],
        ] as [$label, $value, $sub, $icon, $iconClass])
            <x-admin.card>
                <div class="flex items-center justify-between gap-2"><span class="text-label text-brand-muted">{{ $label }}</span><span class="flex h-9 w-9 items-center justify-center rounded-lg {{ $iconClass }}"><x-dynamic-component :component="'heroicon-o-' . $icon" class="h-[18px] w-[18px]" /></span></div>
                <p class="mt-3 font-heading text-h2 font-semibold">{{ $value }}</p>
                <p class="text-caption text-brand-muted">{{ $sub }}</p>
            </x-admin.card>
        @endforeach
    </div>

    <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[1fr_400px]">
        {{-- Recent messages --}}
        <x-admin.card padding="p-0">
            <div class="flex items-center justify-between border-b border-brand-border px-5 py-4">
                <h2 class="text-h5 font-medium">Pesan Kontak Terbaru</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-label font-medium text-brand-normal hover:text-brand-normal-hover">Lihat semua →</a>
            </div>
            @forelse ($recentMessages as $m)
                <a href="{{ route('admin.messages.show', $m) }}" class="flex items-start gap-3.5 border-b border-brand-light px-5 py-3.5 transition hover:bg-brand-input">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-label-sm font-medium {{ $m->is_read ? 'bg-brand-light text-brand-dark' : 'bg-brand-normal text-white' }}">{{ Str::of($m->name)->explode(' ')->map(fn ($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}</span>
                    <span class="min-w-0 flex-1">
                        <span class="flex items-center gap-2"><span class="truncate {{ $m->is_read ? 'text-body-sm' : 'text-body-sm font-semibold' }}">{{ $m->name }}</span>@if ($m->company)<span class="truncate text-caption text-brand-muted">· {{ $m->company }}</span>@endif</span>
                        <span class="block truncate text-caption text-brand-muted">{{ Str::limit($m->message, 90) }}</span>
                    </span>
                    <span class="flex shrink-0 flex-col items-end gap-1.5"><span class="text-caption text-brand-muted">{{ $m->created_at->diffForHumans(short: true) }}</span>@unless ($m->is_read)<x-chip variant="accent">Belum dibaca</x-chip>@endunless</span>
                </a>
            @empty
                <x-admin.empty icon="envelope" title="Belum ada pesan masuk" description="Pesan dari formulir kontak akan muncul di sini." />
            @endforelse
        </x-admin.card>

        <div class="space-y-5">
            <x-admin.card title="Aksi Cepat">
                <div class="space-y-2">
                    <x-admin.button :href="route('admin.projects.create')" icon="plus" class="w-full !justify-start">Tambah Proyek Baru</x-admin.button>
                    <x-admin.button :href="route('admin.services.create')" variant="secondary" icon="squares-2x2" class="w-full !justify-start">Tambah Layanan</x-admin.button>
                    <x-admin.button :href="route('admin.messages.index')" variant="secondary" icon="envelope" class="w-full !justify-start">Buka Kotak Masuk</x-admin.button>
                </div>
            </x-admin.card>

            <x-admin.card title="Proyek Terbaru Diubah">
                <x-slot:action><a href="{{ route('admin.projects.index') }}" class="text-label font-medium text-brand-normal">Kelola →</a></x-slot:action>
                <div class="space-y-3">
                    @foreach ($recentProjects as $p)
                        <a href="{{ route('admin.projects.edit', $p) }}" class="flex items-center gap-3">
                            <span class="h-9 w-12 shrink-0 overflow-hidden rounded-md bg-brand-light-hover">@if ($p->cover_image)<img src="{{ asset($p->cover_image) }}" alt="" class="h-full w-full object-cover">@endif</span>
                            <span class="min-w-0 flex-1"><span class="block truncate text-label font-medium">{{ $p->name }}</span><span class="block text-caption text-brand-muted">{{ $p->category }}</span></span>
                            <x-chip :variant="$p->external_url ? 'success' : 'light'">{{ $p->external_url ? 'Live' : 'Selesai' }}</x-chip>
                        </a>
                    @endforeach
                </div>
            </x-admin.card>

            <x-admin.card title="Status Sistem">
                <ul class="space-y-2.5 text-body-sm">
                    @foreach ([['Website publik', 'Online', 'bg-success'], ['Database', 'Terhubung', 'bg-success'], ['Versi Laravel', app()->version(), 'bg-brand-normal']] as [$k, $v, $dot])
                        <li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full {{ $dot }}"></span><span class="flex-1 text-brand-muted">{{ $k }}</span><span class="text-label font-medium">{{ $v }}</span></li>
                    @endforeach
                </ul>
            </x-admin.card>
        </div>
    </div>
</x-admin.layouts.app>
