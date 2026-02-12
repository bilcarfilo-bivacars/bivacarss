<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PartnerLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartnerLeadController extends Controller
{
    public function show(): View
    {
        return view('public.partner-investment');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ad_soyad' => ['required', 'string', 'max:255'],
            'telefon' => ['required', 'string', 'max:50'],
            'sehir' => ['nullable', 'string', 'max:255'],
            'arac_markasi' => ['nullable', 'string', 'max:255'],
            'arac_model' => ['nullable', 'string', 'max:255'],
            'yil' => ['nullable', 'integer', 'digits:4'],
            'km' => ['nullable', 'integer', 'min:0'],
            'beklenen_aylik_kira' => ['nullable', 'numeric', 'min:0'],
            'hasar_kaydi_var_mi' => ['nullable', 'in:evet,hayır,hayir'],
            'aciklama' => ['nullable', 'string', 'max:5000'],
            'arac_foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'calculation_json' => ['nullable', 'string'],
        ]);

        $photoPath = $request->file('arac_foto')?->store('partner-leads', 'public');

        PartnerLead::create([
            'full_name' => $this->clean($validated['ad_soyad'] ?? ''),
            'phone' => $this->clean($validated['telefon'] ?? ''),
            'city' => $this->clean($validated['sehir'] ?? ''),
            'brand' => $this->clean($validated['arac_markasi'] ?? ''),
            'model' => $this->clean($validated['arac_model'] ?? ''),
            'year' => $validated['yil'] ?? null,
            'km' => $validated['km'] ?? null,
            'expected_rent' => $validated['beklenen_aylik_kira'] ?? null,
            'has_damage' => in_array(Str::lower((string) ($validated['hasar_kaydi_var_mi'] ?? 'hayır')), ['evet'], true),
            'notes' => $this->clean($validated['aciklama'] ?? ''),
            'photo_path' => $photoPath,
            'calculation_json' => $validated['calculation_json'] ?? null,
            'status' => 'new',
        ]);

        return redirect()
            ->route('partner.investment.show')
            ->with('success', 'Başvurunuz alındı. En kısa sürede sizinle iletişime geçeceğiz.');
    }

    private function clean(string $value): string
    {
        return trim(strip_tags($value));
    }
}
