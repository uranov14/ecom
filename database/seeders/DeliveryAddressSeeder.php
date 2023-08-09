<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryRecords = [
            [
                'id'=>1,
                'user_id'=>1,
                'name'=>'Ivan',
                'address'=>'test1',
                'city'=>'Moscow',
                'state'=>'Center',
                'country'=>'Russia',
                'pincode'=>'23456',
                'mobile'=>'0987654321',
                'status'=>1
            ],
            [
                'id'=>2,
                'user_id'=>1,
                'name'=>'Adam',
                'address'=>'test2',
                'city'=>'New York',
                'state'=>'Alabama',
                'country'=>'USA',
                'pincode'=>'AN1234',
                'mobile'=>'1234567890',
                'status'=>1
            ],
        ];

        DeliveryAddress::insert($deliveryRecords);
    }
}
