@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
  <li class="active"><a href="{{ url('/orders') }}">Orders</a></li>
  </ul>
  <h3>Order #{{ $orderDetails['id'] }} Details</h3>	
  <hr class="soft"/>
  <div class="row">
    <div class="span4">
      <table class="table table-striped table-bordered">
        <tr>
          <th colspan="2"><strong>Order Details</strong></th>
        </tr>
        <tr>
          <td>Order Date</td>
          <td>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->isoFormat('Do MMM YYYY')}}</td>
        </tr>
        <tr>
          <td>Order Status</td>
          <td>{{ $orderDetails['order_status'] }}</td>
        </tr>
        @if (!empty($orderDetails['courier_name']))
          <tr>
            <td>Courier Name</td>
            <td>{{ $orderDetails['courier_name'] }}</td>
          </tr>
          <tr>
            <td>Tracking Number</td>
            <td>{{ $orderDetails['tracking_number'] }}</td>
          </tr>
        @endif
        <tr>
          <td>Order Total</td>
          <td>{{ $orderDetails['grand_total'] }} $</td>
        </tr>
        <tr>
          <td>Shipping Charges</td>
          <td>{{ $orderDetails['shipping_charges'] }} $</td>
        </tr>
        <tr>
          <td>Coupon Code</td>
          <td>{{ $orderDetails['coupon_code'] }}</td>
        </tr>
        <tr>
          <td>Coupon Amount</td>
          <td>{{ $orderDetails['coupon_amount'] }}</td>
        </tr>
        <tr>
          <td>Payment Method</td>
          <td>{{ $orderDetails['payment_method'] }}</td>
        </tr>
      </table>
    </div>
    <div class="span4">
      <table class="table table-striped table-bordered">
        <tr>
          <th colspan="2"><strong>Delivery Address</strong></th>
        </tr>
        <tr>
          <td>Name</td>
          <td>{{ $orderDetails['name'] }}</td>
        </tr>
        <tr>
          <td>Address</td>
          <td>{{ $orderDetails['address'] }}</td>
        </tr>
        <tr>
          <td>City</td>
          <td>{{ $orderDetails['city'] }}</td>
        </tr>
        <tr>
          <td>State</td>
          <td>{{ $orderDetails['state'] }}</td>
        </tr>
        <tr>
          <td>Country</td>
          <td>{{ $orderDetails['country'] }}</td>
        </tr>
        <tr>
          <td>Pincode</td>
          <td>{{ $orderDetails['pincode'] }}</td>
        </tr>
        <tr>
          <td>Mobile</td>
          <td>{{ $orderDetails['mobile'] }}</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="span8">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Product Image</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Product Size</th>
            <th>Product Color</th>
            <th>Product Qty</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orderDetails['order_products'] as $product)
            @php
              $image = App\Models\Product::getProductImage($product['product_id']);
            @endphp
            <tr>
              <td>
                <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                  <img width="70" src="{{ asset('public/images/product_images/small/'.$image) }}" alt="{{ $product['product_name'] }}">
                </a>
              </td>
              <td>{{ $product['product_code'] }}</td>
              <td>{{ $product['product_name'] }}</td>
              <td>{{ $product['product_size'] }}</td>
              <td>{{ $product['product_color'] }}</td>
              <td>{{ $product['product_qty'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>	
</div>
@endsection