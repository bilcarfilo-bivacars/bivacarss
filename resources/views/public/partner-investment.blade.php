@extends('layouts.app')

@section('title', 'Aracımı Kiraya Verirsem Ne Kadar Kazanırım? | BivaCars')
@section('meta_description', 'Gebze araç kiralama, iş ortağı başvurusu ve araç yatırım kazanç hesaplama rehberi. Aracınızı kiraya vererek olası aylık net geliri hızlıca hesaplayın.')

@section('content')
<div class="container py-5">
    <section class="mb-5">
        <h1 class="mb-3">Aracımı Kiraya Verirsem Ne Kadar Kazanırım?</h1>
        <p class="text-muted">Aracınızı BivaCars iş ortağı modeliyle değerlendirmeyi düşünüyorsanız, aşağıdaki örnek senaryo ve hesaplayıcı ile yaklaşık bir çerçeve oluşturabilirsiniz.</p>
        <a class="btn btn-success" target="_blank" rel="noopener" href="https://wa.me/905000000000?text={{ urlencode('Merhaba, BivaCars iş ortağı modeli hakkında bilgi almak istiyorum.') }}">WhatsApp ile İş Ortağı Bilgisi Al</a>
    </section>

    <section class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Ahmet Senaryosu</h2>
                    <p class="mb-1">6.000.000 TL ev yatırımı</p>
                    <p class="fw-semibold mb-0">Aylık 35.000 TL kira geliri (örnek)</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-body">
                    <h2 class="h5">Hasan Senaryosu</h2>
                    <p class="mb-1">800.000 TL araç yatırımı</p>
                    <p class="fw-semibold mb-0">Aylık 40.000 TL + KDV kira geliri (örnek)</p>
                </div>
            </div>
        </div>
    </section>

    <p class="small text-warning mb-5">Uyarı: Bu bir örnek senaryodur, piyasa koşulları, sezon, araç tipi ve operasyonel koşullara göre değişebilir.</p>

    <section class="row g-4 mb-5" id="hesaplayici">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">Ne Kadar Kazanırım?</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Araç Fiyatı (TL)</label>
                            <input type="number" class="form-control calc-input" id="arac_fiyati" value="800000" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Aylık Kira (TL)</label>
                            <input type="number" class="form-control calc-input" id="aylik_kira" value="40000" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Komisyon Oranı (%)</label>
                            <input type="number" class="form-control calc-input" id="komisyon_orani" value="15" min="0" max="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Araç Adedi</label>
                            <input type="number" class="form-control calc-input" id="arac_adedi" value="1" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">KDV Durumu</label>
                            <select class="form-select" id="kdv_durumu">
                                <option value="haric">Hariç</option>
                                <option value="dahil">Dahil</option>
                            </select>
                            <small class="text-muted">Hesap net tutarlar için KDV hariç baz alınır.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm bg-light h-100">
                <div class="card-body">
                    <h3 class="h5">Hesap Sonucu</h3>
                    <ul class="list-unstyled mb-0">
                        <li>Net Aylık: <strong id="net_aylik">0 TL</strong></li>
                        <li>Yıllık Net: <strong id="yillik_net">0 TL</strong></li>
                        <li>Toplam Yıllık (Araç Adedine Göre): <strong id="toplam_yillik">0 TL</strong></li>
                        <li>Toplam Yatırım: <strong id="toplam_yatirim">0 TL</strong></li>
                        <li>Getiri Oranı: <strong id="getiri_orani">0%</strong></li>
                    </ul>
                    <p class="small text-muted mt-3 mb-0">Bu hesaplayıcı bilgilendirme amaçlıdır ve kesin gelir taahhüdü oluşturmaz.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="partner-basvuru">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h4 mb-3">İş Ortağı Başvuru Formu</h2>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('partner.investment.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <input type="hidden" name="calculation_json" id="calculation_json">
                    <div class="col-md-6">
                        <label class="form-label">Ad Soyad</label>
                        <input type="text" name="ad_soyad" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefon</label>
                        <input type="text" name="telefon" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Şehir</label>
                        <select name="sehir" class="form-select">
                            <option>Istanbul Anadolu</option>
                            <option>Kocaeli</option>
                            <option>Diğer</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Araç Markası</label>
                        <input type="text" name="arac_markasi" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Araç Modeli</label>
                        <input type="text" name="arac_model" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Yıl</label>
                        <input type="number" name="yil" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KM</label>
                        <input type="number" name="km" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Beklenen Aylık Kira</label>
                        <input type="number" name="beklenen_aylik_kira" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hasar Kaydı</label>
                        <select name="hasar_kaydi_var_mi" class="form-select">
                            <option value="hayır">Hayır</option>
                            <option value="evet">Evet</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Araç Fotoğrafı (Opsiyonel)</label>
                        <input type="file" name="arac_foto" class="form-control" accept="image/png,image/jpeg,image/webp">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Açıklama (Opsiyonel)</label>
                        <textarea name="aciklama" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Başvuruyu Gönder</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Araç kiraya verirsem ödeme ne zaman yapılır?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Ödeme dönemleri sözleşme ve operasyon modeline göre belirlenir, başvuru sonrası süreç detaylıca paylaşılır."
      }
    },
    {
      "@type": "Question",
      "name": "Komisyon oranı nedir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Komisyon oranı araç tipine, sezona ve operasyon kapsamına göre farklılaşabilir."
      }
    },
    {
      "@type": "Question",
      "name": "Hangi araçlar kabul edilir?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Genel olarak 3 yaş altı ve 70 bin km altı araçlar daha uygundur; nihai değerlendirme araç ekspertizi ve operasyon koşullarına göre yapılır."
      }
    }
  ]
}
</script>

<script>
    function currency(value) {
        return new Intl.NumberFormat('tr-TR', { maximumFractionDigits: 2 }).format(value) + ' TL';
    }

    function calculate() {
        const aracFiyati = Number(document.getElementById('arac_fiyati').value) || 0;
        const aylikKira = Number(document.getElementById('aylik_kira').value) || 0;
        const komisyonOrani = Number(document.getElementById('komisyon_orani').value) || 0;
        const aracAdedi = Number(document.getElementById('arac_adedi').value) || 1;

        const netAylik = aylikKira - (aylikKira * komisyonOrani / 100);
        const yillikNet = netAylik * 12;
        const toplamYillik = yillikNet * aracAdedi;
        const toplamYatirim = aracFiyati * aracAdedi;
        const getiriOrani = toplamYatirim > 0 ? ((toplamYillik / toplamYatirim) * 100) : 0;

        document.getElementById('net_aylik').innerText = currency(netAylik);
        document.getElementById('yillik_net').innerText = currency(yillikNet);
        document.getElementById('toplam_yillik').innerText = currency(toplamYillik);
        document.getElementById('toplam_yatirim').innerText = currency(toplamYatirim);
        document.getElementById('getiri_orani').innerText = getiriOrani.toFixed(2) + '%';

        document.getElementById('calculation_json').value = JSON.stringify({
            arac_fiyati: aracFiyati,
            aylik_kira: aylikKira,
            komisyon_orani: komisyonOrani,
            arac_adedi: aracAdedi,
            kdv_durumu: document.getElementById('kdv_durumu').value,
            net_aylik: netAylik,
            yillik_net: yillikNet,
            toplam_yillik: toplamYillik,
            toplam_yatirim: toplamYatirim,
            getiri_orani: getiriOrani,
        });
    }

    document.querySelectorAll('.calc-input, #kdv_durumu').forEach((el) => {
        el.addEventListener('input', calculate);
        el.addEventListener('change', calculate);
    });

    calculate();
</script>
@endsection
