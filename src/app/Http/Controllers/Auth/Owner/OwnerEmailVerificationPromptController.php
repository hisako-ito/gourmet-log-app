<?php

namespace App\Http\Controllers\Auth\Owner;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OwnerEmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $owner = Auth::guard('owner')->user();
        return $owner->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : view('auth.owner.verify-email');
    }
}
