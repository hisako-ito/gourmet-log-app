<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function detail(Request $request)
    {
        return view('detail');
    }
}
