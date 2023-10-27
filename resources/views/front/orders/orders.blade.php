@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
  <li class="active">Orders</li>
  </ul>
  <h3>Orders</h3>	
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
    <div class="span8">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>
              Order ID<br/>(Details)
            </th>
            <th style="text-align: center;">Order Products</th>
            <th>Payment Method</th>
            <th>Grand Total</th>
            <th>Created on</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $order)
            <tr>
              <td style="text-align: center; color:blue; text-decoration: underline; font-size: 1rem;">
                <a style="color: blue;" href="{{ url('orders/'.$order['id']) }}" title="View Details Order">
                  #{{ $order['id'] }}
                </a>
              </td>
              <td>
                @foreach ($order['order_products'] as $product)
                  {{ $product['product_name'] }}({{ $product['product_code'] }})<br/>
                @endforeach
              </td>
              <td>{{ $order['payment_method'] }}</td>
              <td>{{ $order['grand_total'] }} $</td>
              <td>
                {{ \Carbon\Carbon::parse($order['created_at'])->isoFormat('Do MMM YYYY')}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>	
</div>
@endsection