@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <ul class="breadcrumb">
    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
    <li class="active"> FAILED</li>
  </ul>
  <h3>FAILED</h3>	
  <hr class="soft"/>		

  <div align="center">
    <h3>
      YOUR ORDER 
      <a href="{{ url('orders/'.Session::get('order_id')) }}" style="color: blue;">
        #{{ Session::get('order_id') }}
      </a> 
      HAS BEEN FAILED
    </h3>
    <p>Please try again after some time and contact us if there is enquire</p>
  </div>
</div>
@endsection
