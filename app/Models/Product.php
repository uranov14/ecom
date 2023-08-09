<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function section() {
        return $this->belongsTo('App\Models\Section', 'section_id')->select('id', 'name');
    }

    public function brand() {
        return $this->belongsTo('App\Models\Brand', 'brand_id')->select('id', 'name');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function attributes() {
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductsImage');
    }

    public static function productFilters() {
        //Product Filters
        $productFilters['fabricArray'] = ['Cottton', 'Polyester', 'Wool'];
        $productFilters['sleeveArray'] = ['Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless'];
        $productFilters['patternArray'] = ['Checked', 'Plain', 'Printed', 'Self', 'Solid'];
        $productFilters['fitArray'] = ['Regular', 'Slim'];
        $productFilters['occasionArray'] = ['Casual', 'Formal'];

        return $productFilters;
    }

    public static function getDiscountedPrice($product_id) {
        //dd($product_id);
        $productDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first()->toArray();
        
        $categoryDiscount = Category::select('category_discount')->where('id', $productDetails['category_id'])->first()->toArray();

        if ($productDetails['product_discount'] > 0) {
            $discountedPrice = $productDetails['product_price'] - $productDetails['product_price'] / 100 * $productDetails['product_discount']; 
        } else if($categoryDiscount['category_discount'] > 0) {
            $discountedPrice = $productDetails['product_price'] - $productDetails['product_price'] / 100 * $categoryDiscount['category_discount'];
        } else {
            $discountedPrice = $productDetails['product_price'];
        }
        return $discountedPrice;
    }

    public static function getDiscountedAttrPrice($product_id, $size) {
        $productPrice = ProductsAttribute::where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();

        $productDetails = Product::select('product_discount', 'category_id')->where('id', $product_id)->first()->toArray();

        $categoryDiscount = Category::select('category_discount')->where('id', $productDetails['category_id'])->first()->toArray();

        if ($productDetails['product_discount'] > 0) {
            $finalPrice = $productPrice['price'] - $productPrice['price'] / 100 * $productDetails['product_discount']; 
            $discount = $productPrice['price'] - $finalPrice;
        } else if($categoryDiscount['category_discount'] > 0) {
            $finalPrice = $productPrice['price'] - $productPrice['price'] / 100 * $categoryDiscount['category_discount'];
            $discount = $productPrice['price'] - $finalPrice;
        } else {
            $finalPrice = $productPrice['price'];
            $discount = 0;
        }

        return array('product_price'=>$productPrice['price'], 'final_price'=>$finalPrice, 'discount'=>$discount);
    }

    public static function getProductImage($product_id) {
        $getProductImage = Product::select('main_image')->where('id', $product_id)->first()->toArray();
        return $getProductImage['main_image'];
    }

    public static function getProductStatus($product_id) {
        $getProductStatus = Product::select('status')->where('id', $product_id)->first();
        return $getProductStatus->status;
    }

    public static function deleteCartProduct($product_id) {
        Cart::where('product_id', $product_id)->delete();
    }
}
