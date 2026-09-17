<x-admin.layouts.guest title="Kata Sandi Baru" heading="Buat Kata Sandi Baru" subheading="Minimal 8 karakter. Setelah disimpan, masuk dengan kata sandi baru.">
        <form novalidate method="POST" action="{{ route('admin.password.update') }}" class="mt-7 space-y-4" x-data="{ show: false }">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <x-admin.field label="Email" name="email" type="email" :value="$email" required autocomplete="email" />
            <div>
                <label for="password" class="mb-1.5 block text-label font-medium">Kata Sandi Baru</label>
                <div data-field class="flex items-center overflow-hidden rounded-lg border bg-brand-input transition focus-within:border-brand-normal focus-within:bg-white focus-within:ring-[3px] focus-within:ring-brand-normal/20 {{ $errors->has('password') ? 'border-error' : 'border-brand-border' }}">
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required minlength="8" autocomplete="new-password" placeholder="••••••••••" class="w-full bg-transparent px-3.5 py-2.5 text-body-sm outline-none placeholder:text-brand-placeholder">
                    <button type="button" @click="show = !show" class="px-3 text-brand-muted hover:text-brand-dark" :aria-label="show ? 'Sembunyikan' : 'Tampilkan'">
                        <x-heroicon-o-eye x-show="!show" class="h-4 w-4" /><x-heroicon-o-eye-slash x-show="show" x-cloak class="h-4 w-4" />
                    </button>
                </div>
                @error('password')<p class="mt-1.5 flex items-center gap-1 text-caption text-error"><x-heroicon-o-exclamation-circle class="h-3.5 w-3.5" />{{ $message }}</p>@enderror
            </div>
            <x-admin.field label="Konfirmasi Kata Sandi" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="••••••••••" data-match="password" data-msg-match="Konfirmasi kata sandi tidak cocok." />
            <x-admin.button type="submit" class="w-full py-3">Simpan Kata Sandi</x-admin.button>
        </form>
</x-admin.layouts.guest>
