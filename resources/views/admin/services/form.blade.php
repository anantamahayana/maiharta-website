@php
    $editing = $service->exists;
    $steps = collect(old('steps', $service->process_steps ?: [['title' => '', 'description' => '']]))->map(fn ($s) => $s + ['duration' => ''])->values()->all();
    $meta = old('meta', $service->meta ?: [['label' => 'Cocok untuk', 'value' => ''], ['label' => 'Deliverable', 'value' => ''], ['label' => 'Durasi tipikal', 'value' => ''], ['label' => 'Model kerja', 'value' => ''], ['label' => 'Standar', 'value' => 'ISO/IEC 27001']]);
    $caps = old('capabilities', $service->capabilities ?: [['title' => '', 'description' => '']]);
    $tags = collect(old('tech_tags') !== null ? explode(',', old('tech_tags')) : ($service->tech_tags ?? []))->map(fn ($t) => trim($t))->filter()->values();
@endphp

<x-admin.layouts.app :title="$editing ? 'Edit Layanan: ' . $service->name : 'Tambah Layanan'" :crumb="'Konten / Layanan / ' . ($editing ? 'Edit' : 'Baru')">
    <x-slot:actions>
        @if ($editing)<x-admin.button :href="route('layanan.show', $service)" target="_blank" variant="secondary" icon="arrow-top-right-on-square">Pratinjau</x-admin.button>@endif
        <x-admin.button type="submit" form="service-form" icon="check">{{ $editing ? 'Simpan Perubahan' : 'Simpan Layanan' }}</x-admin.button>
    </x-slot:actions>

    <form novalidate id="service-form" method="POST" action="{{ $editing ? route('admin.services.update', $service) : route('admin.services.store') }}"
          x-data="{
              steps: @js(array_values($steps)),
              meta: @js(array_values($meta)),
              caps: @js(array_values($caps)),
              tags: @js($tags->all()),
              draft: '',
              icon: @js(old('icon', $service->icon ?? 'code')),
              addTag() { const t = this.draft.trim().replace(/,$/, ''); if (t && !this.tags.includes(t)) this.tags.push(t); this.draft = ''; },
              slugify(v) { return v.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''); }
          }">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_380px]">
            <div class="space-y-5">
                <x-admin.card title="Informasi Dasar">
                    <div class="grid gap-4 md:grid-cols-2">
                        <x-admin.field label="Nama Layanan" name="name" :value="$service->name" required x-on:input="if (!$refs.slug.dataset.touched) $refs.slug.value = slugify($event.target.value)" />
                        <x-admin.field label="Slug" name="slug" :value="$service->slug" prefix="/layanan/" x-ref="slug" x-on:input="$refs.slug.dataset.touched = 1" />
                    </div>
                    <x-admin.field class="mt-4" label="Deskripsi Singkat" name="short_description" type="textarea" rows="2" :value="$service->short_description" required maxlength="255" help="Tampil pada kartu layanan. Maks 255 karakter." />
                    <x-admin.field class="mt-4" label="Deskripsi Lengkap" name="description" type="textarea" rows="5" :value="$service->description" required />
                </x-admin.card>

                <x-admin.card title="Kartu Meta (hero detail)">
                    <x-slot:action><x-admin.button variant="secondary" size="sm" icon="plus" @click="meta.push({ label: '', value: '' })">Tambah Baris</x-admin.button></x-slot:action>
                    <p class="-mt-2 mb-3 text-caption text-brand-muted">Pasangan label–nilai di kartu kanan hero (mis. <em>Cocok untuk — Instansi pemerintah</em>). Baris kosong diabaikan.</p>
                    <div class="space-y-2.5">
                        <template x-for="(m, i) in meta" :key="i">
                            <div class="flex items-center gap-2.5">
                                <input type="text" :name="`meta[${i}][label]`" x-model="m.label" placeholder="Label" class="w-44 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <input type="text" :name="`meta[${i}][value]`" x-model="m.value" placeholder="Nilai" class="flex-1 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <button type="button" @click="meta.splice(i, 1)" class="flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg bg-brand-light hover:bg-error-bg hover:text-error" title="Hapus"><x-heroicon-o-trash class="h-4 w-4" /></button>
                            </div>
                        </template>
                    </div>
                </x-admin.card>

                <x-admin.card title="Tentang Layanan & Kapabilitas">
                    <x-slot:action><x-admin.button variant="secondary" size="sm" icon="plus" @click="caps.push({ title: '', description: '' })">Tambah Kapabilitas</x-admin.button></x-slot:action>
                    <x-admin.field class="mb-4" label="Judul section “Tentang Layanan Ini”" name="about_title" :value="$service->about_title" placeholder="Sistem yang dibangun mengikuti proses bisnis Anda, bukan sebaliknya" help="Kosongkan untuk memakai judul default." />
                    <div class="space-y-2.5">
                        <template x-for="(c, i) in caps" :key="i">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-light text-label font-semibold text-brand-normal" x-text="String(i + 1).padStart(2, '0')"></span>
                                <input type="text" :name="`capabilities[${i}][title]`" x-model="c.title" placeholder="Judul kapabilitas" class="w-56 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <input type="text" :name="`capabilities[${i}][description]`" x-model="c.description" placeholder="Keterangan singkat" class="flex-1 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <button type="button" @click="caps.splice(i, 1)" class="flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg bg-brand-light hover:bg-error-bg hover:text-error" title="Hapus"><x-heroicon-o-trash class="h-4 w-4" /></button>
                            </div>
                        </template>
                    </div>
                </x-admin.card>

                <x-admin.card title="Teknologi & Skillset">
                    <input type="hidden" name="tech_tags" :value="tags.join(', ')">
                    <div class="flex flex-wrap items-center gap-2 rounded-lg border border-brand-border bg-brand-input px-3 py-2 focus-within:border-brand-normal focus-within:bg-white">
                        <template x-for="(t, i) in tags" :key="t">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-light-hover py-1 pl-2.5 pr-1.5 text-chip font-medium text-brand-dark"><span x-text="t"></span><button type="button" @click="tags.splice(i, 1)" class="text-brand-muted hover:text-error" aria-label="Hapus tag"><x-heroicon-o-x-mark class="h-3 w-3" /></button></span>
                        </template>
                        <input type="text" x-model="draft" @keydown.enter.prevent="addTag()" @keydown.,.prevent="addTag()" @blur="addTag()" placeholder="Ketik lalu Enter…" class="min-w-[160px] flex-1 bg-transparent py-1 text-body-sm outline-none placeholder:text-brand-placeholder">
                    </div>
                    <p class="mt-1.5 text-caption text-brand-muted">Dikelompokkan otomatis (Backend / Frontend / Lainnya) di halaman detail.</p>
                </x-admin.card>

                <x-admin.card title="Proses Kerja">
                    <x-slot:action><x-admin.button variant="secondary" size="sm" icon="plus" @click="steps.push({ title: '', description: '', duration: '' })">Tambah Tahap</x-admin.button></x-slot:action>
                    <div class="space-y-2.5">
                        <template x-for="(s, i) in steps" :key="i">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-light text-label font-semibold text-brand-normal" x-text="i + 1"></span>
                                <input type="text" :name="`steps[${i}][title]`" x-model="s.title" placeholder="Judul tahap" class="w-44 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <input type="text" :name="`steps[${i}][description]`" x-model="s.description" placeholder="Deskripsi singkat" class="flex-1 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <input type="text" :name="`steps[${i}][duration]`" x-model="s.duration" placeholder="Durasi (1–2 minggu)" class="w-36 rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm outline-none focus:border-brand-normal focus:bg-white">
                                <button type="button" @click="steps.splice(i, 1)" class="flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg bg-brand-light hover:bg-error-bg hover:text-error" title="Hapus"><x-heroicon-o-trash class="h-4 w-4" /></button>
                            </div>
                        </template>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-5">
                <x-admin.card title="Ikon & Tampilan">
                    <input type="hidden" name="icon" :value="icon">
                    <div class="flex items-center gap-3 rounded-lg bg-brand-light p-3">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white">@foreach ($icons as $key => $label)<span x-show="icon === @js($key)" x-cloak><x-service-icon :icon="$key" class="h-6 w-6" /></span>@endforeach</span>
                        <span><span class="block text-label font-medium" x-text="@js($icons)[icon]"></span><span class="block text-caption text-brand-muted">Ikon terpilih</span></span>
                    </div>
                    <div class="mt-3 grid grid-cols-4 gap-2">
                        @foreach ($icons as $key => $label)
                            <button type="button" @click="icon = @js($key)" :class="icon === @js($key) ? 'border-brand-normal bg-brand-normal/10 ring-2 ring-brand-normal/30' : 'border-brand-border bg-brand-input hover:bg-brand-light'" class="flex aspect-square flex-col items-center justify-center gap-1 rounded-lg border" title="{{ $label }}">
                                <x-service-icon :icon="$key" class="h-5 w-5" />
                            </button>
                        @endforeach
                    </div>
                    @error('icon')<p class="mt-1.5 text-caption text-error">{{ $message }}</p>@enderror
                </x-admin.card>

                <x-admin.card title="Publikasi">
                    <x-admin.field label="Urutan Tampil" name="sort_order" type="number" min="0" :value="$service->sort_order" help="Angka kecil tampil lebih dulu. Layanan urutan pertama jadi “Layanan Utama”." />
                    @if ($editing)
                        <p class="mt-5 text-label font-medium">Proyek Terkait ({{ $service->projects_count }})</p>
                        <ul class="mt-2 divide-y divide-brand-light">
                            @forelse ($service->projects as $p)
                                <li class="flex items-center justify-between gap-2 py-2 text-body-sm"><span class="truncate">{{ $p->name }}</span><a href="{{ route('admin.projects.edit', $p) }}" class="shrink-0 text-brand-normal"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" /></a></li>
                            @empty
                                <li class="py-2 text-caption text-brand-muted">Belum ada proyek yang terhubung.</li>
                            @endforelse
                        </ul>
                        <p class="mt-2 text-caption text-brand-muted">Relasi diatur dari halaman Proyek → Layanan Terkait.</p>
                    @endif
                </x-admin.card>

                @if ($editing)
                    <x-admin.card class="border-error/40">
                        <h2 class="text-h5 font-medium">Hapus Layanan</h2>
                        <p class="mt-1 text-caption text-brand-muted">Proyek terkait tidak ikut terhapus, hanya kehilangan relasi.</p>
                        <div class="mt-3"><x-admin.confirm-delete :action="route('admin.services.destroy', $service)" :title="'Hapus layanan “' . $service->name . '”?'">Hapus Layanan Ini</x-admin.confirm-delete></div>
                    </x-admin.card>
                @endif
            </div>
        </div>

        <div class="mt-5 flex items-center justify-between gap-3 rounded-xl border border-brand-border bg-white px-5 py-4">
            <span class="text-caption text-brand-muted">{{ $editing ? 'Terakhir disimpan: ' . $service->updated_at->translatedFormat('d M Y, H:i') : 'Belum disimpan' }}</span>
            <div class="flex gap-2">
                <x-admin.button :href="route('admin.services.index')" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" icon="check">{{ $editing ? 'Simpan Perubahan' : 'Simpan Layanan' }}</x-admin.button>
            </div>
        </div>
    </form>
</x-admin.layouts.app>
