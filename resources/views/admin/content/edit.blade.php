@php
    $fieldInput = 'w-full rounded-lg border border-brand-border bg-brand-input px-3.5 py-2.5 text-body-sm text-brand-dark outline-none transition placeholder:text-brand-placeholder focus:border-brand-normal focus:bg-white focus:ring-[3px] focus:ring-brand-normal/20';
    $smallInput = 'min-w-0 flex-1 rounded-md border border-brand-border bg-brand-input px-2.5 py-1.5 text-label outline-none focus:border-brand-normal focus:bg-white';
@endphp

<x-admin.layouts.app :title="'Konten: ' . $def['label']" crumb="Konten Website">
    <x-slot:actions>
        <x-admin.button :href="$page === 'umum' ? route('home') : route(['beranda' => 'home', 'layanan' => 'layanan.index', 'portofolio' => 'portofolio.index', 'sertifikasi' => 'sertifikasi', 'tentang' => 'tentang', 'kontak' => 'kontak'][$page] ?? 'home')" target="_blank" variant="secondary" icon="arrow-top-right-on-square">Lihat Halaman</x-admin.button>
        <x-admin.button type="submit" form="content-form" icon="check">Simpan</x-admin.button>
    </x-slot:actions>

    {{-- Tabs --}}
    <div class="flex gap-1 overflow-x-auto rounded-lg border border-brand-border bg-white p-[3px]">
        @foreach ($pages as $key => $p)
            <a href="{{ route('admin.content.edit', $key) }}" class="flex shrink-0 items-center gap-2 rounded-md px-3.5 py-2 text-label font-medium {{ $key === $page ? 'bg-brand-dark text-white' : 'text-brand-dark hover:bg-brand-light' }}">
                <x-dynamic-component :component="'heroicon-o-' . $p['icon']" class="h-4 w-4" />{{ $p['label'] }}
            </a>
        @endforeach
    </div>

    <form novalidate id="content-form" method="POST" action="{{ route('admin.content.update', $page) }}" enctype="multipart/form-data" class="mt-5 space-y-5">
        @csrf @method('PUT')

        @foreach ($def['groups'] as $group => $g)
            <x-admin.card :title="$g['label']">
                @if (!empty($g['help']))<p class="-mt-2 mb-4 text-caption text-brand-muted">{{ $g['help'] }}</p>@endif
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($g['fields'] as $f)
                        @php $name = "{$group}[{$f['key']}]"; $aux = fn ($suffix) => "{$group}[{$f['key']}_{$suffix}]"; $val = $values[$group][$f['key']] ?? ''; $wide = in_array($f['type'], ['textarea', 'repeater', 'images']); @endphp

                        @if ($f['type'] === 'text')
                            <div>
                                <label for="{{ $group }}-{{ $f['key'] }}" class="mb-1.5 block text-label font-medium">{{ $f['label'] }}</label>
                                <input type="text" id="{{ $group }}-{{ $f['key'] }}" name="{{ $name }}" value="{{ old($group . '.' . $f['key'], $val) }}" class="{{ $fieldInput }}">
                            </div>

                        @elseif ($f['type'] === 'textarea')
                            <div class="md:col-span-2">
                                <label for="{{ $group }}-{{ $f['key'] }}" class="mb-1.5 block text-label font-medium">{{ $f['label'] }}</label>
                                <textarea id="{{ $group }}-{{ $f['key'] }}" name="{{ $name }}" rows="3" class="{{ $fieldInput }}">{{ old($group . '.' . $f['key'], $val) }}</textarea>
                            </div>

                        @elseif ($f['type'] === 'repeater')
                            <div class="md:col-span-2" x-data="{ rows: @js(array_values(old($group . '.' . $f['key'], $val ?: []))), max: {{ $f['max'] ?? 50 }}, blank: @js(collect($f['fields'])->mapWithKeys(fn ($x) => [$x['key'] => ''])->all()) }">
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-label font-medium">{{ $f['label'] }} <span class="text-brand-muted" x-text="`(${rows.length}/${max})`"></span></span>
                                    <x-admin.button variant="secondary" size="sm" icon="plus" x-show="rows.length < max" @click="rows.push({ ...blank })">Tambah</x-admin.button>
                                </div>
                                <div class="space-y-2">
                                    <template x-for="(row, i) in rows" :key="i">
                                        <div class="flex items-start gap-2 rounded-lg border border-brand-border bg-white p-2.5">
                                            <span class="mt-1.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-brand-light text-chip font-semibold text-brand-normal" x-text="i + 1"></span>
                                            <div class="grid min-w-0 flex-1 gap-2 {{ count($f['fields']) > 1 ? 'md:grid-cols-[200px_1fr]' : '' }}">
                                                @foreach ($f['fields'] as $sub)
                                                    @if ($sub['type'] === 'textarea')
                                                        <textarea :name="`{{ $name }}[${i}][{{ $sub['key'] }}]`" x-model="row.{{ $sub['key'] }}" rows="2" placeholder="{{ $sub['label'] }}" class="{{ $smallInput }} {{ count($f['fields']) > 2 ? 'md:col-span-2' : '' }}"></textarea>
                                                    @else
                                                        <input type="text" :name="`{{ $name }}[${i}][{{ $sub['key'] }}]`" x-model="row.{{ $sub['key'] }}" placeholder="{{ $sub['label'] }}" class="{{ $smallInput }}">
                                                    @endif
                                                @endforeach
                                            </div>
                                            <button type="button" @click="rows.splice(i, 1)" class="mt-0.5 flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg bg-brand-light hover:bg-error-bg hover:text-error" title="Hapus"><x-heroicon-o-trash class="h-4 w-4" /></button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        @elseif ($f['type'] === 'image')
                            <div x-data="{ src: @js($val ? asset($val) : null), remove: false, pick(e) { const f = e.target.files[0]; if (!f) return; this.remove = false; this.src = URL.createObjectURL(f); } }">
                                <span class="mb-1.5 block text-label font-medium">{{ $f['label'] }}</span>
                                <input type="hidden" name="{{ $aux('remove') }}" :value="remove ? 1 : 0">
                                <div class="flex items-center gap-4 rounded-lg border border-brand-border bg-brand-input p-3">
                                    <span class="flex h-16 w-40 shrink-0 items-center justify-center rounded-md bg-white p-2 {{ str_contains($f['key'], 'white') ? '!bg-brand-dark' : '' }}"><img x-show="src && !remove" :src="src" alt="" class="max-h-full max-w-full object-contain"><span x-show="!src || remove" class="text-caption text-brand-muted">Belum ada</span></span>
                                    <div class="flex flex-wrap gap-2">
                                        <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-brand-border bg-white px-3 py-2 text-label font-medium hover:bg-brand-light"><input type="file" name="{{ $name }}" accept="image/png,image/svg+xml,image/webp,image/jpeg" class="sr-only" @change="pick"><x-heroicon-o-arrow-up-tray class="h-4 w-4" />Ganti</label>
                                        <x-admin.button variant="secondary" size="sm" icon="arrow-uturn-left" x-show="src && !remove" @click="remove = true">Kembali ke default</x-admin.button>
                                    </div>
                                </div>
                                <p class="mt-1.5 text-caption text-brand-muted">PNG/SVG transparan, tinggi ±40 px · maks 2 MB.</p>
                            </div>

                        @elseif ($f['type'] === 'images')
                            <div class="md:col-span-2" x-data="{ items: @js(array_values($val ?: [])), files: [], pick(e) { this.files = [...e.target.files].map(f => ({ name: f.name, url: URL.createObjectURL(f) })); } }">
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-label font-medium">{{ $f['label'] }} <span class="text-brand-muted" x-text="`(${items.length + files.length})`"></span></span>
                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-brand-border bg-white px-3 py-2 text-label font-medium hover:bg-brand-light"><input type="file" name="{{ $aux('files') }}[]" accept="image/*" multiple class="sr-only" @change="pick"><x-heroicon-o-arrow-up-tray class="h-4 w-4" />Unggah logo</label>
                                </div>
                                <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
                                    <template x-for="(it, i) in items" :key="it.src">
                                        <div class="rounded-lg border border-brand-border bg-white p-2">
                                            <div class="flex h-16 items-center justify-center rounded-md bg-brand-light p-2"><img :src="'{{ asset('') }}' + it.src" alt="" class="max-h-full max-w-full object-contain"></div>
                                            <input type="hidden" :name="`{{ $aux('keep') }}[${i}][src]`" :value="it.src">
                                            <div class="mt-2 flex items-center gap-1.5">
                                                <input type="text" :name="`{{ $aux('keep') }}[${i}][caption]`" x-model="it.caption" placeholder="Nama" class="{{ $smallInput }}">
                                                <button type="button" @click="items.splice(i, 1)" class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-brand-light hover:bg-error-bg hover:text-error" title="Hapus"><x-heroicon-o-trash class="h-3.5 w-3.5" /></button>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-for="f in files" :key="f.url">
                                        <div class="rounded-lg border border-dashed border-brand-normal/50 bg-brand-light/50 p-2">
                                            <div class="flex h-16 items-center justify-center rounded-md bg-white p-2"><img :src="f.url" alt="" class="max-h-full max-w-full object-contain"></div>
                                            <p class="mt-2 truncate text-caption" x-text="f.name"></p>
                                        </div>
                                    </template>
                                </div>
                                <p class="mt-1.5 text-caption text-brand-muted">PNG transparan disarankan · maks 2 MB per file.</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </x-admin.card>
        @endforeach

        <div class="flex items-center justify-end gap-2 rounded-xl border border-brand-border bg-white px-5 py-4">
            <x-admin.button :href="route('admin.content.edit', $page)" variant="secondary">Batal</x-admin.button>
            <x-admin.button type="submit" icon="check">Simpan</x-admin.button>
        </div>
    </form>
</x-admin.layouts.app>
