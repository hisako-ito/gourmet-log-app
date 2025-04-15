<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Area;
use App\Models\Reservation;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    public function ownerMyPageShow($shop_id = null)
    {
        $owner = Auth::guard('owner')->user();
        $shops = Shop::where('owner_id', $owner->id)->with('owner')->get();
        $categories = Category::all();
        if (!$shop_id && $shops->count()) {
            $shop_id = $shops->first()->id;
        }
        $reservations = Reservation::where('shop_id', $shop_id)
            ->orderBy('date', 'asc')
            ->get();

        $categories = Category::all();
        $areas = Area::all();

        return view('owner-mypage', compact('owner', 'shops', 'categories', 'reservations', 'shop_id', 'categories', 'areas'));
    }

    public function shopStore(StoreShopRequest $request)
    {
        $owner = Auth::guard('owner')->user();

        $shop = new Shop();
        $shop->owner_id = $owner->id;
        $shop->name = $request->name;
        $shop->description = $request->description;
        $shop->category_id = $request->category_id;
        $shop->area_id = $request->area_id;

        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();

        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('storage/shop_images'), $fileName);

        $shop->image = 'storage/shop_images/' . $fileName;

        $shop->save();


        return redirect()->route('owner.page')->with('message', '店舗を登録しました');
    }

    public function shopUpdate($shop_id, UpdateShopRequest $request)
    {
        $shop = Shop::find($shop_id);

        $imagePath = $shop->image;

        if ($request->hasFile('image')) {
            if ($shop->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $shop->image));
            };
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('storage/shop_images'), $fileName);

            $imagePath = 'storage/shop_images/' . $fileName;
        }

        $shop->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'area_id' => $request->area_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('shop.update', ['shop_id' => $shop_id])->with('message', '店舗情報を更新しました');
    }
}
