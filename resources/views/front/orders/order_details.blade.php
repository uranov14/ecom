@extends('layouts.front_layouts.front_layout')
@php
  use App\Models\Product;
  use App\Models\Order;
  $getOrderStatus = Order::getOrderStatus($orderDetails['id']);
@endphp
@section('content')
<div class="span9">
  <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
  <li class="active"><a href="{{ url('/orders') }}">Orders</a></li>
  </ul>
  <h3>
    Order #{{ $orderDetails['id'] }} Details
    @if ($getOrderStatus == "New")
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#cancelModal">
        Cancel Order
      </button>
    @endif
    @if ($getOrderStatus == "Delivered")
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#returnModal">
        Return/Exchange Order
      </button>
    @endif
  </h3>	

  @if (Session::has('success_message'))
    <div class="alert alert-success" role="alert">
      <strong>Success: </strong>{{ Session::get('success_message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php Session::forget('success_message') ?>
  @endif
  @if (Session::has('error_message'))
    <div class="alert alert-danger" role="alert">
      {{ Session::get('error_message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php Session::forget('error_message') ?>
  @endif

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
          <td>{{ $orderDetails['grand_total'] }} <small>&#x20b4;</small></td>
        </tr>
        <tr>
          <td>Shipping Charges</td>
          <td>{{ $orderDetails['shipping_charges'] }} <small>&#x20b4;</small></td>
        </tr>
        <tr>
          <td>GST Charges</td>
          <td>{{ $orderDetails['gst_charges'] }} <small>&#x20b4;</small></td>
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
            <th>Item Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orderDetails['order_products'] as $product)
            @php
              $image = Product::getProductImage($product['product_id']);
            @endphp
            <tr>
              <td>
                <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                  <img width="70" src="{{ asset('images/product_images/small/'.$image) }}" alt="{{ $product['product_name'] }}">
                </a>
              </td>
              <td>{{ $product['product_code'] }}</td>
              <td>{{ $product['product_name'] }}</td>
              <td>{{ $product['product_size'] }}</td>
              <td>{{ $product['product_color'] }}</td>
              <td>{{ $product['product_qty'] }}</td>
              <td>{{ $product['item_status'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>	
</div>
<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <form action="{{ url('orders/'.$orderDetails['id'].'/cancel') }}" method="POST">@csrf
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelModalLabel">Reason for Cancellation</h5>
        </div>
        <div class="modal-body">
          <select name="reason" id="cancelReason">
            <option value="">Select Reason</option>
            <option value="Order Created by Mistake">Order Created by Mistake</option>
            <option value="Item Not Arrive in Time">Item Not Arrive in Time</option>
            <option value="Shipping Cost too High">Shipping Cost too High</option>
            <option value="Found Cheaper Somewhere Else">Found Cheaper Somewhere Else</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btnCancelOrder">Cancel Order</button>
        </div>
      </div>
    </div>
  </form>
</div>
<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
  <form action="{{ url('orders/'.$orderDetails['id'].'/return') }}" method="POST">@csrf
    <div class="modal-dialog" role="document" align="center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="returnModalLabel">Reason for Return/Exchange</h5>
        </div>
        <div class="modal-body">
          <select name="return_exchange" id="returnExchange" style="width: 60%;">
            <option value="">Select Return/Exchange</option>
            <option value="Return">Return</option>
            <option value="Exchange">Exchange</option>
          </select>
        </div>
        <div class="modal-body">
          <select name="product_info" id="returnProduct" style="width: 60%;">
            <option value="">Select Product</option>
            @foreach ($orderDetails['order_products'] as $product)
              @if ($product['item_status'] != "Return Initiated")
                <option value="{{ $product['id'] }}-{{ $product['product_code'] }}-{{ $product['product_size'] }}">
                  {{ $product['product_name'] }}: {{ $product['product_size'] }}
                </option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="modal-body productSizes">
          <select name="required_size" id="productSizes" style="width: 60%;">
            <option value="">Select Required Size</option>
          </select>
        </div>
        <div class="modal-body">
          <select name="reason" id="returnReason" style="width: 60%;">
            <option value="">Select Reason</option>
            <option value="Perfomance or quality not adequate">Perfomance or quality not adequate</option>
            <option value="Product damaged, but Shipping Box OK">Product damaged, but Shipping Box OK</option>
            <option value="Item arrived too late">Item arrived too late</option>
            <option value="Wrong Item was sent">Wrong Item was sent</option>
            <option value="Item Defective or doesn`t work">Item Defective or doesn`t work</option>
            <option value="Require Smaller Size">Require Smaller Size</option>
            <option value="Require Larger Size">Require Larger Size</option>
          </select>
        </div>
        <div class="modal-body">
          <textarea name="comment" style="width: 60%;" cols="30" rows="3" placeholder="Comment"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btnReturnOrder">Submit</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection