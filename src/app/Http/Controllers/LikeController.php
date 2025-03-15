<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function create($shop_id, Request $request)
    {
        Like::create([
            'user_id' => Auth::id(),
            'shop_id' => $shop_id
        ]);
        return back();
    }

    public function destroy($shop_id, Request $request)
    {
        Like::where(['user_id' => Auth::id(), 'shop_id' => $shop_id])->delete();
        return back();
    }
}
