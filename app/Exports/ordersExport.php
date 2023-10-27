<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;
use App\Models\OrdersProduct;

class ordersExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() {
        $orders = Order::select('id','user_id','name','address','city','state','country','mobile','email','order_status','payment_method','payment_gateway', 'grand_total')->orderBy('id', 'Desc')->get();
        foreach ($orders as $key => $order) {
            $orderItems = OrdersProduct::select('id', 'product_name', 'product_code', 'product_color', 'product_size', 'product_price', 'product_qty')->where('order_id', $order['id'])->get()->toArray();
            //echo "<pre>"; print_r($orderItems); die;
            $product_names = "";
            $product_codes = "";
            $product_colors = "";
            $product_sizes = "";
            $product_prices = "";
            $product_quantities = "";
            foreach ($orderItems as $item) {
                $product_names .= $item['product_name'].",";
                $product_codes .= $item['product_code'].",";
                $product_colors .= $item['product_color'].",";
                $product_sizes .= $item['product_size'].",";
                $product_prices .= $item['product_price'].",";
                $product_quantities .= $item['product_qty'].",";
            }
            $orders[$key]['product_names'] = $product_names;
            $orders[$key]['product_codes'] = $product_codes;
            $orders[$key]['product_colors'] = $product_colors;
            $orders[$key]['product_sizes'] = $product_sizes;
            $orders[$key]['product_prices'] = $product_prices;
            $orders[$key]['product_quantities'] = $product_quantities;
            //$orders = json_decode(json_encode($orders));
            //echo "<pre>"; print_r($orders); die;
        }
        return $orders;
    }

    public function headings():array {
        return ['Id','User Id', 'Name', 'Address', 'City', 'State', 'Country', 'Mobile', 'Email', 'Order Status', 'Payment Method', 'Payment Gateway', 'Grand Total', 'Product Names', 'Product Codes', 'Product Colors', 'Product Sizes', 'Product Prices', 'Product Quantities'];
    }
}
