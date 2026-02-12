@extends('layouts.app')

@section('content')
<h1>SEO Sayfaları</h1>
<form method="post" action="{{ route('admin.seo-pages.store') }}">
    @csrf
    <input name="page_type" placeholder="city|district|point">
    <input name="ref_id" placeholder="ref_id">
    <input name="h1" placeholder="H1">
    <input name="title" placeholder="Title">
    <textarea name="meta_description" placeholder="Meta description"></textarea>
    <textarea name="content" placeholder="İçerik HTML/Markdown"></textarea>
    <textarea name="faq_json" placeholder="FAQ JSON"></textarea>
    <textarea name="schema_override" placeholder="Schema override JSON"></textarea>
    <button type="submit">Kaydet</button>
</form>

<table>
    <thead><tr><th>ID</th><th>Tip</th><th>Ref</th><th>Title</th><th>Güncellendi</th></tr></thead>
    <tbody>
    @foreach($pages as $page)
        <tr>
            <td>{{ $page->id }}</td>
            <td>{{ $page->page_type }}</td>
            <td>{{ $page->ref_id }}</td>
            <td>{{ $page->title }}</td>
            <td>{{ $page->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $pages->links() }}
@endsection
