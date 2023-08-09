<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencyRecords = [
            [
                'id'=>1,
                'currency_code'=>'USD',
                'exchange_rate'=>37.07,
                'status'=>1
            ],
            [
                'id'=>2,
                'currency_code'=>'GBR',
                'exchange_rate'=>46.96,
                'status'=>1
            ],
            [
                'id'=>3,
                'currency_code'=>'EUR',
                'exchange_rate'=>40.50,
                'status'=>1
            ],
            [
                'id'=>4,
                'currency_code'=>'AUD',
                'exchange_rate'=>24.18,
                'status'=>1
            ],
            [
                'id'=>5,
                'currency_code'=>'CAD',
                'exchange_rate'=>27.71,
                'status'=>1
            ]
        ];

        Currency::insert($currencyRecords);
    }
}
