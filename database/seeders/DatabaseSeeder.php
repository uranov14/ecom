<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(AdminTableSeeder::class);
        //$this->call(SectionsTableSeeder::class);
        //$this->call(CategoryTableSeeder::class);
        //$this->call(ProductsTableSeeder::class);
        //$this->call(ProductsAttributesTableSeeder::class);
        //$this->call(ProductsImagesTableSeeder::class);
        //$this->call(BrandsTableSeeder::class);
        //$this->call(BannersTableSeeder::class);
        //$this->call(CouponsTableSeeder::class);
        //$this->call(DeliveryAddressSeeder::class);
        //$this->call(OrderStatusSeeder::class);
        //$this->call(CmsPageSeeder::class);
        //$this->call(CurrencySeeder::class);
        $this->call(RatingSeeder::class);
    }
}
