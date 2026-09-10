@php
    $tabs = [['semua', 'Semua'], ['belum-dibaca', 'Belum Dibaca'], ['dibaca', 'Sudah Dibaca']];
    $initials = fn ($n) => Str::of($n)->explode(' ')->map(fn ($w) => Str::substr($w, 0, 1))->take(2)->implode('');
@endphp

<x-admin.layouts.app title="Pesan Kontak" :crumb="'Kotak masuk · ' . $unreadCount . ' belum dibaca'">
    <form method="GET" class="flex flex-wrap items-center gap-3">
        <input type="hidden" name="filter" value="{{ $filter }}">
        <div class="flex min-w-[260px] items-center gap-2 rounded-lg border border-brand-border bg-white px-3.5 py-2">
            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-brand-muted" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama, email, perusahaan, isi pesan…" class="w-full bg-transparent text-body-sm outline-none placeholder:text-brand-placeholder">
        </div>
        <div class="flex gap-1 rounded-lg border border-brand-border bg-white p-[3px]">
            @foreach ($tabs as [$key, $label])
                <a href="{{ route('admin.messages.index', array_filter(['filter' => $key === 'semua' ? null : $key, 'q' => $search])) }}" class="flex items-center gap-1.5 rounded-md px-3 py-1.5 text-label font-medium {{ $filter === $key ? 'bg-brand-dark text-white' : 'text-brand-dark hover:bg-brand-light' }}">
                    {{ $label }}@if ($key === 'belum-dibaca' && $unreadCount)<span class="rounded-full px-1.5 text-chip {{ $filter === $key ? 'bg-brand-surface-on-dark' : 'bg-brand-normal text-white' }}">{{ $unreadCount }}</span>@endif
                </a>
            @endforeach
        </div>
    </form>

    <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[400px_1fr]">
        {{-- List --}}
        <x-admin.card padding="p-0" class="overflow-hidden">
            @if ($messages->isEmpty())
                <x-admin.empty icon="envelope" :title="$search ? 'Tidak ada hasil' : 'Kotak masuk kosong'" :description="$search ? 'Tidak ada pesan yang cocok dengan “' . $search . '”.' : 'Pesan dari formulir kontak akan muncul di sini.'" />
            @else
                <ul class="divide-y divide-brand-light">
                    @foreach ($messages as $m)
                        <li>
                            <a href="{{ route('admin.messages.show', $m) }}?{{ http_build_query(array_filter(['filter' => $filter, 'q' => $search])) }}" class="flex items-start gap-3 px-4 py-3.5 transition hover:bg-brand-input {{ $selected?->is($m) ? 'bg-brand-light' : '' }}">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-label-sm font-medium {{ $m->is_read ? 'bg-brand-light text-brand-dark' : 'bg-brand-normal text-white' }}">{{ $initials($m->name) }}</span>
                                <span class="min-w-0 flex-1">
                                    <span class="flex items-center justify-between gap-2"><span class="truncate text-body-sm {{ $m->is_read ? '' : 'font-semibold' }}">{{ $m->name }}</span><span class="shrink-0 text-caption text-brand-muted">{{ $m->created_at->diffForHumans(short: true) }}</span></span>
                                    @if ($m->company)<span class="block truncate text-caption text-brand-muted">{{ $m->company }}</span>@endif
                                    <span class="mt-0.5 block truncate text-caption {{ $m->is_read ? 'text-brand-muted' : 'text-brand-dark' }}">{{ Str::limit($m->message, 80) }}</span>
                                </span>
                                @unless ($m->is_read)<span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-brand-normal"></span>@endunless
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if ($messages->hasPages())<div class="border-t border-brand-border px-4 py-3 text-caption">{{ $messages->links() }}</div>@endif
            @endif
        </x-admin.card>

        {{-- Detail --}}
        <x-admin.card padding="p-0" class="overflow-hidden">
            @if ($selected)
                @php $serviceTag = Str::match('/^\[Layanan: (.+?)\]\s*/', $selected->message); $body = Str::of($selected->message)->replaceMatches('/^\[Layanan: .+?\]\s*/', ''); @endphp
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-brand-border px-6 py-5">
                    <div class="flex items-center gap-3.5">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-light font-heading text-body-sm font-semibold text-brand-dark">{{ $initials($selected->name) }}</span>
                        <span>
                            <span class="block font-heading text-h4 font-medium">{{ $selected->name }}</span>
                            <span class="block text-caption text-brand-muted"><a href="mailto:{{ $selected->email }}" class="text-brand-normal hover:underline">{{ $selected->email }}</a>{{ $selected->company ? ' · ' . $selected->company : '' }}</span>
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.messages.toggle', $selected) }}">@csrf @method('PATCH')<x-admin.button type="submit" variant="secondary" size="sm" :icon="$selected->is_read ? 'envelope' : 'envelope-open'">{{ $selected->is_read ? 'Tandai belum dibaca' : 'Tandai dibaca' }}</x-admin.button></form>
                        <x-admin.confirm-delete :action="route('admin.messages.destroy', $selected)" icon-only :title="'Hapus pesan dari ' . $selected->name . '?'" />
                    </div>
                </div>
                <div class="px-6 py-5">
                    <div class="flex flex-wrap items-center gap-2 text-caption text-brand-muted">
                        <x-heroicon-o-clock class="h-3.5 w-3.5" /> {{ $selected->created_at->translatedFormat('l, d F Y · H:i') }} WITA
                        @if ($serviceTag)<x-chip class="ml-2">{{ $serviceTag }}</x-chip>@endif
                        <x-chip :variant="$selected->is_read ? 'light' : 'accent'" class="ml-auto">{{ $selected->is_read ? 'Sudah dibaca' : 'Baru' }}</x-chip>
                    </div>
                    <div class="mt-5 whitespace-pre-line rounded-xl bg-brand-input p-5 text-body-sm leading-relaxed text-brand-dark">{{ $body }}</div>
                    <div class="mt-5 flex flex-wrap gap-2">
                        <x-admin.button href="mailto:{{ $selected->email }}?subject={{ rawurlencode('Re: Permintaan konsultasi — Maiharta') }}" icon="arrow-uturn-left">Balas via Email</x-admin.button>
                        <x-admin.button href="https://wa.me/?text={{ rawurlencode('Halo ' . $selected->name . ', terima kasih telah menghubungi Maiharta.') }}" target="_blank" variant="secondary" icon="chat-bubble-left-right">Balas via WhatsApp</x-admin.button>
                    </div>
                </div>
            @else
                <x-admin.empty icon="envelope-open" title="Pilih pesan untuk membaca" description="Klik salah satu pesan di daftar kiri. Pesan otomatis ditandai sudah dibaca saat dibuka." />
            @endif
        </x-admin.card>
    </div>
</x-admin.layouts.app>
