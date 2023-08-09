<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\Brand;
use App\Models\AdminRole;
use Session;
use Image;
use Auth;

class ProductsController extends Controller
{
    public function products() {
        Session::put('page', 'products');
        $products = Product::with(['section'=>function($query) {
            $query->select('id', 'name');
        }, 'category'=>function($query) {
            $query->select('id', 'category_name');
        }])->get();

        //return response()->json(['products'=>$products]); die;

        // Set Admin/Sub-Admin Permissions for Products
        $moduleProductsCount = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'products'])->count();
        if (Auth::guard('admin')->user()->type == "superadmin") {
            $moduleProducts['view_access'] = 1;
            $moduleProducts['edit_access'] = 1;
            $moduleProducts['full_access'] = 1;
        } else if ($moduleProductsCount == 0) {
            $message = "This feature is restricted for you!";
            Session::flash('error_message', $message);
            return redirect('admin/dashboard');
        } else {
            $moduleProducts = AdminRole::where(['admin_id'=>Auth::guard('admin')->user()->id, 'module'=>'products'])->first()->toArray();
        }
        
        return view('admin.products.products')->with(compact('products', 'moduleProducts'));
    }

    public function updateProductStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update products table
            Product::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }
    }

    public function addEditProduct(Request $request, $id = null) {
        Session::put('page', 'products');
        if ($id == null) {
            $title = "Add Product";
            $product = new Product;
            $productdata = array();
            $message = "added successfully";
        } else {
            $title = "Edit Product";
            $productdata = Product::where('id', $id)->first();
            $productdata = json_decode(json_encode($productdata), true); 
            $product = Product::find($id);
            $message = "updated successfully";
        }
        
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/',
            ];

            $customMessage =[
                'category_id.required' => 'Category is required',
                'brand_id.required' => 'Brand is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',
            ];

            $this->validate($request, $rules, $customMessage);

            //Upload Product Image
            if($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    //Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    $image_name = $image_tmp->getClientOriginalName();
                    //Generate New Image Name
                    $imageName = $image_name.'.'.$extension;
                    
                    $largeImagePath = 'images/product_images/large/'.$imageName;
                    $mediumImagePath = 'images/product_images/medium/'.$imageName;
                    $smallImagePath = 'images/product_images/small/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath); // W:1000 H:1000
                    Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

                    $product->main_image = $imageName;
                }
            }
            
            //Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                
                if($video_tmp->isValid()){
                    
                    // Upload Video
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name.'-'.rand().'.'.$extension;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path, $videoName);
                    // Save Video in products table
                    $product->product_video = $videoName;
                }
            }

            //Save Product Details in products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->brand_id = $data['brand_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->group_code = $data['group_code'];
            $product->product_weight = $data['product_weight'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->meta_description = $data['meta_description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->occasion = $data['occasion'];
            $product->sleeve = $data['sleeve'];
            $product->pattern = $data['pattern'];
            $product->fit = $data['fit'];
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();
            
            Session::flash('success_message', "Product ".$data['product_name']." ".$message);

            return redirect('admin/products');
        }

        //Product Filters
        $productFilters = Product::productFilters();
        
        //Get All Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        //Get All Brands 
        $brands = Brand::where('status', 1)->get();
        $brands = json_decode(json_encode($brands), true);

        return view('admin.products.add_edit_product')->with(compact('title', 'product', 'productdata', 'productFilters', 'categories', 'brands'));
    }

    public function deleteProductImage($id) {
        $productImage = Product::select('main_image')->where('id', $id)->first();

        //Get Product Image Path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';
        //Delete Product Image from product_images folder if exists
        if (file_exists($small_image_path.$productImage->main_image)) {
            unlink($small_image_path.$productImage->main_image);
        }
        if (file_exists($medium_image_path.$productImage->main_image)) {
            unlink($medium_image_path.$productImage->main_image);
        }
        if (file_exists($large_image_path.$productImage->main_image)) {
            unlink($large_image_path.$productImage->main_image);
        }
        //Delete Product Image from products table
        Product::where('id', $id)->update(['main_image'=>'']);

        $message = 'Product Image has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteProductVideo($id) {
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        //Get Product Videoe Path
        $video_path = 'videos/product_videos/';
        //Delete Product Video from product_videos folder if exists
        if (file_exists($video_path.$productVideo->product_video)) {
            unlink($video_path.$productVideo->product_video);
        }
        //Delete Product Image from products table
        Product::where('id', $id)->update(['product_video'=>'']);

        $message = 'Product Video has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addAttributes(Request $request, $id) {
        Session::put('page', 'products');
        $productdata = Product::with('attributes')->select('id', 'product_name','product_code', 'product_color', 'product_price', 'main_image')->find($id);
        $title = "Product Attributes";
        $productdata = json_decode(json_encode($productdata), true);
        
        if ($request->isMethod('post')) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    //Check duplicate SKU
                    $skuCount = ProductsAttribute::where('sku', $value)->count();
                    if ($skuCount > 0) {
                        Session::flash('error_message', "SKU already exists! Please add another SKU!");
                        return redirect()->back();
                    }
                    //Check duplicate Size
                    $sizeCount = ProductsAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();
                    if ($sizeCount > 0) {
                        Session::flash('error_message', "Size already exists! Please add another Size!");
                        return redirect()->back();
                    }

                    //Save Attributes in products_attributes table
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }

            Session::flash('success_message', "Product Attributes has been added successfully!");
            return redirect()->back();
        }
        return view('admin.products.add_attributes')->with(compact('productdata', 'title'));
    }

    public function editAttributes(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attribute) {
                if (!empty($attribute)) {
                    ProductsAttribute::where('id', $data['attrId'][$key])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }

            Session::flash('success_message', "Product Attributes has been updated successfully!");
            return redirect()->back();
        }
    }

    public function updateAttributeStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update Products Attribute table
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function updateImageStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update Products Attribute table
            ProductsImage::where('id', $data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
        }
    }

    public function deleteAttribute($id) {
        //Delete Attribute
        ProductsAttribute::where('id', $id)->delete();

        $message = 'Product Attribute has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addImages(Request $request, $id) {
        Session::put('page', 'products');
        $productdata = Product::with('images')->select('id', 'product_name','product_code', 'product_color', 'product_price', 'main_image')->find($id);
        $title = "Product Images";
        $productdata = json_decode(json_encode($productdata), true);
        //echo "<pre>"; print_r($productdata); die;
        
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                //echo "<pre>"; print_r($images); die;
                foreach ($images as $key => $image) {
                    $productImage = new ProductsImage;
                    
                    //$originalName = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111, 99999).time().".".$extension;

                    $largeImagePath = 'images/product_images/large/'.$imageName;
                    $mediumImagePath = 'images/product_images/medium/'.$imageName;
                    $smallImagePath = 'images/product_images/small/'.$imageName;
                    //Upload the Image
                    Image::make($image)->save($largeImagePath); // W:1000 H:1000
                    Image::make($image)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image)->resize(250, 250)->save($smallImagePath);

                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();
                }
            }
            Session::flash('success_message', "Product Images has been added successfully!");
            return redirect()->back();
        }
        return view('admin.products.add_images')->with(compact('productdata', 'title'));
    }

    public function deleteImage($id) {
        $productImage = ProductsImage::select('image')->where('id', $id)->first();

        //Get Product Image Path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';
        //Delete Product Image from product_images folder if exists
        if (file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }
        if (file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }
        if (file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }
        //Delete Product Image from products_images table
        ProductsImage::where('id', $id)->delete();

        $message = 'Product Image has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteProduct($id) {
        //Delete Product from products table
        Product::where('id', $id)->delete();

        $message = 'Product has been deleted successfully!';
        Session::flash('success_message', $message);
        return redirect()->back();
    }
}
