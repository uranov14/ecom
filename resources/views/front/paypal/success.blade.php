@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <ul class="breadcrumb">
    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
    <li class="active"> SUCCESS</li>
  </ul>
  <h3 class="text-center">CONFIRMED !</h3>	
  <hr class="soft"/>		

  <div align="center">
    <h3>
      YOUR PAYMENT ORDER HAS BEEN CONFIRMED!
    </h3>
    <p>Thanks for the payment. We well process your order very soon.</p>
    <p>Your order #{{ Session::get('order_id') }}. <strong style="font-size: 1rem;">Total Amount Paid:</strong> {{ Session::get('grand_total') }} $</p>
  </div>
</div>
@endsection

@php
  Session::forget('order_id');
  Session::forget('grand_total');
  Session::forget('couponCode');
  Session::forget('couponAmount');
@endphp