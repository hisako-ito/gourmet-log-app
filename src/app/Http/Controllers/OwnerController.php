<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Owner;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function showOwnerMyPage()
    {
        $owner = Auth::guard('owner')->user();
        $shop = Shop::where('owner_id', $owner->id)->with('owner')->first();
        $categories = Category::all();
        $reservations = Reservation::where('shop_id', $shop->id)->with('shop')->get();

        return view('owner-mypage', compact('owner', 'shop', 'categories', 'reservations'));
    }
}
