@props(['project', 'imageHeight' => 'aspect-[16/10]'])

<x-card :href="route('portofolio.show', $project)" padding="p-0" {{ $attributes->merge(['class' => 'overflow-hidden']) }}>
    <div class="{{ $imageHeight }} w-full overflow-hidden bg-brand-light-hover">
        <img src="{{ $project->cover_image ? asset($project->cover_image) : asset('images/projects/' . $project->slug . '.jpg') }}" alt="{{ $project->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
    </div>
    <div class="p-5 md:p-6">
        <x-chip>{{ $project->category }}</x-chip>
        <h3 class="mt-3 font-heading text-h4 font-medium text-brand-dark">{{ $project->name }}</h3>
        <p class="mt-2 line-clamp-3 text-body-sm text-brand-muted">{{ $project->short_description }}</p>
        <span class="mt-4 inline-flex items-center gap-1.5 text-label font-medium text-brand-normal">
            Lihat Detail Proyek <x-heroicon-o-arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
        </span>
    </div>
</x-card>
