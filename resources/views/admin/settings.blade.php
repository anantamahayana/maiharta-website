<x-admin.layouts.app title="Pengaturan Akun" crumb="Pengaturan">
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        <x-admin.card title="Profil">
            <form method="POST" action="{{ route('admin.settings.profile') }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="flex items-center gap-4">
                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-normal font-heading text-h4 font-semibold text-white">{{ Str::of($user->name)->explode(' ')->map(fn ($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}</span>
                    <span><span class="block text-body-sm font-semibold">{{ $user->name }}</span><span class="block text-caption text-brand-muted">Administrator · bergabung {{ $user->created_at->translatedFormat('M Y') }}</span></span>
                </div>
                <x-admin.field label="Nama" name="name" :value="$user->name" required />
                <x-admin.field label="Email" name="email" type="email" :value="$user->email" required help="Dipakai untuk masuk ke panel admin." />
                <div class="flex justify-end"><x-admin.button type="submit" icon="check">Simpan Profil</x-admin.button></div>
            </form>
        </x-admin.card>

        <x-admin.card title="Ubah Kata Sandi">
            <form method="POST" action="{{ route('admin.settings.password') }}" class="space-y-4">
                @csrf @method('PUT')
                <x-admin.field label="Kata Sandi Saat Ini" name="current_password" type="password" required autocomplete="current-password" />
                <x-admin.field label="Kata Sandi Baru" name="password" type="password" required autocomplete="new-password" help="Minimal 8 karakter." />
                <x-admin.field label="Konfirmasi Kata Sandi Baru" name="password_confirmation" type="password" required autocomplete="new-password" />
                <div class="flex justify-end"><x-admin.button type="submit" icon="lock-closed">Ubah Kata Sandi</x-admin.button></div>
            </form>
        </x-admin.card>

        <x-admin.card title="Informasi Sistem" class="lg:col-span-2">
            <dl class="grid grid-cols-1 gap-4 text-body-sm md:grid-cols-3">
                @foreach ([['Laravel', app()->version()], ['PHP', PHP_VERSION], ['Lingkungan', app()->environment()], ['Zona waktu', config('app.timezone')], ['Database', config('database.default')], ['Website publik', config('app.url')]] as [$k, $v])
                    <div class="rounded-lg bg-brand-input px-4 py-3"><dt class="text-caption text-brand-muted">{{ $k }}</dt><dd class="mt-0.5 font-medium">{{ $v }}</dd></div>
                @endforeach
            </dl>
        </x-admin.card>
    </div>
</x-admin.layouts.app>
