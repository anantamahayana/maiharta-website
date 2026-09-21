@php
    $editing = $article->exists;
    $label = $editing ? $article->statusLabel() : 'Draft';
@endphp

<x-admin.layouts.app :title="$editing ? 'Edit Artikel: ' . Str::limit($article->title, 40) : 'Tulis Artikel'" :crumb="'Konten / Blog / ' . ($editing ? 'Edit' : 'Baru')">
    <x-slot:actions>
        @if ($editing)<x-admin.button :href="route('blog.show', $article)" target="_blank" variant="secondary" icon="arrow-top-right-on-square">{{ $article->isLive() ? 'Lihat' : 'Pratinjau' }}</x-admin.button>@endif
        <x-admin.button type="submit" form="article-form" icon="check">{{ $editing ? 'Simpan Perubahan' : 'Simpan Artikel' }}</x-admin.button>
    </x-slot:actions>

    {{-- Editor teks kaya (Quill) — dimuat dari CDN, tanpa build tambahan --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.3/quill.snow.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.3/quill.min.js"></script>

    <form novalidate id="article-form" method="POST" action="{{ $editing ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data"
          x-data="articleForm({
              body: @js(old('body', $article->body ?? '')),
              uploadUrl: @js(route('admin.articles.upload')),
              csrf: @js(csrf_token()),
              cover: @js($article->cover ? asset($article->cover) : null),
          })">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_360px]">
            {{-- Left --}}
            <div class="space-y-5">
                <x-admin.card title="Artikel">
                    <x-admin.field label="Judul" name="title" :value="$article->title" required placeholder="Judul artikel yang jelas dan menarik" x-on:input="if (!$refs.slug.dataset.touched) $refs.slug.value = slugify($event.target.value)" />
                    <x-admin.field class="mt-4" label="Slug" name="slug" :value="$article->slug" prefix="/blog/" help="Otomatis dari judul, bisa diubah." x-ref="slug" x-on:input="$refs.slug.dataset.touched = 1" />
                    <div class="mt-4" x-data="{ n: {{ mb_strlen(old('excerpt', $article->excerpt ?? '')) }} }">
                        <x-admin.field label="Ringkasan" name="excerpt" type="textarea" rows="3" :value="$article->excerpt" required maxlength="300" placeholder="1–2 kalimat yang tampil di kartu dan hasil pencarian" x-on:input="n = $event.target.value.length" />
                        <p class="mt-1 text-right text-caption text-brand-muted"><span x-text="n"></span>/300</p>
                    </div>
                </x-admin.card>

                <x-admin.card title="Isi Artikel">
                    <p class="-mt-2 mb-3 text-caption text-brand-muted">Gunakan Heading 2 untuk sub-judul, sisipkan gambar lewat ikon gambar (maks 2 MB per gambar).</p>
                    <div class="overflow-hidden rounded-lg border {{ $errors->has('body') ? 'border-error' : 'border-brand-border' }} bg-white">
                        <div x-ref="editor" class="article-editor"></div>
                    </div>
                    <input type="hidden" name="body" x-ref="body" :value="body">
                    @error('body')<p class="mt-1.5 flex items-center gap-1 text-caption text-error"><x-heroicon-o-exclamation-circle class="h-3.5 w-3.5" />{{ $message }}</p>@enderror
                    <p class="mt-2 text-caption text-brand-muted" x-show="uploading" x-cloak>Mengunggah gambar…</p>
                </x-admin.card>

                @if ($editing)
                    <x-admin.card class="border-error/40">
                        <h2 class="text-h5 font-medium">Hapus Artikel</h2>
                        <p class="mt-1 text-caption text-brand-muted">Menghapus artikel bersifat permanen dan menghilangkannya dari halaman Blog.</p>
                        <div class="mt-3"><x-admin.confirm-delete :action="route('admin.articles.destroy', $article)" :title="'Hapus artikel “' . $article->title . '”?'" description="Sampul dan gambar di dalam artikel ikut terhapus. Tindakan ini tidak bisa dibatalkan." /></div>
                    </x-admin.card>
                @endif
            </div>

            {{-- Right --}}
            <div class="space-y-5">
                <x-admin.card title="Publikasi">
                    <div class="flex items-center justify-between text-body-sm"><span class="text-brand-muted">Status saat ini</span><x-chip :variant="$label === 'Tayang' ? 'success' : ($label === 'Terjadwal' ? 'accent' : 'light')">{{ $label }}</x-chip></div>
                    <x-admin.field class="mt-4" label="Status" name="status" type="select" required>
                        <option value="draft" @selected(old('status', $article->status) === 'draft')>Draft — tidak tampil di website</option>
                        <option value="published" @selected(old('status', $article->status) === 'published')>Tayang</option>
                    </x-admin.field>
                    <x-admin.field class="mt-4" label="Tanggal Tayang" name="published_at" type="datetime-local" :value="old('published_at', $article->published_at?->format('Y-m-d\TH:i'))" help="Kosongkan = tayang saat disimpan. Isi tanggal mendatang untuk menjadwalkan." />
                    <label class="mt-4 flex items-start gap-3 rounded-lg border border-brand-border bg-brand-input p-3">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $article->is_featured)) class="mt-0.5 h-[18px] w-[18px] rounded border-brand-border text-brand-normal focus:ring-brand-normal">
                        <span><span class="block text-label font-medium">Artikel unggulan</span><span class="block text-caption text-brand-muted">Tampil sebagai kartu besar di halaman Blog dan Beranda. Yang terbaru dipakai bila lebih dari satu.</span></span>
                    </label>
                </x-admin.card>

                <x-admin.card title="Kategori & Tag">
                    <x-admin.field label="Kategori" name="category" type="select" required>
                        @foreach ($categories as $key => $name)<option value="{{ $key }}" @selected(old('category', $article->category) === $key)>{{ $name }}</option>@endforeach
                    </x-admin.field>
                    <x-admin.field class="mt-4" label="Tag" name="tags" :value="old('tags', implode(', ', $article->tags ?? []))" placeholder="keamanan, laravel, ux" help="Pisahkan dengan koma." />
                </x-admin.card>

                <x-admin.card title="Gambar Sampul">
                    <input type="hidden" name="remove_cover" :value="removeCover ? 1 : 0">
                    <label class="relative block cursor-pointer overflow-hidden rounded-[10px] border border-dashed border-brand-border bg-brand-input">
                        <input type="file" name="cover" id="cover-input" accept="image/*" class="sr-only" @change="previewCover">
                        <template x-if="coverPreview && !removeCover"><img :src="coverPreview" alt="" class="aspect-video w-full object-cover"></template>
                        <template x-if="!coverPreview || removeCover">
                            <span class="flex aspect-video flex-col items-center justify-center gap-1.5 text-center">
                                <x-heroicon-o-arrow-up-tray class="h-6 w-6 text-brand-normal" />
                                <span class="text-label font-medium">Klik untuk pilih gambar</span>
                                <span class="text-caption text-brand-muted">JPG/PNG/WebP · maks 2 MB · rasio 16:9</span>
                            </span>
                        </template>
                    </label>
                    @error('cover')<p class="mt-1.5 text-caption text-error">{{ $message }}</p>@enderror
                    <div class="mt-3 flex gap-2" x-show="coverPreview && !removeCover">
                        <label for="cover-input" class="flex-1"><span class="flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-brand-border bg-white px-3 py-2 text-label font-medium hover:bg-brand-light"><x-heroicon-o-arrow-up-tray class="h-4 w-4" />Ganti</span></label>
                        <x-admin.button variant="secondary" icon="trash" class="flex-1" @click="removeCover = true; coverPreview = null">Hapus</x-admin.button>
                    </div>
                </x-admin.card>

                @if ($editing)
                    <x-admin.card title="Info">
                        <dl class="space-y-2 text-body-sm">
                            <div class="flex justify-between"><dt class="text-brand-muted">Penulis</dt><dd>{{ $article->author?->name ?? '—' }}</dd></div>
                            <div class="flex justify-between"><dt class="text-brand-muted">Dilihat</dt><dd>{{ number_format($article->views) }}×</dd></div>
                            <div class="flex justify-between"><dt class="text-brand-muted">Waktu baca</dt><dd>{{ $article->readingMinutes() }} menit</dd></div>
                            <div class="flex justify-between"><dt class="text-brand-muted">Dibuat</dt><dd>{{ $article->created_at->translatedFormat('d M Y, H:i') }}</dd></div>
                        </dl>
                    </x-admin.card>
                @endif
            </div>
        </div>

        <div class="mt-5 flex items-center justify-between gap-3 rounded-xl border border-brand-border bg-white px-5 py-4">
            <span class="text-caption text-brand-muted">{{ $editing ? 'Terakhir disimpan: ' . $article->updated_at->translatedFormat('d M Y, H:i') : 'Belum disimpan' }}</span>
            <div class="flex gap-2">
                <x-admin.button :href="route('admin.articles.index')" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" icon="check">{{ $editing ? 'Simpan Perubahan' : 'Simpan Artikel' }}</x-admin.button>
            </div>
        </div>
    </form>
</x-admin.layouts.app>
