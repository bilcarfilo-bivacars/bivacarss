<!DOCTYPE html>
<html lang="tr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Sektörler</title>@vite(['resources/css/app.css'])</head>
<body class="bg-slate-50 p-6">
<h1 class="text-2xl font-bold mb-4">Sektörler</h1>
<form method="POST" action="{{ route('admin.industries.store') }}" class="bg-white p-4 rounded border mb-6 space-y-2">
    @csrf
    <input name="key" placeholder="key" class="w-full border rounded px-3 py-2" required>
    <input name="name" placeholder="ad" class="w-full border rounded px-3 py-2" required>
    <textarea name="description" placeholder="açıklama" class="w-full border rounded px-3 py-2"></textarea>
    <input name="sort_order" type="number" class="w-full border rounded px-3 py-2" value="0">
    <label><input type="checkbox" name="active" value="1" checked> aktif</label>
    <button class="bg-blue-700 text-white rounded px-3 py-2">Ekle</button>
</form>

@foreach($industries as $industry)
<form method="POST" action="{{ route('admin.industries.update', $industry) }}" class="bg-white p-4 rounded border mb-3 space-y-2">
    @csrf @method('PUT')
    <div class="font-semibold">{{ $industry->key }}</div>
    <input name="name" value="{{ $industry->name }}" class="w-full border rounded px-3 py-2" required>
    <textarea name="description" class="w-full border rounded px-3 py-2">{{ $industry->description }}</textarea>
    <input name="sort_order" type="number" class="w-full border rounded px-3 py-2" value="{{ $industry->sort_order }}">
    <label><input type="checkbox" name="active" value="1" @checked($industry->active)> aktif</label>
    <button class="bg-slate-800 text-white rounded px-3 py-2">Kaydet</button>
</form>
@endforeach
</body></html>
