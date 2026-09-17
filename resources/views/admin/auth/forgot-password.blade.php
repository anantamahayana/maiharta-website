<x-admin.layouts.guest title="Lupa Kata Sandi" heading="Lupa Kata Sandi?" subheading="Masukkan email admin Anda. Kami kirimkan tautan untuk membuat kata sandi baru.">
        <form novalidate method="POST" action="{{ route('admin.password.email') }}" class="mt-7 space-y-4">
            @csrf
            <x-admin.field label="Email" name="email" type="email" placeholder="admin@maiharta.com" required autofocus autocomplete="email" />
            <x-admin.button type="submit" class="w-full py-3">Kirim Tautan Reset</x-admin.button>
        </form>
        <p class="mt-6 text-center text-caption text-brand-muted"><a href="{{ route('admin.login') }}" class="font-medium text-brand-normal hover:text-brand-normal-hover">&larr; Kembali ke halaman masuk</a></p>
</x-admin.layouts.guest>
