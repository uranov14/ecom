@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <ul class="breadcrumb">
    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
    <li class="active"> CHECKOUT</li>
  </ul>
  <h3>  CHECKOUT [ <span><span class="totalCartItems">{{ totalCartItems() }}</span> Item(s) </span>]
    <a href="{{ url('cart') }}" class="btn btn-large pull-right">
      <i class="icon-arrow-left"></i> 
      Back to Cart 
    </a>
  </h3>	
  <hr class="soft"/>		
  @if (Session::has('success_message'))
    <div class="alert alert-success" role="alert">
      <strong>Success: </strong>{{ Session::get('success_message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php Session::forget('success_message'); ?>
  @endif
  @if (Session::has('error_message'))
    <div class="alert alert-danger" role="alert">
      {{ Session::get('error_message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php Session::forget('error_message'); ?>
  @endif
  <form action="{{ url('/checkout') }}" name="checkoutForm" id="checkoutForm" method="POST">@csrf
    <table class="table table-bordered">
      <tr>
        <td> 
          <strong>DELIVERY ADDRESSES</strong>
          &nbsp;&nbsp;&nbsp;
          <a href="{{ url('add-edit-delivery-address') }}" class="btn block">Add</a> 
        </td>
      </tr>
      @foreach ($deliveryAddresses as $address)
        <tr> 
          <td>
            <div class="control-group">
              <input type="radio" 
                name="address_id" id="address{{ $address['id'] }}" 
                style="margin-top: -3px;"
                shipping_charges="{{ $address['shipping_charges'] }}"
                total_price="{{ $total_price }}"
                coupon_amount="{{ Session::get('couponAmount') }}"
                codpincodeCount="{{ $address['codpincodeCount'] }}"
                prepaidpincodeCount="{{ $address['prepaidpincodeCount'] }}"
                value="{{ $address['id'] }}"
              >
              <span>{{ $address['name'] }}, {{ $address['address'] }}, {{ $address['city'] }}, {{ $address['state'] }}, {{ $address['country'] }} ({{ $address['pincode'] }})</span>
              <span style="float: right;">Mobile: {{ $address['mobile'] }}</span>
            </div>
          </td>
          <td>
            <a href="{{ url('add-edit-delivery-address/'.$address['id']) }}" 
              class="btn btn-warning"
              style="color: black"
            >
              Edit
            </a>
            &nbsp;&nbsp;&nbsp;
            <a href="{{ url('delete-delivery-address/'.$address['id']) }}" class="btn btn-danger addressDelete">Delete</a>
          </td>
        </tr>
      @endforeach
    </table>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Product</th>
          <th colspan="2">Description</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Discount</th>
          <th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
        <?php $total_price = 0; ?>
        @foreach ($getCartItems as $item)
        @php
          $attrPrice = App\Models\Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
        @endphp
          <tr>
            <td>
              <img width="60" src="{{ asset('images/product_images/small/'.$item['product']['main_image']) }}" alt=""/>
            </td>
            <td colspan="2">
              {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br/>
              Color : {{ $item['product']['product_color'] }}<br/>
              Size : {{ $item['size'] }}
            </td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $attrPrice['product_price'] * $item['quantity'] }} $</td>
            <td>{{ $attrPrice['discount'] * $item['quantity'] }} $</td>
            <td>{{ $attrPrice['final_price'] * $item['quantity'] }} $</td>
          </tr>
          <?php $total_price += $attrPrice['final_price'] * $item['quantity']; ?>
        @endforeach
        <tr>
          <td colspan="6" style="text-align:right">Sub Total Price:</td>
          <td>{{ $total_price }}&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong></td>
        </tr>
        <tr>
          <td colspan="6" style="text-align:right">Coupon Discount:</td>
          <td class="couponAmount">
            @if (Session::has('couponAmount'))
              {{ Session::get('couponAmount') }}&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong>
            @else
              0 $
            @endif
          </td>
        </tr>
        <tr>
          <td colspan="6" style="text-align:right">Shipping Charges:</td>
          <td class="shippingCharges">0&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong></td>
        </tr>
        <tr>
          <td colspan="6" style="text-align:right"><strong>GRAND TOTAL ({{ $total_price }} <strong style="font-size: .675rem;">&#x20b4;</strong> - <span class="couponAmount">{{ Session::get('couponAmount') }} <strong style="font-size: .675rem;">&#x20b4;</strong></span> + <span class="shippingCharges">0 <strong style="font-size: .675rem;">&#x20b4;</strong></span>) </strong></td>
          <td class="label label-important" style="display:block"> <strong class="grand_total">{{ $total_price - Session::get('couponAmount') }} &#x20b4;</strong></td>
        </tr>
      </tbody>
    </table>

    <table class="table table-bordered">
      <tbody>
        <tr>
          <td> 
            <div style="display: flex; justify-content:flex-end; margin-right: 2rem;">
              <label class="control-label" style="margin-right: 3rem;"><strong> PAYMENT METHODS: </strong> </label>
              <div class="controls">
                <span class="codMethod">
                  <input type="radio" name="payment_gateway" id="COD" value="COD" style="margin-top: -3px;">&nbsp;&nbsp;<strong>COD</strong>
                </span>
                <br/>
                <span class="prepaidMethod">
                  <input type="radio" name="payment_gateway" id="PayPal" value="PayPal" style="margin-top: -3px;">&nbsp;&nbsp;<strong>PayPal</strong>
                </span>
              </div>
            </div>
          </td>
        </tr>				
      </tbody>
    </table>

    <a href="{{ url('cart') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Back to Cart </a>
    <button type="submit" class="btn btn-large pull-right">Place Order <i class="icon-arrow-right"></i></button>
  </form>
</div>
@endsection