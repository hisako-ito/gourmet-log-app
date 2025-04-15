<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Notifications\OwnerVerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeMail;
use App\Http\Requests\MailRequest;

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

    public function sendNotice(MailRequest $request)
    {
        $users = User::all();
        $owners = Owner::all();

        logger('User件数: ' . $users->count());
        logger('Owner件数: ' . $owners->count());

        $recipients = $users->merge($owners);

        logger('全送信対象の件数: ' . $recipients->count());
        foreach ($recipients as $recipient) {
            logger('送信対象: ' . get_class($recipient) . ' / ' . $recipient->email);
        }

        foreach ($users as $user) {
            logger('User送信対象: ' . $user->email);
            Mail::to($user->email)->send(new NoticeMail($request->subject, $request->body, $user));
        }

        foreach ($owners as $owner) {
            logger('Owner送信対象: ' . $owner->email);
            Mail::to($owner->email)->send(new NoticeMail($request->subject, $request->body, $owner));
        }


        return redirect()->route('admin.page')->with('message', '利用者にお知らせメールを送信しました。');
    }
}
