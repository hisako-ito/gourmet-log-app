<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class AdminController extends Controller
{
    public function index()
    {
        $shops = Shop::with('category', 'area')->paginate(8);

        return view('index', compact('shops'));
    }
}
