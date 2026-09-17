<x-admin.layouts.guest title="Masuk" heading="Panel Admin" subheading="Masuk untuk mengelola konten website">
        <form novalidate method="POST" action="{{ route('admin.login.store') }}" class="mt-7 space-y-4" x-data="{ show: false }">
            @csrf
            <x-admin.field label="Email" name="email" type="email" placeholder="admin@maiharta.com" required autofocus autocomplete="email" />
            <div>
                <label for="password" class="mb-1.5 block text-label font-medium">Kata Sandi</label>
                <div data-field class="flex items-center overflow-hidden rounded-lg border bg-brand-input transition focus-within:border-brand-normal focus-within:bg-white focus-within:ring-[3px] focus-within:ring-brand-normal/20 {{ $errors->has('password') ? 'border-error' : 'border-brand-border' }}">
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required autocomplete="current-password" placeholder="••••••••••" class="w-full bg-transparent px-3.5 py-2.5 text-body-sm outline-none placeholder:text-brand-placeholder">
                    <button type="button" @click="show = !show" class="px-3 text-brand-muted hover:text-brand-dark" :aria-label="show ? 'Sembunyikan' : 'Tampilkan'">
                        <x-heroicon-o-eye x-show="!show" class="h-4 w-4" /><x-heroicon-o-eye-slash x-show="show" x-cloak class="h-4 w-4" />
                    </button>
                </div>
                @error('password')<p class="mt-1.5 text-caption text-error">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-body-sm"><input type="checkbox" name="remember" class="h-[18px] w-[18px] rounded border-brand-border text-brand-normal focus:ring-brand-normal">Ingat saya</label>
                <a href="{{ route('admin.password.request') }}" class="text-label font-medium text-brand-normal hover:text-brand-normal-hover">Lupa kata sandi?</a>
            </div>
            <x-admin.button type="submit" class="w-full py-3">Masuk</x-admin.button>
        </form>
        <p class="mt-6 text-center text-caption text-brand-muted">Akses terbatas untuk administrator. Aktivitas login tercatat.</p>
</x-admin.layouts.guest>
