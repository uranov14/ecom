<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExchangeRequest;

class ExchangeRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exchangeRequestRecords = [
            [
                'id'=>1,
                'order_id'=>3,
                'user_id'=>1,
                'product_size'=>'Medium',
                'required_size'=>'Large',
                'product_code'=>'RT001',
                'exchange_reason'=>'Require Larger Size',
                'exchange_status'=>'Pending',
                'comment'=>''
            ],
        ];

        ExchangeRequest::insert($exchangeRequestRecords);
    }
}
