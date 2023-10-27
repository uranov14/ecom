<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribersRecords = [
            [
                'id'=>1,
                'email'=>'subscriber1@yopmail.com',
                'status'=>1
            ],
            [
                'id'=>2,
                'email'=>'subscriber2@yopmail.com',
                'status'=>1
            ],
            [
                'id'=>3,
                'email'=>'subscriber3@yopmail.com',
                'status'=>1
            ],
        ];

        NewsletterSubscriber::insert($subscribersRecords);
    }
}
