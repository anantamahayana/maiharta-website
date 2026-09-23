<a
    href="{{ route($tab['route']) }}"
    @class([
        'group relative flex h-14 flex-1 flex-col items-center justify-center gap-0.5 rounded-full text-[11px] font-medium transition-colors',
        'text-brand-normal' => $tab['active'],
        'text-brand-muted active:text-brand-dark' => ! $tab['active'],
    ])
    @if ($tab['active']) aria-current="page" @endif
>
    @if ($tab['active'])
        <span class="bottom-nav__glow bottom-nav__active absolute inset-x-1 inset-y-1 rounded-full bg-brand-light" aria-hidden="true"></span>
    @endif
    <span @class(['relative grid size-7 place-items-center transition-transform duration-300 ease-out-expo', '-translate-y-0.5' => $tab['active'], 'group-active:scale-90' => ! $tab['active']])>
        @svg('heroicon-' . ($tab['active'] ? 's' : 'o') . '-' . $tab['icon'], 'size-[22px]')
    </span>
    <span class="relative leading-none">{{ $tab['label'] }}</span>
    @if ($tab['active'])
        <span class="bottom-nav__dot absolute -bottom-0.5 size-1 rounded-full bg-brand-normal" aria-hidden="true"></span>
    @endif
</a>
