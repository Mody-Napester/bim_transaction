<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++){
            $str = Str::random('10');
            $resource = User::create([
                'name' => $str,
                'email' => $str . '@customer.com',
                'password' => Hash::make('123456789'),
                'user_type_id' => 2,
            ]);

            $str = Str::random('10');
            $resource = User::create([
                'name' => $str,
                'email' => $str . '@admin.com',
                'password' => Hash::make('123456789'),
                'user_type_id' => 1,
            ]);
        }
    }
}
