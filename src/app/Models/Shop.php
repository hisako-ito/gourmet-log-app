<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'image',
        'description',
        'area_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function liked()
    {
        return Like::where(['shop_id' => $this->id, 'user_id' => Auth::id()])->exists();
    }

    public function likeCount()
    {
        return Like::where('shop_id', $this->id)->count();
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function canUserReview($userId)
    {
        return $this->reservations()
            ->where('user_id', $userId)
            ->whereDate('date', '<=', now()->toDateString())
            ->where('is_reviewed', false)
            ->exists();
    }
}
