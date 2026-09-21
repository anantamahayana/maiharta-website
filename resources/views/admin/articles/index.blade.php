<x-admin.layouts.app title="Blog" crumb="Konten / Blog">
    <x-slot:actions><x-admin.button :href="route('admin.articles.create')" icon="plus">Tulis Artikel</x-admin.button></x-slot:actions>

    <form method="GET" class="flex flex-wrap items-center gap-3">
        <div class="flex min-w-[260px] items-center gap-2 rounded-lg border border-brand-border bg-white px-3.5 py-2">
            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-brand-muted" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari judul artikel…" class="w-full bg-transparent text-body-sm outline-none placeholder:text-brand-placeholder">
        </div>
        <div class="flex gap-1 rounded-lg border border-brand-border bg-white p-[3px]">
            @foreach (['semua' => 'Semua', 'tayang' => 'Tayang', 'terjadwal' => 'Terjadwal', 'draft' => 'Draft'] as $key => $label)
                <a href="{{ route('admin.articles.index', array_filter(['status' => $key === 'semua' ? null : $key, 'kategori' => $category === 'semua' ? null : $category, 'q' => $search])) }}" class="flex items-center gap-1.5 rounded-md px-3 py-1.5 text-label font-medium {{ $status === $key ? 'bg-brand-dark text-white' : 'text-brand-dark hover:bg-brand-light' }}">
                    {{ $label }} <span class="rounded-full px-1.5 text-chip {{ $status === $key ? 'bg-brand-surface-on-dark' : 'bg-brand-light text-brand-muted' }}">{{ $counts[$key] }}</span>
                </a>
            @endforeach
        </div>
        <select name="kategori" onchange="this.form.submit()" class="rounded-lg border border-brand-border bg-white px-3 py-2 text-label font-medium outline-none">
            <option value="semua">Semua kategori</option>
            @foreach (\App\Models\Article::categories() as $key => $label)<option value="{{ $key }}" @selected($category === $key)>{{ $label }}</option>@endforeach
        </select>
        @if ($status !== 'semua')<input type="hidden" name="status" value="{{ $status }}">@endif
        @if ($search || $category !== 'semua' || $status !== 'semua')<x-admin.button :href="route('admin.articles.index')" variant="ghost" size="sm" icon="x-mark">Reset</x-admin.button>@endif
    </form>

    <x-admin.card padding="p-0" class="mt-5 overflow-hidden">
        @if ($articles->isEmpty())
            <x-admin.empty icon="newspaper" title="Belum ada artikel" :description="$search ? 'Tidak ada hasil untuk “' . $search . '”.' : 'Tulis artikel pertama untuk mengisi halaman Blog.'">
                <x-admin.button :href="route('admin.articles.create')" icon="plus">Tulis Artikel</x-admin.button>
            </x-admin.empty>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-body-sm">
                    <thead class="bg-brand-input text-label-sm uppercase tracking-wider text-brand-muted">
                        <tr><th class="px-5 py-3 font-medium">Artikel</th><th class="px-4 py-3 font-medium">Kategori</th><th class="px-4 py-3 font-medium">Status</th><th class="px-4 py-3 font-medium">Tanggal</th><th class="px-4 py-3 font-medium">Dilihat</th><th class="px-5 py-3 text-right font-medium">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-brand-light">
                        @foreach ($articles as $a)
                            @php $label = $a->statusLabel(); @endphp
                            <tr class="transition hover:bg-brand-input">
                                <td class="px-5 py-3">
                                    <a href="{{ route('admin.articles.edit', $a) }}" class="flex items-center gap-3">
                                        <span class="h-10 w-16 shrink-0 overflow-hidden rounded-md bg-brand-light-hover">@if ($a->cover)<img src="{{ asset($a->cover) }}" alt="" class="h-full w-full object-cover">@endif</span>
                                        <span class="min-w-0"><span class="flex items-center gap-1.5"><span class="truncate text-label font-medium">{{ $a->title }}</span>@if ($a->is_featured)<x-heroicon-s-star class="h-3.5 w-3.5 shrink-0 text-amber-400" title="Unggulan" />@endif</span><span class="block truncate text-caption text-brand-muted">/blog/{{ $a->slug }}</span></span>
                                    </a>
                                </td>
                                <td class="px-4 py-3"><x-chip>{{ \App\Models\Article::categories()[$a->category] ?? $a->category }}</x-chip></td>
                                <td class="px-4 py-3"><x-chip :variant="$label === 'Tayang' ? 'success' : ($label === 'Terjadwal' ? 'accent' : 'light')">{{ $label }}</x-chip></td>
                                <td class="px-4 py-3 text-caption text-brand-muted">{{ ($a->published_at ?? $a->created_at)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3 text-caption text-brand-muted">{{ number_format($a->views) }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex justify-end gap-1.5">
                                        <a href="{{ route('admin.articles.edit', $a) }}" title="Edit" class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-brand-light hover:bg-brand-light-hover"><x-heroicon-o-pencil-square class="h-4 w-4" /></a>
                                        <a href="{{ route('blog.show', $a) }}" target="_blank" title="Lihat di website" class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-brand-light hover:bg-brand-light-hover"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" /></a>
                                        <x-admin.confirm-delete :action="route('admin.articles.destroy', $a)" icon-only :title="'Hapus artikel “' . $a->title . '”?'" description="Artikel beserta sampul dan gambar di dalamnya akan dihapus permanen." />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-brand-border px-5 py-3 text-caption text-brand-muted">
                <span>Menampilkan {{ $articles->firstItem() }}–{{ $articles->lastItem() }} dari {{ $articles->total() }} artikel</span>
                {{ $articles->links() }}
            </div>
        @endif
    </x-admin.card>
</x-admin.layouts.app>
