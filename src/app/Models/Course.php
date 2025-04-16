<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'price',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
