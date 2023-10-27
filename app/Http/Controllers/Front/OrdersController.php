<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrdersLog;
use App\Models\OrdersProduct;
use App\Models\ReturnRequest;
use App\Models\ExchangeRequest;
use App\Models\ProductsAttribute;
use Auth;
use Session;

class OrdersController extends Controller
{
    public function orders() {
        $orders = Order::with('order_products')->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
        return view('front.orders.orders')->with(compact('orders'));
    }

    public function orderDetails($id) {
        $orderDetails = Order::with('order_products')->where('id', $id)->first()->toArray();
        //echo "<pre>"; print_r($orderDetails['order_products']); die;
        return view('front.orders.order_details')->with(compact('orderDetails'));
    }

    public function orderCancel(Request $request, $id) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // Get User ID from Auth
            $user_id_auth = Auth::user()->id;
            // Get User ID from Order
            $user_id_order = Order::select('user_id')->where('id', $id)->first();

            if ($user_id_auth == $user_id_order->user_id) {
                // Update Order Status to Cancelled
                Order::where('id', $id)->update(['order_status'=>'Cancelled']);
                // Update Order Log
                $log = new OrdersLog;
                $log->order_id = $id;
                $log->order_status = 'User Cancelled';
                $log->reason = $data['reason'];
                $log->updated_by = 'User';
                $log->save();

                $message = 'Order has been Cancelled';
                Session::flash('success_message', $message);

                return redirect()->back();
            } else {
                $message = 'Your Order Cancellation Request is not valid';
                Session::flash('error_message', $message);

                return redirect('orders');
            }
        }
    }

    public function orderReturn(Request $request, $id) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            // Get User ID from Auth
            $user_id_auth = Auth::user()->id;
            // Get User ID from Order
            $user_id_order = Order::select('user_id')->where('id', $id)->first();
            // Get Product Details
            $productArr = explode('-', $data['product_info']);
            $product_id = $productArr[0];
            $product_code = $productArr[1];
            $product_size = $productArr[2];

            if ($user_id_auth == $user_id_order->user_id) {
                if ($data['return_exchange'] == "Return") {
                    
                    // Update Item Order Status
                    OrdersProduct::where(['order_id'=>$id, 'product_code'=>$product_code, 'product_size'=>$product_size])->update(['item_status'=>'Return Initiated']);
                    // Add Return Request
                    $return = new ReturnRequest;
                    $return->order_id = $id;
                    $return->user_id = $user_id_auth;
                    $return->product_id = $product_id;
                    $return->product_size = $product_size;
                    $return->product_code = $product_code;
                    $return->return_reason = $data['reason'];
                    $return->return_status = 'Pending';
                    $return->comment = $data['comment'];
                    $return->save();

                    $message = 'Return Request has been placed for the Ordered Product';
                    Session::flash('success_message', $message);

                    return redirect()->back();

                } else if ($data['return_exchange'] == 'Exchange') {
                    
                    // Update Item Order Status
                    OrdersProduct::where(['order_id'=>$id, 'product_code'=>$product_code, 'product_size'=>$product_size])->update(['item_status'=>'Exchange Initiated']);
                    // Add Exchange Request
                    $exchange = new ExchangeRequest;
                    $exchange->order_id = $id;
                    $exchange->user_id = $user_id_auth;
                    $exchange->product_size = $product_size;
                    $exchange->required_size = $data['required_size'];
                    $exchange->product_code = $product_code;
                    $exchange->exchange_reason = $data['reason'];
                    $exchange->exchange_status = 'Pending';
                    $exchange->comment = $data['comment'];
                    $exchange->save();

                    $message = 'Exchange Request has been placed for the Ordered Product';
                    Session::flash('success_message', $message);

                    return redirect()->back();

                } else {
                    $message = 'Your Order Return/Exchange Request is not valid';
                    Session::flash('success_message', $message);
                    return redirect('orders');
                }
                
            } else {
                $message = 'Your Order Return/Exchange Request is not valid';
                Session::flash('error_message', $message);

                return redirect('orders');
            }
        }
    }

    public function getProductSizes(Request $request) {
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        $productArr = explode('-', $data['product_info']);
        $product_id = $productArr[0];
        $product_code = $productArr[1];
        $product_size = $productArr[2];

        $productSizes = ProductsAttribute::select('size')->where('product_id', $product_id)->where('size', '!=', $product_size)->where('stock', '>', 0)->get()->toArray();
        //echo "<pre>"; print_r($productSizes); die;
        $appendSizes = '<option value="">Select Required Size</option>';
        foreach ($productSizes as $size) {
            $appendSizes .= '<option value="'.$size['size'].'">'.$size['size'].'</option>';
        }

        return $appendSizes;
    }
}
