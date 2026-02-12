<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PartnerAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('partner.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['phone' => 'Kimlik bilgileri hatalı.'])->onlyInput('phone');
        }

        $request->session()->regenerate();

        if ($request->user()->role !== 'partner') {
            Auth::logout();
            return back()->withErrors(['phone' => 'Bu giriş ekranı sadece partner içindir.']);
        }

        if ($request->user()->status !== 'active') {
            Auth::logout();
            return back()->withErrors(['phone' => 'Hesap pasif durumda.']);
        }

        return redirect()->intended(route('partner.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('partner.login');
    }
}
