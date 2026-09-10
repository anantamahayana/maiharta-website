<x-admin.layouts.app title="Layanan" crumb="Konten / Layanan">
    <x-slot:actions><x-admin.button :href="route('admin.services.create')" icon="plus">Tambah Layanan</x-admin.button></x-slot:actions>

    <p class="text-body-sm text-brand-muted">{{ $services->count() }} layanan · urutan tampil mengikuti angka <em>sort order</em> pada masing-masing layanan.</p>

    @if ($services->isEmpty())
        <x-admin.card class="mt-5"><x-admin.empty icon="squares-2x2" title="Belum ada layanan" description="Tambahkan layanan pertama agar tampil di halaman Layanan."><x-admin.button :href="route('admin.services.create')" icon="plus">Tambah Layanan</x-admin.button></x-admin.empty></x-admin.card>
    @else
        <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($services as $i => $s)
                <x-admin.card class="flex flex-col">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-light font-heading text-label font-semibold text-brand-normal">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="min-w-0 flex-1"><span class="block truncate text-h5 font-medium">{{ $s->name }}</span><span class="block truncate text-caption text-brand-muted">/layanan/{{ $s->slug }}</span></span>
                        <x-chip variant="success">Aktif</x-chip>
                    </div>
                    <p class="mt-3 flex-1 text-body-sm text-brand-muted">{{ $s->short_description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-caption text-brand-muted">{{ $s->projects_count }} proyek · {{ count($s->tech_tags ?? []) }} tag · {{ count($s->process_steps ?? []) }} tahap</span>
                        <div class="flex gap-1.5">
                            <a href="{{ route('admin.services.edit', $s) }}" title="Edit" class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-brand-light hover:bg-brand-light-hover"><x-heroicon-o-pencil-square class="h-4 w-4" /></a>
                            <a href="{{ route('layanan.show', $s) }}" target="_blank" title="Lihat di website" class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-brand-light hover:bg-brand-light-hover"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" /></a>
                            <x-admin.confirm-delete :action="route('admin.services.destroy', $s)" icon-only :title="'Hapus layanan “' . $s->name . '”?'" :description="$s->projects_count ? $s->projects_count . ' proyek terkait akan kehilangan relasinya (tidak ikut terhapus).' : 'Tindakan ini permanen.'" />
                        </div>
                    </div>
                </x-admin.card>
            @endforeach
        </div>
    @endif
</x-admin.layouts.app>
