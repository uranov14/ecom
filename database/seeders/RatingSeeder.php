<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ratingRecords = [
            ['id'=>1, 'user_id'=>2, 'product_id'=>1, 'review'=>'Its really good', 'rating'=>4, 'status'=>0 ],
            ['id'=>2, 'user_id'=>2, 'product_id'=>2, 'review'=>'Fitting is really good and its the cotton product', 'rating'=>5, 'status'=>0 ],
            ['id'=>3, 'user_id'=>1, 'product_id'=>1, 'review'=>'Product is not good at all', 'rating'=>1, 'status'=>0 ]
        ];

        Rating::insert($ratingRecords);
    }
}
