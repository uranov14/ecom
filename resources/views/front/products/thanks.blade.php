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
    <p><strong style="font-size: 1rem;">Grand Total:</strong> {{ Session::get('grand_total') }} $</p>
  </div>
</div>
@endsection

@php
  Session::forget('order_id'); 
  Session::forget('grand_total'); 
@endphp