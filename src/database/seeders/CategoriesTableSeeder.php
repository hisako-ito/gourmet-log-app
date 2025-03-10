<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = [
            "寿司",
            "焼肉",
            "居酒屋",
            "イタリアン",
            "ラーメン"
        ];

        foreach ($contents as $content) {
            DB::table('categories')->insert([
                'content' => $content,
            ]);
        }
    }
}
