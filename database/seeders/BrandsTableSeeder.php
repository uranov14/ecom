<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandRecords = [
            ['id'=>1, 'name'=>'Arrow', 'status'=>1],
            ['id'=>2, 'name'=>'Champion', 'status'=>1],
            ['id'=>3, 'name'=>'PUMA', 'status'=>1],
            ['id'=>4, 'name'=>'Adidas', 'status'=>1],
            ['id'=>5, 'name'=>'Columbia', 'status'=>1 ],
            ['id'=>6, 'name'=>'Calvin Klein', 'status'=>1],
            ['id'=>7, 'name'=>'Nike', 'status'=>1],
        ];

        Brand::insert($brandRecords);
    }
}
