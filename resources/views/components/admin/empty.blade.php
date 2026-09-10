@props(['icon' => 'inbox', 'title', 'description' => null])
<div class="flex flex-col items-center px-6 py-14 text-center">
    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-light text-brand-normal"><x-dynamic-component :component="'heroicon-o-' . $icon" class="h-6 w-6" /></span>
    <p class="mt-4 text-h5 font-medium text-brand-dark">{{ $title }}</p>
    @if ($description)<p class="mt-1 max-w-[360px] text-body-sm text-brand-muted">{{ $description }}</p>@endif
    @if ($slot->isNotEmpty())<div class="mt-5">{{ $slot }}</div>@endif
</div>
