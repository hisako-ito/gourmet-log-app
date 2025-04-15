<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showMyPage()
    {
        $user = Auth::user();
        $reservations = Reservation::with('shop')
            ->where('user_id', $user->id)
            ->orderBy('date', 'asc')
            ->get();

        $shops = $user->likes()->get()->pluck('shop');

        return view('mypage', compact('user', 'reservations', 'shops'));
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
            'number' => $request->input("number.{$reservation->id}"),
        ]);

        return redirect()->route('mypage')->with('message', "{$reservation->shop->name}の予約内容を変更しました");
    }
}
