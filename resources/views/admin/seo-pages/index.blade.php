<!DOCTYPE html>
<html lang="tr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>SEO Sayfaları</title>@vite(['resources/css/app.css'])</head>
<body class="bg-slate-50 p-6">
<h1 class="text-2xl font-bold mb-4">SEO Sayfaları</h1>
<form method="GET" class="mb-4">
    <select name="page_type" class="border rounded px-3 py-2">
        <option value="">Tümü</option>
        @foreach(['city','district','point','industry','city_industry'] as $type)
            <option value="{{ $type }}" @selected($pageType===$type)>{{ $type }}</option>
        @endforeach
    </select>
    <button class="bg-blue-700 text-white rounded px-3 py-2">Filtrele</button>
</form>

@foreach($seoPages as $seoPage)
<form method="POST" action="{{ route('admin.seo-pages.update', $seoPage) }}" class="bg-white p-4 rounded border mb-3 space-y-2">
    @csrf @method('PUT')
    <div class="text-sm text-slate-500">{{ $seoPage->page_type }} #{{ $seoPage->ref_id }}</div>
    <input name="title" value="{{ $seoPage->title }}" class="w-full border rounded px-3 py-2">
    <textarea name="description" class="w-full border rounded px-3 py-2">{{ $seoPage->description }}</textarea>
    <textarea name="content" class="w-full border rounded px-3 py-2" rows="4">{{ $seoPage->content }}</textarea>
    <textarea name="schema_override" class="w-full border rounded px-3 py-2" rows="3">{{ $seoPage->schema_override }}</textarea>
    <button class="bg-slate-800 text-white rounded px-3 py-2">Kaydet</button>
</form>
@endforeach

{{ $seoPages->links() }}
</body></html>
