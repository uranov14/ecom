<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerRecords = [
            [
                'id'=>1,
                'image'=>'banner1.png',
                'link'=>'black-jacket',
                'title'=>'Black Jacket',
                'alt'=>'Black Jacket',
                'status'=>1,
            ],
            [
                'id'=>2,
                'image'=>'banner2.png',
                'link'=>'half-sleeve-tshirts',
                'title'=>'Half Sleeve T-Shirts',
                'alt'=>'Half Sleeve T-Shirts',
                'status'=>1,
            ],
            [
                'id'=>3,
                'image'=>'banner3.png',
                'link'=>'full-sleeve-tshirts',
                'title'=>'Full Sleeve T-Shirts',
                'alt'=>'Full Sleeve T-Shirts',
                'status'=>1,
            ]
        ];
        Banner::insert($bannerRecords);
    }
}
