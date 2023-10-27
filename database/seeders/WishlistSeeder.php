<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wishlist;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wishlistsRecords = [
            ['id'=>1, 'user_id'=>2, 'product_id'=>1],
            ['id'=>2, 'user_id'=>2, 'product_id'=>2],
            ['id'=>3, 'user_id'=>1, 'product_id'=>1]
        ];

        Wishlist::insert($wishlistsRecords);
    }
}
