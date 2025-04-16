<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Shop;
use App\Models\Course;
use Stripe\Stripe;
use Illuminate\Support\Str;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;

class UserController extends Controller
{
    public function detail($shop_id)
    {
        $shop = Shop::with('category', 'area', 'owner')->find($shop_id);
        $courses = Course::where('shop_id', $shop_id)->get();

        return view('detail', compact('shop', 'courses'));
    }

    public function store(ReservationRequest $request)
    {
        $qrToken = Str::uuid();

        $reservation = Reservation::create([
            'shop_id' => $request->id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'course_id' => $request->course_id,
            'number' => $request->number,
            'qr_token' => $qrToken,
        ]);

        Mail::to(Auth::user()->email)->send(new ReservationConfirmed($reservation));

        return redirect()->route('done')->withInput();
    }

    public function done()
    {
        return view('done');
    }

    public function showMyPage()
    {
        $user = Auth::user();
        $reservations = Reservation::with('shop', 'course')
            ->where('user_id', $user->id)
            ->orderBy('date', 'asc')
            ->get();

        $shops = $user->likes()->get()->pluck('shop');

        $coursesByShop = Course::all()->groupBy('shop_id');

        return view('mypage', compact('user', 'reservations', 'shops', 'coursesByShop'));
    }

    public function destroy($reservation_id)
    {
        Reservation::find($reservation_id)->delete();
        return redirect()->route('mypage')->with('message', '予約を削除しました');
    }

    public function update($reservation_id, Request $request)
    {
        $reservation = Reservation::with('shop')->find($reservation_id);
        $validator = Validator::make($request->all(), [
            "date.{$reservation->id}" => 'after_or_equal:' . now()->addDay()->format('Y-m-d'),
        ], [
            "date.{$reservation->id}.after_or_equal" => '明日以降の日付を入力してください',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator, 'edit_' . $reservation->id)
                ->withInput();
        }

        $reservation->update([
            'date' => $request->input("date.{$reservation->id}"),
            'time' => $request->input("time.{$reservation->id}"),
            'course_id' => $request->input("course_id.{$reservation->id}"),
            'number' => $request->input("number.{$reservation->id}"),
        ]);

        return redirect()->route('mypage')->with('message', "{$reservation->shop->name}の予約内容を変更しました");
    }

    public function checkout($reservation_id)
    {
        $reservation = Reservation::with('shop', 'course')->findOrFail($reservation_id);

        if ($reservation->user_id !== auth()->id()) {
            abort(403, '不正なアクセスです');
        }

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => '予約：' . $reservation->shop->name . '(' . $reservation->course->name . ')',
                    ],
                    'unit_amount' => $reservation->course->price,
                ],
                'quantity' => $reservation->number,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['reservation_id' => $reservation->id]),
            'cancel_url' => route('mypage'),
        ]);

        return redirect($session->url);
    }

    public function success($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $reservation->update(['is_paid' => true]);

        return view('checkout.success')->with('message', '決済が完了しました！');
    }

    public function verify($token)
    {
        $reservation = Reservation::where('qr_token', $token)->firstOrFail();
        return view('reservation.verify', compact('reservation'));
    }
}
