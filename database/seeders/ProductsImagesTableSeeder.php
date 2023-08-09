<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsImage;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsImagesRecords = [
            ['id'=>1, 'product_id'=>1, 'image'=>'red_casual_tshirt.jpg-25858.jpg', 'status'=>1]
        ];

        ProductsImage::insert($productsImagesRecords);
    }
}
