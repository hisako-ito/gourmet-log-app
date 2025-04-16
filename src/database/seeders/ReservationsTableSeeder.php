<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Reservation;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'shop_id' => 1,
            'user_id' => 1,
            'course_id' => 1,
            'date' => Carbon::now()->addDays(3)->toDateString(),
            'time' => '19:00:00',
            'number' => 2,
        ];
        Reservation::create($param);

        $param = [
            'shop_id' => 2,
            'user_id' => 2,
            'course_id' => 1,
            'date' => Carbon::now()->addDays(3)->toDateString(),
            'time' => '20:00:00',
            'number' => 3,
        ];
        Reservation::create($param);
    }
}
