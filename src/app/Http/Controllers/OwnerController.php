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
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OwnerController extends Controller
{
    public function showOwnerMyPage($shop_id = null)
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

        return view('owner.owner-mypage', compact('owner', 'shops', 'categories', 'reservations', 'shop_id', 'categories', 'areas'));
    }

    public function storeShop(StoreShopRequest $request)
    {
        $owner = Auth::guard('owner')->user();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();

            $path = $file->storeAs('shop_images', $fileName, 'public');
        }

        $shop = Shop::create([
            'owner_id' => $owner->id,
            'name' => $request->name,
            'image' => $path,
            'category_id' => $request->category_id,
            'area_id' => $request->area_id,
            'description' => $request->description,
        ]);

        if (!empty($request->courses)) {
            foreach ($request->courses as $course) {
                if (!isset($course['name'], $course['price']) || $course['name'] === '' || $course['price'] === '') {
                    continue;
                }

                Course::create([
                    'shop_id' => $shop->id,
                    'name' => $course['name'],
                    'price' => $course['price'],
                    'description' => $course['description'] ?? '',
                ]);
            }
        }

        return redirect()->route('owner.page')->with('message', '店舗を登録しました');
    }

    public function showOwnerDetailPage($shop_id)
    {
        $shop = Shop::with('category', 'area', 'owner')->find($shop_id);
        $owner = Auth::guard('owner')->user();
        $categories = Category::all();
        $areas = Area::all();
        $courses = Course::where('shop_id', $shop_id)->get();

        return view('owner.owner-detail', compact('shop', 'categories', 'areas', 'owner', 'courses'));
    }

    public function updateShop($shop_id, UpdateShopRequest $request)
    {
        $shop = Shop::find($shop_id);

        $imagePath = $shop->image;

        if ($request->hasFile('image')) {
            if ($shop->image) {
                Storage::disk('public')->delete($shop->image);
            }

            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();

            $path = $file->storeAs('shop_images', $fileName, 'public');

            $imagePath = $path;
        }

        $shop->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'area_id' => $request->area_id,
            'image' => $imagePath,
        ]);

        if ($request->has('courses')) {
            foreach ($request->courses as $courseData) {
                $course = Course::find($courseData['id']);

                if ($course && $course->shop_id == $shop->id) {
                    if (!empty($courseData['delete'])) {
                        $course->delete();
                    } else {
                        $course->update([
                            'name' => $courseData['name'],
                            'price' => $courseData['price'],
                            'description' => $courseData['description'],
                        ]);
                    }
                }
            }
        }

        if (!empty($request->new_courses) && is_array($request->new_courses)) {
            foreach ($request->new_courses as $newCourse) {
                if (empty($newCourse['name']) || $newCourse['price'] === null) {
                    continue;
                }

                Course::create([
                    'shop_id' => $shop->id,
                    'name' => $newCourse['name'],
                    'price' => $newCourse['price'],
                    'description' => $newCourse['description'] ?? '',
                ]);
            }
        }

        return redirect()->route('shop.update', ['shop_id' => $shop_id])->with('message', '店舗情報を更新しました');
    }
}
