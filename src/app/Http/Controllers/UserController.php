<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;

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

    public function update(ReservationRequest $request)
    {
        $reservation = Reservation::find($request->id);
        $reservation->update([
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);

        return redirect()->route('mypage')->with('message', '予約内容を変更しました');
    }
}
