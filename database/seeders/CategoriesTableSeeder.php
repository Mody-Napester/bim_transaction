<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Books', 'sub' => [
                ['name' => 'Sub Book 1'],
                ['name' => 'Sub Book 2'],
                ['name' => 'Sub Book 3']
            ]],
            ['name' => 'Candies', 'sub' => [
                ['name' => 'Sub Candies 1'],
                ['name' => 'Sub Candies 2'],
                ['name' => 'Sub Candies 3']
            ]]
        ];

        foreach ($data as $row){
            $resource = Category::create(['name' => $row['name']]);

            // Create Sub Categories
            foreach ($row['sub'] as $sub){
                SubCategory::create([
                    'category_id' => $resource->id,
                    'name' => $sub['name']
                ]);
            }
        }
    }
}
