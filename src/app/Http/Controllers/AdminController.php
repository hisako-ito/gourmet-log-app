<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Notifications\OwnerVerifyEmail;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeMail;
use App\Http\Requests\MailRequest;
use App\Models\Course;

class AdminController extends Controller
{
    public function showAdminMyPage()
    {

        return view('admin.admin-mypage');
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

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeOwner(RegisterRequest $request)
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

    public function showAdminDetailPage($shop_id)
    {
        $shop = Shop::with('category', 'area', 'owner')->find($shop_id);
        $courses = Course::where('shop_id', $shop_id)->get();

        return view('admin.admin-detail', compact('shop', 'courses'));
    }
}
