<?php

namespace App\Http\Controllers\Auth\Owner;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class OwnerAuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function ownerCreate()
    {
        return view('auth.owner.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ownerStore(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('owner')->attempt($credentials, $request->filled('remember'))) {
            return back()->withErrors([
                'email' => '認証に失敗しました。',
            ])->withInput();
        }

        $owner = Auth::guard('owner')->user();

        if (!$owner->hasVerifiedEmail()) {
            Auth::guard('owner')->logout();

            return back()->withErrors([
                'email' => 'メールアドレスが確認されていません。確認メールをご確認ください。',
            ])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ownerDestroy(Request $request)
    {
        Auth::guard('owner')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('owner.login');
    }
}
