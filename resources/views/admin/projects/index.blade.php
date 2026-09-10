<x-admin.layouts.app title="Proyek" crumb="Konten / Proyek">
    <x-slot:actions><x-admin.button :href="route('admin.projects.create')" icon="plus">Tambah Proyek</x-admin.button></x-slot:actions>

    <form method="GET" class="flex flex-wrap items-center gap-3">
        <div class="flex min-w-[260px] items-center gap-2 rounded-lg border border-brand-border bg-white px-3.5 py-2">
            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-brand-muted" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama proyek atau klien…" class="w-full bg-transparent text-body-sm outline-none placeholder:text-brand-placeholder">
        </div>
        <div class="flex gap-1 rounded-lg border border-brand-border bg-white p-[3px]">
            @foreach ($counts as $cat => $n)
                <a href="{{ route('admin.projects.index', array_filter(['kategori' => $cat === 'Semua' ? null : $cat, 'q' => $search])) }}" class="flex items-center gap-1.5 rounded-md px-3 py-1.5 text-label font-medium {{ $category === $cat ? 'bg-brand-dark text-white' : 'text-brand-dark hover:bg-brand-light' }}">
                    {{ $cat }} <span class="rounded-full px-1.5 text-chip {{ $category === $cat ? 'bg-brand-surface-on-dark' : 'bg-brand-light text-brand-muted' }}">{{ $n }}</span>
                </a>
            @endforeach
        </div>
        @if ($search)<x-admin.button :href="route('admin.projects.index')" variant="ghost" size="sm" icon="x-mark">Reset</x-admin.button>@endif
    </form>

    <x-admin.card padding="p-0" class="mt-5 overflow-hidden">
        @if ($projects->isEmpty())
            <x-admin.empty icon="rectangle-stack" title="Tidak ada proyek" :description="$search ? 'Tidak ada hasil untuk “' . $search . '”.' : 'Mulai dengan menambahkan proyek pertama.'">
                <x-admin.button :href="route('admin.projects.create')" icon="plus">Tambah Proyek</x-admin.button>
            </x-admin.empty>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-body-sm">
                    <thead class="bg-brand-input text-label-sm uppercase tracking-wider text-brand-muted">
                        <tr><th class="px-5 py-3 font-medium">Proyek</th><th class="px-4 py-3 font-medium">Kategori</th><th class="px-4 py-3 font-medium">Layanan</th><th class="px-4 py-3 font-medium">Klien</th><th class="px-4 py-3 font-medium">Status</th><th class="px-4 py-3 font-medium">Urutan</th><th class="px-5 py-3 text-right font-medium">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-brand-light">
                        @foreach ($projects as $p)
                            <tr class="transition hover:bg-brand-input">
                                <td class="px-5 py-3">
                                    <a href="{{ route('admin.projects.edit', $p) }}" class="flex items-center gap-3">
                                        <span class="h-10 w-14 shrink-0 overflow-hidden rounded-md bg-brand-light-hover">@if ($p->cover_image)<img src="{{ asset($p->cover_image) }}" alt="" class="h-full w-full object-cover">@endif</span>
                                        <span class="min-w-0"><span class="block truncate text-label font-medium">{{ $p->name }}</span><span class="block text-caption text-brand-muted">/portofolio/{{ $p->slug }}</span></span>
                                    </a>
                                </td>
                                <td class="px-4 py-3"><x-chip>{{ $p->category }}</x-chip></td>
                                <td class="px-4 py-3">{{ $p->service?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-caption text-brand-muted">{{ $p->client_type ?? '—' }}</td>
                                <td class="px-4 py-3"><x-chip :variant="$p->external_url ? 'success' : 'light'">{{ $p->external_url ? 'Live' : 'Tanpa URL' }}</x-chip></td>
                                <td class="px-4 py-3">{{ $p->sort_order }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex justify-end gap-1.5">
                                        <a href="{{ route('admin.projects.edit', $p) }}" title="Edit" class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-brand-light hover:bg-brand-light-hover"><x-heroicon-o-pencil-square class="h-4 w-4" /></a>
                                        <a href="{{ route('portofolio.show', $p) }}" target="_blank" title="Lihat di website" class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-brand-light hover:bg-brand-light-hover"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" /></a>
                                        <x-admin.confirm-delete :action="route('admin.projects.destroy', $p)" icon-only :title="'Hapus proyek “' . $p->name . '”?'" description="Proyek beserta gambar sampul dan galerinya akan dihapus permanen dari portofolio publik." />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="border-t border-brand-border px-5 py-3 text-caption text-brand-muted">Menampilkan {{ $projects->count() }} proyek · angka urutan kecil tampil lebih dulu.</p>
        @endif
    </x-admin.card>
</x-admin.layouts.app>
