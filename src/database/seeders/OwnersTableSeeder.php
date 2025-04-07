<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Owner;

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '店舗代表者ユーザ1',
            'email' => 'owner1@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ2',
            'email' => 'owner2@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ3',
            'email' => 'owner3@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ4',
            'email' => 'owner4@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ5',
            'email' => 'owner5@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ6',
            'email' => 'owner6@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ7',
            'email' => 'owner7@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ8',
            'email' => 'owner8@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ9',
            'email' => 'owner9@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ10',
            'email' => 'owner10@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ11',
            'email' => 'owner11@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ12',
            'email' => 'owner12@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ13',
            'email' => 'owner13@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ14',
            'email' => 'owner14@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ15',
            'email' => 'owner15@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ16',
            'email' => 'owner16@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ17',
            'email' => 'owner17@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ18',
            'email' => 'owner18@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ19',
            'email' => 'owner19@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);

        $param = [
            'name' => '店舗代表者ユーザ20',
            'email' => 'owner20@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ];
        Owner::create($param);
    }
}
