<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productRecords = [
            [
                'id'=>1,
                'category_id'=>4,
                'section_id'=>1,
                'product_name'=>'Green Casual T-Shirt',
                'product_code'=>'GT001',
                'product_color'=>'Green',
                'main_image'=>'',
                'description'=>'',
                'wash_care'=>'',
                'fabric'=>'',
                'pattern'=>'',
                'sleeve'=>'',
                'fit'=>'',
                'occasion'=>'',
                'product_price'=>1000,
                'product_discount'=>10,
                'product_weight'=>200,
                'product_video'=>'',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'is_featured'=>'Yes',
                'status'=>1
            ],
            [
                'id'=>2,
                'category_id'=>4,
                'section_id'=>1,
                'product_name'=>'Red Casual T-Shirt',
                'product_code'=>'RT001',
                'product_color'=>'Red',
                'main_image'=>'',
                'description'=>'',
                'wash_care'=>'',
                'fabric'=>'',
                'pattern'=>'',
                'sleeve'=>'',
                'fit'=>'',
                'occasion'=>'',
                'product_price'=>1200,
                'product_discount'=>0,
                'product_weight'=>240,
                'product_video'=>'',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'is_featured'=>'No',
                'status'=>1
            ],
        ];

        Product::insert($productRecords);
    }
}
