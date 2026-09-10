{{-- <x-admin.confirm-delete :action="route(...)" title="…" description="…" [icon-only]>Label</x-admin.confirm-delete> --}}
@props(['action', 'title' => 'Hapus data ini?', 'description' => 'Tindakan ini permanen dan tidak bisa dibatalkan.', 'iconOnly' => false])
<div x-data="{ open: false }" class="inline-block">
    @if ($iconOnly)
        <button type="button" @click="open = true" title="Hapus" class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-brand-light text-brand-dark transition hover:bg-error-bg hover:text-error"><x-heroicon-o-trash class="h-4 w-4" /></button>
    @else
        <x-admin.button variant="danger" icon="trash" @click="open = true">{{ $slot }}</x-admin.button>
    @endif
    <template x-teleport="body">
        <div x-show="open" x-cloak @keydown.escape.window="open = false" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-darker/50 p-4 backdrop-blur-sm">
            <div @click.outside="open = false" class="w-full max-w-[420px] rounded-2xl bg-white p-6 shadow-hero">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-error-bg text-error"><x-heroicon-o-exclamation-triangle class="h-6 w-6" /></span>
                <h3 class="mt-4 font-heading text-h4 font-medium text-brand-dark">{{ $title }}</h3>
                <p class="mt-1.5 text-body-sm text-brand-muted">{{ $description }}</p>
                <form method="POST" action="{{ $action }}" class="mt-6 flex justify-end gap-2">
                    @csrf
                    @method('DELETE')
                    <x-admin.button variant="secondary" @click="open = false">Batal</x-admin.button>
                    <x-admin.button type="submit" variant="danger-solid">Ya, Hapus</x-admin.button>
                </form>
            </div>
        </div>
    </template>
</div>
