<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReturnRequest;

class ReturnRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $returnRequestRecords = [
            [
                'id'=>1,
                'order_id'=>3,
                'user_id'=>1,
                'product_id'=>2,
                'product_size'=>'Medium',
                'product_code'=>'RT001',
                'return_reason'=>'Item arrived too late',
                'return_status'=>'Pending',
                'comment'=>''
            ],
        ];

        ReturnRequest::insert($returnRequestRecords);
    }
}
