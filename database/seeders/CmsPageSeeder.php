<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CmsPage;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsPageRecords = [
            [
                'id'=>1,
                'title'=>'About Us',
                'description'=>'About Us Content is cooming soon.',
                'url'=>'about-us',
                'meta_title'=>'About Us',
                'meta_description'=>'Description',
                'meta_keywords'=>'about us',
                'status'=>1
            ],
            [
                'id'=>2,
                'title'=>'Privacy Policy',
                'description'=>'Privacy Policy Content is cooming soon.',
                'url'=>'privacy-policy',
                'meta_title'=>'Privacy Policy',
                'meta_description'=>'Description',
                'meta_keywords'=>'privacy policy',
                'status'=>1
            ]
        ];

        CmsPage::insert($cmsPageRecords);
    }
}
