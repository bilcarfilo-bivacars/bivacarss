@extends('layouts.app')

@section('content')
<h1>Hizmet Bölgeleri Yönetimi</h1>

<section>
    <h2>Şehir Ekle</h2>
    <form method="post" action="{{ route('admin.service-areas.city.store') }}">@csrf
        <input name="name" placeholder="Ad">
        <input name="slug" placeholder="slug">
        <input name="region_group" placeholder="istanbul-anadolu / kocaeli">
        <button type="submit">Ekle</button>
    </form>
</section>

<section>
    <h2>İlçe Ekle</h2>
    <form method="post" action="{{ route('admin.service-areas.district.store') }}">@csrf
        <input name="city_id" placeholder="city_id">
        <input name="name" placeholder="Ad">
        <input name="slug" placeholder="slug">
        <button type="submit">Ekle</button>
    </form>
</section>

<section>
    <h2>Nokta Ekle</h2>
    <form method="post" action="{{ route('admin.service-areas.point.store') }}">@csrf
        <input name="city_id" placeholder="city_id">
        <input name="district_id" placeholder="district_id">
        <input name="type" placeholder="otogar|tren-gari|avm|havalimani">
        <input name="name" placeholder="Ad">
        <input name="slug" placeholder="slug">
        <button type="submit">Ekle</button>
    </form>
</section>

@foreach($cities as $city)
<article>
    <h3>{{ $city->name }} ({{ $city->active ? 'aktif' : 'pasif' }})</h3>
    <form method="post" action="{{ route('admin.service-areas.city.toggle', $city) }}">@csrf @method('PATCH')<button>Aktif/Pasif</button></form>
    <ul>
        @foreach($city->districts as $district)
            <li>{{ $district->name }} ({{ $district->active ? 'aktif' : 'pasif' }})
                <form method="post" action="{{ route('admin.service-areas.district.toggle', $district) }}">@csrf @method('PATCH')<button>Aktif/Pasif</button></form>
                <ul>
                    @foreach($district->points as $point)
                        <li>{{ $point->name }} / {{ $point->type }}
                            <form method="post" action="{{ route('admin.service-areas.point.toggle', $point) }}">@csrf @method('PATCH')<button>Aktif/Pasif</button></form>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</article>
@endforeach
@endsection
