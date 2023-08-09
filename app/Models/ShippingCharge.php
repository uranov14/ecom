<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;

    public static function getShippingCharges($total_weight, $country) {
        $shippingDetails = ShippingCharge::where('country', $country)->first()->toArray();
        $rate = $shippingDetails['0_500g'];
        
        if ($total_weight <= 500) {
            $rate = $shippingDetails['0_500g'];
        } else if ($total_weight <= 1000) {
            $rate = $shippingDetails['501_1000g'];
        } else if ($total_weight <= 2000) {
            $rate = $shippingDetails['1001_2000g'];
        } else if ($total_weight <= 5000) {
            $rate = $shippingDetails['2001_5000g'];
        } else if ($total_weight > 5000) {
            $rate = $shippingDetails['above_5000g'];
        } else {
            $rate = 0;
        }      
       
        return $rate;
    }
}
