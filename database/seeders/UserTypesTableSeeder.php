<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            'name' => 'Admin',
            'permissions' => "index.category,show.category,create.category,index.transaction,show.transaction,create.transaction,index.payment,create.payment,generate.report",
        ]);

        DB::table('user_types')->insert([
            'name' => 'Customer',
            'permissions' => "index.transaction",
        ]);
    }
}
