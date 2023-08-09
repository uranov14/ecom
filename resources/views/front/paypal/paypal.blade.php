@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <ul class="breadcrumb">
    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
    <li class="active"> THANKS</li>
  </ul>
  <h3>THANKS !</h3>	
  <hr class="soft"/>		

  <div align="center">
    <h3>
      YOUR ORDER 
      <a href="{{ url('orders/'.Session::get('order_id')) }}" style="color: blue;">
        #{{ Session::get('order_id') }}
      </a> 
      HAS BEEN PLACED SUCCESSFULLY
    </h3>
    <p><strong style="font-size: 1rem;">Total Payable Amount:</strong> {{ Session::get('grand_total') }} $</p>
    <p>Please make payment by clicking on below Payment button:</p>

    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post"> 
      <input type="hidden" name="cmd" value="_xclick"> 
      <input type="hidden" name="business" value="sb-pzmdy24352821@business.example.com"> 
      <input type="hidden" name="currency_code" value="USD"> 
      <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}"> 
      <input type="hidden" name="amount" value="{{ round(Session::get('grand_total'), 2) }}"> 
      <input type="hidden" name="first_name" value="{{ $nameArr[0] }}"> 
      <input type="hidden" name="last_name" value="{{ $nameArr[1] }}"> 
      <input type="hidden" name="address1" value="{{ $orderDetails['address'] }}"> 
      <input type="hidden" name="address2" value=""> 
      <input type="hidden" name="city" value="{{ $orderDetails['city'] }}"> 
      <input type="hidden" name="state" value="{{ $orderDetails['state'] }}"> 
      <input type="hidden" name="country" value="{{ $orderDetails['country'] }}"> 
      <input type="hidden" name="zip" value="{{ $orderDetails['pincode'] }}"> 
      <input type="hidden" name="email" value="{{ $orderDetails['email'] }}">
      <input type="hidden" name="return" value="{{ url('paypal/success') }}"> 
      <input type="hidden" name="cancel_return" value="{{ url('paypal/fail') }}">
      <input type="hidden" name="notify_url" value="{{ url('paypal/ipn') }}">  
      <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" alt="PayPal - The safer, easier way to pay online"> 
    </form>
  </div>
</div>
@endsection

@php
  Session::forget('couponCode');
  Session::forget('couponAmount');
@endphp