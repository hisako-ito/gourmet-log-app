<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('category', 'area')->paginate(8);

        return view('index', compact('shops'));
    }

    public function search(Request $request)
    {
        $query = Shop::query();

        $query = $this->getSearchQuery($request, $query);

        $shops = $query->paginate(8);
        return view('index', compact('shops'));
    }

    private function getSearchQuery($request, $query)
    {
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


    public function detail($shop_id, Request $request)
    {
        $shop = Shop::with('category', 'area')->find($shop_id);
        return view('detail', compact('shop'));
    }

    public function test()
    {
        return view('test');
    }
}
