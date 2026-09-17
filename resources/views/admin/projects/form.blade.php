@php
    $editing = $project->exists;
    $stats = old('stats', $project->outcome_stats ?: [['value' => '', 'label' => '']]);
    $gallery = collect(old('gallery_keep', $project->gallery ?? []))->map(fn ($g) => is_array($g) ? $g : ['src' => $g, 'caption' => null])->values();
@endphp

<x-admin.layouts.app :title="$editing ? 'Edit Proyek: ' . Str::limit($project->name, 40) : 'Tambah Proyek'" :crumb="'Konten / Proyek / ' . ($editing ? 'Edit' : 'Baru')">
    <x-slot:actions>
        @if ($editing)<x-admin.button :href="route('portofolio.show', $project)" target="_blank" variant="secondary" icon="arrow-top-right-on-square">Pratinjau</x-admin.button>@endif
        <x-admin.button type="submit" form="project-form" icon="check">{{ $editing ? 'Simpan Perubahan' : 'Simpan Proyek' }}</x-admin.button>
    </x-slot:actions>

    <form novalidate id="project-form" method="POST" action="{{ $editing ? route('admin.projects.update', $project) : route('admin.projects.store') }}" enctype="multipart/form-data"
          x-data="{
              stats: @js(array_values($stats)),
              gallery: @js($gallery->all()),
              coverPreview: @js($project->cover_image ? asset($project->cover_image) : null),
              removeCover: false,
              newFiles: [],
              previewCover(e) { const f = e.target.files[0]; if (!f) return; this.removeCover = false; this.coverPreview = URL.createObjectURL(f); },
              pickGallery(e) { this.newFiles = [...e.target.files].map(f => ({ name: f.name, url: URL.createObjectURL(f) })); },
              slugify(v) { return v.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''); }
          }">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_380px]">
            {{-- Left --}}
            <div class="space-y-5">
                <x-admin.card title="Informasi Dasar">
                    <div class="grid gap-4 md:grid-cols-2">
                        <x-admin.field label="Nama Proyek" name="name" :value="$project->name" required placeholder="Nama proyek" x-on:input="$refs.slug.value ||= ''; if (!$refs.slug.dataset.touched) $refs.slug.value = slugify($event.target.value)" />
                        <x-admin.field label="Slug" name="slug" :value="$project->slug" prefix="/portofolio/" help="Otomatis dari nama, bisa diubah." x-ref="slug" x-on:input="$refs.slug.dataset.touched = 1" />
                    </div>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        <x-admin.field label="Kategori" name="category" type="select" required>
                            @foreach ($categories as $c)<option value="{{ $c }}" @selected(old('category', $project->category) === $c)>{{ $c }}</option>@endforeach
                        </x-admin.field>
                        <x-admin.field label="Layanan Terkait" name="service_id" type="select">
                            <option value="">— Tidak ada —</option>
                            @foreach ($services as $s)<option value="{{ $s->id }}" @selected((int) old('service_id', $project->service_id) === $s->id)>{{ $s->name }}</option>@endforeach
                        </x-admin.field>
                        <x-admin.field label="Tipe Klien" name="client_type" :value="$project->client_type" placeholder="Perbankan — Bank BPD Bali" />
                    </div>
                    <x-admin.field class="mt-4" label="Deskripsi Singkat" name="short_description" type="textarea" rows="2" :value="$project->short_description" required maxlength="255" help="Tampil pada kartu portofolio. Maks 255 karakter." />
                </x-admin.card>

                <x-admin.card title="Studi Kasus">
                    <div class="space-y-4">
                        <x-admin.field label="Deskripsi Lengkap / Hasil" name="description" type="textarea" rows="5" :value="$project->description" required help="Tampil pada panel Hasil & Outcome." />
                        <x-admin.field label="Tantangan" name="challenge" type="textarea" rows="3" :value="$project->challenge" />
                        <x-admin.field label="Solusi" name="solution" type="textarea" rows="3" :value="$project->solution" />
                        <x-admin.field label="Ringkasan Teknologi" name="tech_summary" type="textarea" rows="2" :value="$project->tech_summary" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Statistik Hasil">
                    <x-slot:action><x-admin.button variant="secondary" size="sm" icon="plus" @click="stats.push({ value: '', label: '' })">Tambah Baris</x-admin.button></x-slot:action>
                    <p class="-mt-2 mb-3 text-caption text-brand-muted">Tampil sebagai strip angka di halaman detail (mis. <em>8 — Kategori Produk</em>). Baris kosong diabaikan.</p>
                    <div class="space-y-2.5">
                        <template x-for="(s, i) in stats" :key="i">
                            <div class="flex items-center gap-2.5">
                                <x-heroicon-o-bars-3 class="h-4 w-4 shrink-0 text-brand-muted" />
                                <input type="text" :name="`stats[${i}][value]`" x-model="s.value" placeholder="Nilai (8, 100%, 1 jt)" maxlength="12" class="w-40 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <input type="text" :name="`stats[${i}][label]`" x-model="s.label" placeholder="Label" class="flex-1 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <button type="button" @click="stats.splice(i, 1)" class="flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg bg-brand-light hover:bg-error-bg hover:text-error" title="Hapus baris"><x-heroicon-o-trash class="h-4 w-4" /></button>
                            </div>
                        </template>
                    </div>
                </x-admin.card>
            </div>

            {{-- Right --}}
            <div class="space-y-5">
                <x-admin.card title="Publikasi">
                    <div class="flex items-center justify-between text-body-sm"><span class="text-brand-muted">Status</span><x-chip :variant="$project->external_url ? 'success' : 'light'">{{ $editing ? ($project->external_url ? 'Live' : 'Terpublikasi') : 'Draft baru' }}</x-chip></div>
                    <x-admin.field class="mt-4" label="URL Eksternal" name="external_url" type="url" :value="$project->external_url" placeholder="https://" help="Tombol “Kunjungi” mengarah ke sini; kosongkan bila tidak ada." />
                    <x-admin.field class="mt-4" label="Urutan Tampil" name="sort_order" type="number" min="0" :value="$project->sort_order" help="Angka kecil tampil lebih dulu." />
                </x-admin.card>

                <x-admin.card title="Gambar Sampul">
                    <input type="hidden" name="remove_cover" :value="removeCover ? 1 : 0">
                    <label class="relative block cursor-pointer overflow-hidden rounded-[10px] border border-dashed border-brand-border bg-brand-input">
                        <input type="file" name="cover" id="cover-input" accept="image/*" class="sr-only" @change="previewCover">
                        <template x-if="coverPreview && !removeCover"><img :src="coverPreview" alt="" class="aspect-[4/3] w-full object-cover object-top"></template>
                        <template x-if="!coverPreview || removeCover">
                            <span class="flex aspect-[4/3] flex-col items-center justify-center gap-1.5 text-center">
                                <x-heroicon-o-arrow-up-tray class="h-6 w-6 text-brand-normal" />
                                <span class="text-label font-medium">Klik untuk pilih gambar</span>
                                <span class="text-caption text-brand-muted">PNG/JPG · maks 2 MB · rasio 4:3</span>
                            </span>
                        </template>
                    </label>
                    @error('cover')<p class="mt-1.5 text-caption text-error">{{ $message }}</p>@enderror
                    <div class="mt-3 flex gap-2" x-show="coverPreview && !removeCover">
                        <label for="cover-input" class="flex-1"><span class="flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-brand-border bg-white px-3 py-2 text-label font-medium hover:bg-brand-light"><x-heroicon-o-arrow-up-tray class="h-4 w-4" />Ganti</span></label>
                        <x-admin.button variant="secondary" icon="trash" class="flex-1" @click="removeCover = true; coverPreview = null">Hapus</x-admin.button>
                    </div>
                    <p class="mt-3 text-caption text-brand-muted">Digunakan pada kartu & mock browser detail proyek.</p>
                </x-admin.card>

                <x-admin.card>
                    <div class="mb-3 flex items-center justify-between"><h2 class="text-h5 font-medium">Galeri <span class="text-brand-muted" x-text="`(${gallery.length + newFiles.length} gambar)`"></span></h2><span class="text-caption text-brand-muted">Caption tampil di bawah gambar</span></div>
                    <div class="space-y-2.5">
                        <template x-for="(g, i) in gallery" :key="g.src">
                            <div class="flex items-center gap-2.5 rounded-lg border border-brand-border p-2">
                                <img :src="'{{ asset('') }}' + g.src" alt="" class="h-12 w-[72px] shrink-0 rounded-md object-cover object-top">
                                <input type="hidden" :name="`gallery_keep[${i}][src]`" :value="g.src">
                                <input type="text" :name="`gallery_keep[${i}][caption]`" x-model="g.caption" placeholder="Caption (opsional)" class="min-w-0 flex-1 rounded-md border border-brand-border bg-brand-input px-2.5 py-1.5 text-label outline-none focus:border-brand-normal focus:bg-white">
                                <button type="button" @click="gallery.splice(i, 1)" class="flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg bg-brand-light hover:bg-error-bg hover:text-error" title="Hapus"><x-heroicon-o-trash class="h-4 w-4" /></button>
                            </div>
                        </template>
                        <template x-for="f in newFiles" :key="f.url">
                            <div class="flex items-center gap-2.5 rounded-lg border border-dashed border-brand-normal/50 bg-brand-light/50 p-2">
                                <img :src="f.url" alt="" class="h-12 w-[72px] shrink-0 rounded-md object-cover object-top">
                                <span class="min-w-0 flex-1 truncate text-label" x-text="f.name"></span>
                                <x-chip variant="accent">Baru</x-chip>
                            </div>
                        </template>
                    </div>
                    <label class="mt-3 flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-dashed border-brand-border bg-brand-input px-3 py-3 text-label font-medium text-brand-normal hover:bg-brand-light">
                        <input type="file" name="gallery_files[]" accept="image/*" multiple class="sr-only" @change="pickGallery"><x-heroicon-o-plus class="h-4 w-4" />Tambah gambar
                    </label>
                    @error('gallery_files.*')<p class="mt-1.5 text-caption text-error">{{ $message }}</p>@enderror
                </x-admin.card>

                @if ($editing)
                    <x-admin.card class="border-error/40">
                        <h2 class="text-h5 font-medium">Hapus Proyek</h2>
                        <p class="mt-1 text-caption text-brand-muted">Menghapus proyek bersifat permanen dan menghilangkannya dari portofolio publik.</p>
                        <div class="mt-3"><x-admin.confirm-delete :action="route('admin.projects.destroy', $project)" :title="'Hapus proyek “' . $project->name . '”?'" description="Sampul dan galeri ikut terhapus. Tindakan ini tidak bisa dibatalkan.">Hapus Proyek Ini</x-admin.confirm-delete></div>
                    </x-admin.card>
                @endif
            </div>
        </div>

        <div class="mt-5 flex items-center justify-between gap-3 rounded-xl border border-brand-border bg-white px-5 py-4">
            <span class="text-caption text-brand-muted">{{ $editing ? 'Terakhir disimpan: ' . $project->updated_at->translatedFormat('d M Y, H:i') : 'Belum disimpan' }}</span>
            <div class="flex gap-2">
                <x-admin.button :href="route('admin.projects.index')" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" icon="check">{{ $editing ? 'Simpan Perubahan' : 'Simpan Proyek' }}</x-admin.button>
            </div>
        </div>
    </form>
</x-admin.layouts.app>
