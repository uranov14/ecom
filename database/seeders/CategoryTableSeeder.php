<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryRecords = [
            [
                'id'=>1,
                'parent_id'=>0,
                'section_id'=>1,
                'category_name'=>'T-Shirts',
                'category_image'=>'',
                'category_discount'=>0,
                'description'=>'',
                'url'=>'t-shirts',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'status'=>1
            ],
            [
                'id'=>2,
                'parent_id'=>1,
                'section_id'=>1,
                'category_name'=>'Casual T-Shirts',
                'category_image'=>'',
                'category_discount'=>0,
                'description'=>'',
                'url'=>'casual-t-shirts',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'status'=>1
            ],
            [
                'id'=>3,
                'parent_id'=>1,
                'section_id'=>1,
                'category_name'=>'Formal T-Shirts',
                'category_image'=>'',
                'category_discount'=>0,
                'description'=>'',
                'url'=>'formal-t-shirts',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'status'=>1
            ],
            
        ];

        Category::insert($categoryRecords);
    }
}
