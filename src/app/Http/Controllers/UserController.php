<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showMyPage()
    {
        $user = Auth::user();
        $reservations = Reservation::with('shop')
            ->where('user_id', $user->id)
            ->get();

        $shops = $user->likes()->get()->pluck('shop');

        return view('mypage', compact('user', 'reservations', 'shops'));
    }
}
