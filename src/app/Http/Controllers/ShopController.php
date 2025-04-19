<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Course;
use App\Models\Area;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;


class ShopController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        $shops = Shop::with('category', 'area')->paginate(8);

        return view('index', compact('shops'));
    }

    public function search(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $query = Shop::query();

        $query = $this->getSearchQuery($request, $query);

        $shops = $query->paginate(8);
        return view('index', compact('shops'));
    }

    private function getSearchQuery($request, $query)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return $query;
    }
}
