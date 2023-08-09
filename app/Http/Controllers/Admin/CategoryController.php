<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use App\Models\AdminRole;
use Session;
use Image;
use Auth;

class CategoryController extends Controller
{
    public function categories() {
        Session::put('page', "categories");
        $categories = Category::with('section', "parentcategory")->get();
        // Set Admin/Sub-Admin Permissions for Categories
        $moduleCategoriesCount = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'categories'])->count();
        if (Auth::guard('admin')->user()->type == "superadmin") {
            $moduleCategories['view_access'] = 1;
            $moduleCategories['edit_access'] = 1;
            $moduleCategories['full_access'] = 1;
        } else if ($moduleCategoriesCount == 0) {
            $message = "This feature is restricted for you!";
            Session::flash('error_message', $message);
            return redirect('admin/dashboard');
        } else {
            $moduleCategories = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'categories'])->first()->toArray();
        }
        
        return view('admin.categories.categories')->with(compact('categories', 'moduleCategories'));
    }

    public function updateCategoryStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update sections table
            Category::where('id', $data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null) {
        Session::put('page', 'categories');
        if ($id == null) {
            $title = "Add Category";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "added successfully";
        } else {
            $title = "Edit Category";
            $categorydata = Category::where('id', $id)->first();
            $categorydata = json_decode(json_encode($categorydata), true);
            //echo "<pre>"; print_r($categorydata); die;
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0, 'section_id'=>$categorydata['section_id']])->get();
            $getCategories = json_decode(json_encode($getCategories), true);
            $category = Category::find($id);
            $message = "updated successfully";
        }
        
        //Get All Sections
        $getSections = Section::get();

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'category_image' => 'image',
                'url' => 'required',
            ];

            $customMessage =[
                'category_name.required' => 'Category Name is required',
                'category_name.regex' => 'Valid Category Name is required',
                'section_id.required' => 'Section is required',
                'category_image.image' => 'Valid Image is required',
                'url.required' => 'Category URL is required',
            ];

            $this->validate($request, $rules, $customMessage);
            
            //Upload Category Image
            if($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    //Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName= rand(111, 99999).'.'.$extension;
                    
                    $imagePath = 'images/category_images/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->save($imagePath);

                    $category->category_image = $imageName;
                }
            }else {
                $category->category_image = '';
            }

            if (empty($data['category_discount'])) {
                $data['category_discount'] = 0;
            }
            if (empty($data['description'])) {
                $data['description'] = "";
            }
            if (empty($data['meta_title'])) {
                $data['meta_title'] = "";
            }
            if (empty($data['meta_description'])) {
                $data['meta_description'] = "";
            }
            if (empty($data['meta_keywords'])) {
                $data['meta_keywords'] = "";
            }

            //$sectionId = Section::where('name', $data['section_id'])->select('id')->get()->first();
            //echo "<pre>"; print_r($sectionId['id']); die;
            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            
            $category->save();
            
            Session::flash('success_message', "Category ".$data['category_name']." ".$message);
            return redirect('admin/categories');
        }
        //echo "<pre>"; print_r($getCategories); die;

        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'getSections', 'categorydata', 'getCategories'));
    }

    public function appendCategoryLevel(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0, 'section_id'=>$data['section_id'], 'status'=>1])->get();
            $getCategories = json_decode(json_encode($getCategories), true);
            //echo "<pre>"; print_r($getCategories); die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategoryImage($id) {
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        //Get Category Image Path
        $image_path = 'images/category_images/';
        //Delete Category Image from category_images folder if exists
        if (file_exists($image_path.$categoryImage->category_image)) {
            unlink($image_path.$categoryImage->category_image);
        }
        //Delete Category Image from categories table
        Category::where('id', $id)->update(['category_image'=>'']);

        $message = 'Category Image has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteCategory($id) {
        //Delete Category from categories table
        Category::where('id', $id)->delete();

        $message = 'Category has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }
}
