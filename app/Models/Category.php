<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function subcategories() {
        return $this->hasMany('App\Models\Category', 'parent_id')->where('status', 1);
    }

    public function section() {
        return $this->belongsTo('App\Models\Section', 'section_id')->select('id', 'name');
    }
    
    public function parentcategory() {
        return $this->belongsTo('App\Models\Category', 'parent_id')->select('id', 'category_name');
    }

    public static function categoryDetails($url) {
        $categoryDetails = Category::select('id','parent_id', 'category_name', 'category_image', 'url', 'description', 'meta_title', 'meta_keywords', 'meta_description')->with(['subcategories'=>
        function($query) {
            $query->select('id','parent_id', 'category_name', 'url', 'description')->where('status', 1); 
        }])->where('url', $url)->first()->toArray();
        
        $categoryIds[] = $categoryDetails['id'];

        if ($categoryDetails['parent_id'] == 0) {
            //Show only Main Category in Breadcrumb
            $breadcrumbs = '<li class="is-marked">
                    <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>
                </li>';
        } else {
            //Show Main and Sub Category in Breadcrumb
            $parentCategory = Category::select('category_name', 'url')->where('id', $categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>&nbsp;&nbsp;<span class="divider">/</span>&nbsp;<a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }

        foreach ($categoryDetails['subcategories'] as $key => $subcat) {
            $categoryIds[] = $subcat['id'];
        }
        //dd($categoryIds);
        $resp = ['catIds'=>$categoryIds, 'categoryDetails'=>$categoryDetails, 'breadcrumbs'=>$breadcrumbs];

        return $resp;
    }

    public static function getCategoryStatus($category_id) {
        $getCategoryStatus = Category::select('status')->where('id', $category_id)->first();
        return $getCategoryStatus->status;
    }
}
