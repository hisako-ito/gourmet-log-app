<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Shop;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $courses = [
            [
                'name' => '梅コース',
                'description' => '手軽に楽しめるカジュアルなコースです。',
                'price' => 3000,
            ],
            [
                'name' => '竹コース',
                'description' => '人気No.1の定番コースです。',
                'price' => 5000,
            ],
            [
                'name' => '松コース',
                'description' => '特別な日にもぴったりな贅沢コースです。',
                'price' => 7000,
            ],
        ];

        $shops = Shop::all();

        foreach ($shops as $shop) {
            foreach ($courses as $courseData) {
                Course::create([
                    'shop_id' => $shop->id,
                    'name' => $courseData['name'],
                    'description' => $courseData['description'],
                    'price' => $courseData['price'],
                ]);
            }
        }
    }
}
