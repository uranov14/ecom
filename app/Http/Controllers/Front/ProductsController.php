<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
use App\Models\Sms;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\ShippingCharge;
use App\Models\Currency;
use App\Models\Rating;
use App\Models\Wishlist;
use Session;
use Auth;
use DB;

class ProductsController extends Controller
{
    public function listing(Request $request) {
        Paginator::useBootstrap();
        if ($request->ajax()) {
            $data = $request->all();
            echo "<pre>"; print_r($data); die;

            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();

            if ($categoryCount > 0) {
                $categoryDetails = Category::categoryDetails($url);
                //echo "<pre>"; print_r($categoryDetails); die;
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                // If Fabric filter is selected
                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }
                // If Sleeve filter is selected
                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }
                // If Pattern filter is selected
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }
                // If Fit filter is selected
                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }
                // If Occasion filter is selected
                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }
    
                // If Sort option selected by User
                if (isset($data['sort']) && !empty($data['sort'])) {
                    switch ($data['sort']) {
                        case 'product_latest':
                            $categoryProducts->orderBy('id', 'Desc');
                            break;
                        case 'product_name_a_z':
                            $categoryProducts->orderBy('product_name', 'Asc');
                            break;
                        case 'product_name_z_a':
                            $categoryProducts->orderBy('product_name', 'Desc');
                            break;
                        case 'price_lowest':
                            $categoryProducts->orderBy('product_price', 'Asc');
                            break;
                        case 'price_highest':
                            $categoryProducts->orderBy('product_price', 'Desc');
                            break;
                        default:
                            $categoryProducts->orderBy('id', 'Desc');
                            break;
                    }
                }
    
                $categoryProducts = $categoryProducts->paginate(30);
                $meta_title = $categoryDetails['categoryDetails']['meta_title'];
                $meta_keywords = $categoryDetails['categoryDetails']['meta_keywords'];
                $meta_description = $categoryDetails['categoryDetails']['meta_description'];
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts', 'url', 'meta_title', 'meta_keywords', 'meta_description'));
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();

            if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
                $search_product = $_REQUEST['search'];
                $categoryDetails['breadcrumbs'] = $search_product;
                $categoryDetails['categoryDetails']['category_name'] = $search_product;
                $categoryDetails['categoryDetails']['description'] = "Search Results for ".$search_product;
                $categoryProducts = Product::with('brand')->where(function($query)use($search_product) {
                    $query->where('product_name', 'like', '%'.$search_product.'%')
                    ->orWhere('product_code', 'like', '%'.$search_product.'%')
                    ->orWhere('product_color', 'like', '%'.$search_product.'%')
                    ->orWhere('description', 'like', '%'.$search_product.'%');
                })->where('status', 1);
                $categoryProducts = $categoryProducts->get();

                $page_name = "Search Results";
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'page_name'));

            } else if ($categoryCount > 0) {
                $categoryDetails = Category::categoryDetails($url);
                //dd($categoryDetails);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                
                //Product Filters
                $productFilters = Product::productFilters();
                //dd($productFilters);
                $categoryProducts = $categoryProducts->paginate(30);
                $page_name = "listing";
                $meta_title = $categoryDetails['categoryDetails']['meta_title'];
                $meta_keywords = $categoryDetails['categoryDetails']['meta_keywords'];
                $meta_description = $categoryDetails['categoryDetails']['meta_description'];
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url', 'productFilters', 'page_name', 'meta_title', 'meta_keywords', 'meta_description'));
            } else {
                abort(404);
            }
        }
        
    }

    public function detail($id) {
        $productDetails = Product::with(['category', 'brand', 'attributes'=>function($query) {
            $query->where('status', 1); 
        }, 'images'])->find($id)->toArray();
        //dd($productDetails); die;
        
        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');
        $relatedProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->limit(3)->inRandomOrder()->get()->toArray();
        //dd($relatedProducts); die;
        $groupProducts = array();
        if (!empty($productDetails['group_code'])) {
            $groupProducts = Product::select('id', 'main_image')->where('id', '!=', $id)->where(['group_code'=>$productDetails['group_code'], 'status'=>1])->get()->toArray();
        }

        $currencies = Currency::select('currency_code', 'exchange_rate')->where('status', 1)->get()->toArray();

        // Get all ratings of product
        $ratings = Rating::with('user')->where(['product_id'=>$id, 'status'=>1])->orderBy('id', 'Desc')->get()->toArray();

        // Get Average Rating of product
        $ratingSum = Rating::where(['product_id'=> $id, 'status'=>1])->sum('rating');
        $ratingCount = count($ratings);
        if ($ratingCount > 0) {
            $averageRating = round($ratingSum / $ratingCount, 2);
            $avgStarRating = round($ratingSum / $ratingCount);
        } else {
            $averageRating = 0;
            $avgStarRating = 0;
        }
        //dd($ratingCount);
        $meta_title = $productDetails['product_name'];
        $meta_keywords = $productDetails['product_name'];
        $meta_description = $productDetails['description'];
        return view('front.products.detail')->with(compact('productDetails', 'total_stock', 'relatedProducts', 'groupProducts', 'meta_title', 'meta_keywords', 'meta_description', 'currencies', 'ratings', 'averageRating', 'avgStarRating'));
    }

    public function getProductPrice(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            
            $discountedAttrPrice = Product::getDiscountedAttrPrice($data['product_id'], $data['size']);

            $currencies = Currency::select('currency_code', 'exchange_rate')->where('status', 1)->get()->toArray();

            $discountedAttrPrice['currency'] = "<small style='font-size: 13px; color: #333; position: relative; top: -10px;'>";

            foreach ($currencies as $currency) {
                $discountedAttrPrice['currency'] .= '<br>';
                $discountedAttrPrice['currency'] .= $currency['currency_code']." - ";
                $discountedAttrPrice['currency'] .= round($discountedAttrPrice['final_price'] / $currency['exchange_rate'], 2);
            }
            $discountedAttrPrice['currency'] .= "</small>";

            return $discountedAttrPrice;
        }
    }

    public function addToCart(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if (empty($data['size'])) {
                $message = "Please select size!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            if ($data['quantity'] <= 0 || empty($data['quantity'])) {
                $data['quantity'] = 1;
            }

            //Check Product Stock is available or not
            $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'], 'size'=>$data['size']])->first()->toArray();

            if ($getProductStock['stock'] < $data['quantity']) {
                $message = "Required Quantity is not available!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            //Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            //Check Product if already exists in the User Cart
            if (Auth::check()) {
                //User is Logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'user_id'=>$user_id])->count();
            } else {
                //User is not Logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id'=>$session_id])->count();
            }

            if ($countProducts > 0) {
                $message = "Product already exists in Cart!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            //Save Product in cart table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            $message = 'Product has been added in Cart!';
            Session::flash('success_message', $message);
            return redirect('cart');
        }
    }

    public function cart() {
        Session::forget('couponCode');
        Session::forget('couponAmount');
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);
        $meta_title = "Shopping Cart Multi Vendor E-commerce Website";
        $meta_keywords = "shoping cart, multi vendor, e-commerce, selling ukrainian clothes online, sell ukrainian clothes, sell ukrainian dresses online, how to sell ukrainian clothes online";
        $meta_description = "View Shopping Cart of Multi Vendor E-commerce Website";
        return view('front.products.cart')->with(compact('getCartItems', 'meta_title', 'meta_keywords', 'meta_description'));
    }

    public function wishlist() {
        $userWishlist = Wishlist::userWishlist();
        //dd($getCartItems);
        $meta_title = "Wish List E-commerce Website";
        $meta_keywords = "wishlist, e-commerce";
        $meta_description = "View Wish List E-commerce Website";
        return view('front.products.wishlist')->with(compact('userWishlist', 'meta_title', 'meta_keywords', 'meta_description'));
    }

    public function updateCartItemQty(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //Get Cart Details
            $cartDetails = Cart::find($data['cartid']);

            //Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size']])->first()->toArray();
            //echo "<pre>"; print_r($data['qty']); 
            //echo "<pre>"; print_r($availableStock['stock']); die;

            //Check if product size is available
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size'], 'status'=>1])->count();
            if ($availableSize == 0) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false, 
                    'message'=>'Product Size is not available! Please remove this Product and choose another one!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);
            }

            //Check if desired Stock from user is available
            if ($data['qty'] > $availableStock['stock']) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false, 
                    'message'=>'Product Stock is not available!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);
            }

            //Update quantity in carts table
            Cart::where('id', $data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            
            /* $total_sum = 0;
            foreach ($getCartItems as $item) {
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
            $total_sum += $getDiscountAttributePrice['final_price'] * $item['quantity'];;
            } */

            $totalCartItems = totalCartItems();
            
            return response()->json([
                'status'=>true, 
                'totalCartItems'=>$totalCartItems,
                /* 'getCartItems'=>$getCartItems,
                'total_sum'=>round($total_sum, 2), */
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function deleteCartItem(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Delete cart
            Cart::where('id', $data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([ 
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function deleteWishlistItem(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Delete cart
            Wishlist::where('id', $data['wishlistid'])->delete();
            $userWishlist = Wishlist::userWishlist();
            $totalWishlistItems = totalWishlistItems();
            return response()->json([ 
                'totalWishlistItems'=>$totalWishlistItems,
                'view'=>(String)View::make('front.products.wishlist_items')->with(compact('userWishlist'))
            ]);
        }
    }

    public function applyCoupon(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die; 
            Session::forget('couponCode');
            Session::forget('couponAmount');
            
            $getCartItems = Cart::getCartItems();  
            //echo "<pre>"; print_r($getCartItems); die;        
            $totalCartItems = totalCartItems();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if ($couponCount == 0) {
                return response()->json([ 
                    'status'=>false,
                    'totalCartItems'=>$totalCartItems,
                    'message'=>'The coupon is not valid!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                ]);
            } else {
                //Check for other coupon conditions
                //Get Coupon Details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();
                //Check if Coupon is active and is expired
                if ($couponDetails->status == 0) {
                    $message = "The coupon is not active!";
                } else if ($couponDetails->expiry_date < date('Y-m-d')) {
                    //Check if Coupon is expired
                    $message = "The coupon is expired!";
                } 

                //Check if Coupon is for single time
                if ($couponDetails->coupon_type == "Single Time") {
                    //Check in orders table if coupon already availed by the user
                    $couponCount = Order::where(['coupon_code' => $data['code'], 'user_id' => Auth::user()->id])->count();
                    if ($couponCount >= 1) {
                        $message = "This coupon code already availed by you!";
                    }
                }

                //Get all selected categories from coupon and convert to array
                $catArr = explode(",", $couponDetails->categories);
                //echo "<pre>"; print_r($catArr); die;
                //Check if Coupon is from selected categories
                $total_amount = 0;
                foreach ($getCartItems as $key => $item) {
                    if (!in_array($item['product']['category_id'], $catArr)) {
                        $message = "This coupon code is not for one of the selected products!";
                    }
                    $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                    $total_amount += $attrPrice['final_price'] * $item['quantity'];
                }

                //Get all selected users from coupon and convert to array
                if (isset($couponDetails->users) && !empty($couponDetails->users)) {
                    $usersArr = explode(",", $couponDetails->users);

                    if (count($usersArr) > 0) {
                        //Get User Id's of all selected users
                        foreach ($usersArr as $key => $user) {
                            $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                            $usersId[] = $getUserId['id'];
                        }

                        //Check if any cart item not belong to Coupon user
                        foreach ($getCartItems as $item) {
                            if (!in_array($item['user_id'], $usersId)) {
                                $message = "This coupon code is not for you! Try with valid coupon code!";
                            }                       
                        }
                    }
                }
                    
                if (isset($message)) {
                    return response()->json([ 
                        'status'=>false,
                        'totalCartItems'=>$totalCartItems,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                    ]);
                } else {
                    //Coupon code is correct
                    //Check if Coupon Amount type is Fixed or Percentage
                    if ($couponDetails->amount_type == "Fixed") {
                        $couponAmount = $couponDetails->amount;
                    } else {
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }
                    
                    $grand_total = $total_amount - $couponAmount;

                    //Add Coupon Code & Amount in Session variables
                    Session::put('couponCode', $data['code']);
                    Session::put('couponAmount', $couponAmount);

                    $message = "Coupon Code successfully applied! You are availing discount!";

                    return response()->json([ 
                        'status'=>true,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>round($couponAmount, 2),
                        'grand_total'=>round($grand_total, 2),
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
                    ]);
                }
                
            }
        }
    }

    public function checkout(Request $request) {
        $countries = Country::where('status', 1)->get()->toArray();
        $getCartItems = Cart::getCartItems();
        //echo "<pre>"; print_r($getCartItems); die;
        if (count($getCartItems) == 0) {
            $message = "Shoping cart is empty. Please add products to checkout!";
            Session::flash('error_message', $message);
            return redirect('cart');
        }

        $total_price = 0;
        $total_weight = 0;
        $total_GST = 0;
        foreach ($getCartItems as $item) {
            $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
            $product_total_price = $attrPrice['final_price'] * $item['quantity'];
            $total_price += $product_total_price;

            // Calculate GST for Item
            $getGST = Product::select('product_gst')->where('id', $item['product_id'])->first();
            $gstPercent = $getGST->product_gst;
            $gstAmount = round($product_total_price / 100 * $gstPercent, 2);
            $total_GST += $gstAmount; 
            $product_weight = $item['product']['product_weight'] * $item['quantity'];
            $total_weight += $product_weight;
        }
        //dd($total_weight);

        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        
        foreach ($deliveryAddresses as $key => $address) {
            $rate = ShippingCharge::getShippingCharges($total_weight, $address['country']);
            $deliveryAddresses[$key]['shipping_charges'] = $rate;

            $deliveryAddresses[$key]['gst_charges'] = $total_GST;

            //COD Pincode is Available or Not
            $deliveryAddresses[$key]['codpincodeCount'] = DB::table('cod_pincodes')->where('pincode', $address['pincode'])->count();

            //Prepaid Pincode is Available or Not
            $deliveryAddresses[$key]['prepaidpincodeCount'] = DB::table('prepaid_pincodes')->where('pincode', $address['pincode'])->count();
        }
        //dd($deliveryAddresses);

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data['payment_gateway']); die;

            //Website Security Check
            foreach ($getCartItems as $item) {
                //Prevent Disabled Product to Order
                $product_status = Product::getProductStatus($item['product_id']);

                if ($product_status == 0) {
                    Session::forget('couponCode');
                    Session::forget('couponAmount');

                    Product::deleteCartProduct($item['product_id']);
                    $message = $item['product']['product_name']." is not available so removed from your Cart.";
                    return redirect('/cart')->with('error_message', $message);
                }

                //Prevent Sold Out Product to Order
                $getProductStock = ProductsAttribute::availableStock($item['product_id'], $item['size']);
                if ($getProductStock == 0) {
                    Session::forget('couponCode');
                    Session::forget('couponAmount');

                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "One of the Product is sold out! Please try again."; 
                    $message = $item['product']['product_name']." with ".$item['size']." Size is not avialable! Please remove from cart and choose other product.";
                    return redirect('/cart')->with('error_message', $message);
                }
                if ($getProductStock - $item['quantity'] < 0) {
                    Session::forget('couponCode');
                    Session::forget('couponAmount');

                    Product::deleteCartProduct($item['product_id']);
                    $message = "The quantity ordered is not in stock. Available quantity is: ".$getProductStock;
                    return redirect('/cart')->with('error_message', $message);
                }

                //Prevent Disabled Product Attribute to Order
                $getAttributeStatus = ProductsAttribute::getAttributeStatus($item['product_id'], $item['size']);

                if ($getAttributeStatus == 0) {
                    Session::forget('couponCode');
                    Session::forget('couponAmount');

                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "One of the Product Attribute is disabled! Please try again.";
                    $message = $item['product']['product_name']." with ".$item['size']." Size is disabled! Please remove from cart and choose other product.";
                    return redirect('/cart')->with('error_message', $message);
                }

                //Prevent Disabled Categories Products to Order
                $getCategoryStatus = Category::getCategoryStatus($item['product']['category_id']);

                if ($getCategoryStatus == 0) {
                    Session::forget('couponCode');
                    Session::forget('couponAmount');

                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "This is Category Products is disabled! Please select another product.";
                    $message = $item['product']['product_name']." with ".$item['size']." Size is not Available because this Category disabled. Please remove this product from Cart and choose some other product.";
                    return redirect('/cart')->with('error_message', $message);
                }
            }

            //Delivery Address Validation
            if (empty($data['address_id'])) {
                $message= "Please select Delivery Address!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            //Payment Method Validation
            if (empty($data['payment_gateway'])) {
                $message= "Please select Payment Method!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            //Get Delivery Address from address_id
            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();
            //dd($deliveryAddress);

            //Set Payment Method as COD if COD is selected from user otherwise set as Prepaid
            if ($data['payment_gateway'] == "COD") {
                $payment_method = "COD";
                $order_status = "New";
            } else {
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }

            DB::beginTransaction();
            
            //Fetch Order Total Price
            $total_price = 0;
            foreach ($getCartItems as $item) {
                $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                $total_price += $getDiscountedAttrPrice['final_price'] * $item['quantity'];
            }

            //Calculate Shipping Charges
            $shipping_charges = 0;

            //Get Shipping Charges
            $shipping_charges = ShippingCharge::getShippingCharges($total_weight, $deliveryAddress['country']);

            //Calculate Grand Total
            $grand_total = $total_price + $shipping_charges + $total_GST - Session::get('couponAmount');

            //Insert Grand Total in Session Variable
            Session::put('grand_total', $grand_total);

            //Insert Order Details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->gst_charges = $total_GST;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = $order_status;
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = $grand_total;
            $order->save();

            // Get last Order Id
            $order_id = DB::getPdo()->lastInsertId();
            //$order->id = $order_id;

            foreach ($getCartItems as $item) {
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code', 'product_name', 'product_color')->where('id', $item['product_id'])->first()->toArray();
                
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                $cartItem->product_price = $getDiscountedAttrPrice['final_price'];

                $getProductStock = ProductsAttribute::availableStock($item['product_id'], $item['size']);

                if ($item['quantity'] > $getProductStock) {
                    $message = $getProductDetails['product_name']." with ".$item['size']." Size is not available. Please reduce its quantity and try again.";
                    Session::flash('error_message', $message);
                    return redirect('/cart');
                }
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();

                //Reduce Stock
                $newStock = $getProductStock - $item['quantity'];

                ProductsAttribute::where(['product_id'=>$item['product_id'], 'size'=>$item['size']])->update(['stock'=>$newStock]);
            }

            //Insert Order Id in Session Variable
            Session::put('order_id', $order_id);

            DB::commit();

            $orderDetails = Order::with('order_products')->where('id', $order_id)->first()->toArray();
            //echo "<pre>"; print_r($orderDetails); die;

            if ($data['payment_gateway'] == "COD") {

                //Send Order Email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('Order Placed - Your Shop!');
                });

                //Send Order SMS
                /* $message = "Dear Customer, your order ".$order_id."has been successfully placed! We will intimate you once your order is shipped.";
                $mobile = Auth::user()->mobile;

                Sms::sendSms($message, $mobile); */
                
            } else if ($data['payment_gateway'] == "PayPal") {

                //Redirect User to Paypal Page after saving order
                return redirect('paypal');
            } else if ($data['payment_gateway'] == "Iyzipay") {
                //Redirect User to Iyzipay Page after saving order
                return redirect('iyzipay');
            } else {
                echo "Other Prepaid Payment methods coming soon";
            }

            return redirect('thanks');
            //echo "Thanks! Order Placed.";
        }
        
        $meta_title = "Checkout Page E-commerce Website";
        return view('front.products.checkout')->with(compact('deliveryAddresses', 'countries', 'getCartItems', 'total_price', 'meta_title', 'total_GST'));
    }

    public function addEditDeliveryAddress(Request $request, $id=null) {
        if ($id == "") {
            $title = "Add Delivery Address";
            $address = new DeliveryAddress;
            $message = "Your Delivery Address has been added successfully!";
        } else {
            $title = "Edit Delivery Address";
            $address = DeliveryAddress::find($id);
            $message = "Your Delivery Address has been updeted successfully!";
        }

        $countries = Country::where('status', 1)->get()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'address' => 'required',
                'city' => 'required|regex:/^[\pL\s\-]+$/u',
                'state' => 'required|regex:/^[\pL\s\-]+$/u',
                'country' => 'required',
                'pincode' => 'required|numeric|min:5',
                'mobile' => 'required|numeric|digits:10',
            ];

            $customMessage =[
                'name.required' => 'Name is required',
                'name.regex' => 'Valid Name is required',
                'address.required' => 'Address is required',
                'city.required' => 'City is required',
                'city.regex' => 'Valid City is required',
                'state.required' => 'State is required',
                'state.regex' => 'Valid State is required',
                'country.required' => 'Country is required',
                'pincode.required' => 'Pincode is required',
                'pincode.numeric' => 'Valid Pincode is required',
                'pincode.min' => 'Pincode must be at least 5 digits',
                'mobile.required' => 'Mobile Number is required',
                'mobile.numeric' => 'Valid Mobile Number is required',
                'mobile.digits' => 'Valid Mobile Number must be 10 digits',
            ];

            $this->validate($request, $rules, $customMessage);

            //Update Delivery Address
            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->mobile = $data['mobile'];
            $address->address = $data['address'];
            $address->city = $data['city'];
            $address->state = $data['state'];
            $address->country = $data['country'];
            $address->pincode = $data['pincode'];
            $address->save();

            //Redirect back user with success message
            Session::flash('success_message', $message);
            
            return redirect('checkout');
        }
        return view('front.products.add_edit_delivery_address')->with(compact('title', 'countries', 'address'));
    }

    public function deleteDeliveryAddress($id) {
        DeliveryAddress::where('id', $id)->delete();
        $message = "Delivery Address has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function thanks() {
        if (Session::has('order_id')) {
            //Empty the Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            Session::forget('couponCode'); 
            Session::forget('couponAmount');
            return view('front.products.thanks');
        } else {
            return redirect('cart');
        }
    }

    public function checkPincode(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if (is_numeric($data['pincode']) && $data['pincode'] > 0 && $data['pincode'] == round($data['pincode'], 0)) {
                //COD Pincode is Available or Not
                $codPincodeCount = DB::table('cod_pincodes')->where('pincode', $data['pincode'])->count();

                //Prepaid Pincode is Available or Not
                $prepaidPincodeCount = DB::table('prepaid_pincodes')->where('pincode', $data['pincode'])->count(); 

                if ($codPincodeCount == 0 && $prepaidPincodeCount == 0) {
                    echo "This pincode is not available for Delivery."; die;
                } else {
                    echo "This pincode is available for Delivery."; die;
                }
            } else {
                echo "Please enter valid pincode."; die;
            }
        }
    }

    public function updateWishlist(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $countWishlist = Wishlist::countWishlist($data['product_id']);
            if ($countWishlist == 0) {
                // Add Product in Wishlist
                $wishlist = new Wishlist;
                $wishlist->user_id = Auth::user()->id;
                $wishlist->product_id = $data['product_id'];
                $wishlist->save();

                return response()->json(['status'=>true]);
            } else {
                Wishlist::where(['user_id'=>Auth::user()->id, 'product_id'=>$data['product_id']])->delete();

                return response()->json(['status'=>false]);
            }
        }
    }

}
