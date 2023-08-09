<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Product;

class IndexController extends Controller
{
    public function index() {
        //Get Featured Items
        $featuredItemsCount = Product::where(['is_featured'=>"Yes", 'status'=>1])->count();
        $featuredItems = Product::where(['is_featured'=>"Yes", 'status'=>1])->get()->toArray();
        //Get New Items
        $newItems = Product::orderBy('id', 'Desc')->limit(6)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);
        $page_name = "index";
        $meta_title = "E-shop Ukrainian Sector";
        $meta_keywords = "selling ukrainian clothes online, sell ukrainian clothes, sell ukrainian dresses online, how to sell ukrainian clothes online";
        $meta_description = "Sell Ukrainian Clothes Online - Sell ladies dresses online on Ukrainian Sector &amp; reach millions of buyers in Ukrain. Start selling Ukrainian clothes online for men, women &amp; kids.";
        return view('front.index')->with(compact('page_name', 'featuredItemsCount', 'featuredItemsChunk', 'newItems','meta_title', 'meta_keywords', 'meta_description'));
    }
}
