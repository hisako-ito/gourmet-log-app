<?php

namespace App\Http\Controllers\Auth\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\Owner;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class OwnerVerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $owner = Owner::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('hash'), sha1($owner->getEmailForVerification()))) {
            abort(403, '不正な認証リンクです');
        }

        if ($owner->hasVerifiedEmail()) {
            return redirect($request->query('redirect', '/owner/login'))->with('message', 'すでに認証済みです');
        }

        if ($owner->markEmailAsVerified()) {
            event(new Verified($owner));
        }

        return redirect($request->query('redirect', '/owner/login'))->with('message', 'メールアドレスが確認されました');
    }
}
