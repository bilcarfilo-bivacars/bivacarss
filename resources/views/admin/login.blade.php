<x-layouts.auth title="Admin Giriş" heading="Admin Paneli" subheading="BivaCars yönetim paneline giriş yapın.">
    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
        @csrf
        <div>
            <label for="phone" class="mb-1 block text-sm font-medium text-slate-600">Telefon</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autofocus class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500">
        </div>
        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-600">Şifre</label>
            <input id="password" type="password" name="password" required class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500">
        </div>
        <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2 font-medium text-white hover:bg-brand-700">
            Giriş Yap
        </button>
    </form>
</x-layouts.auth>
