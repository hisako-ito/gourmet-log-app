<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Notifications\OwnerVerifyEmail;
use App\Models\Shop;

class AdminController extends Controller
{
    public function showAdminPage()
    {


        return view('admin-mypage');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ownerStore(RegisterRequest $request)
    {
        $validated = $request->validated();

        $owner = Owner::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $owner->notify(new OwnerVerifyEmail($validated['password']));

        return redirect()->route('admin.page')->with('message', '店舗代表者を登録しました。登録した店舗代表者のメールアドレスに認証メールを送信済みです。');
    }
}
