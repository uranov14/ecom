<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Wishlist extends Model
{
    use HasFactory;

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id')->select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'main_image');
    }

    public static function countWishlist($product_id) {
        if (Auth::check()) {
            $countWishlist = Wishlist::where(['user_id'=>Auth::user()->id, 'product_id'=>$product_id])->count();
        } else {
            $countWishlist = 0;
        }
        return $countWishlist;
    }

    public static function userWishlist() {
        if (Auth::check()) {
            $userWishlist = Wishlist::with('product')->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
        } else {
            $userWishlist = 0;
        }
        return $userWishlist;
    }
}
