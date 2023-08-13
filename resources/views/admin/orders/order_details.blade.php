@extends('layouts.admin_layouts.admin_layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-bold">Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success: </strong>{{ Session::get('success_message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      {{ Session::forget('success_message') }}
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order #{{ $orderDetails['id'] }} Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Order Date</td>
                      <td>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->isoFormat('Do MMM YYYY')}}</td>
                    </tr>
                    <tr>
                      <td>Order Status</td>
                      <td>{{ $orderDetails['order_status'] }}</td>
                    </tr>
                    @if (!empty($orderDetails['courier_name']) && !empty($orderDetails['tracking_number']))
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
                    <tr>
                      <td>Payment Gateway</td>
                      <td>{{ $orderDetails['payment_gateway'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delivery Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
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
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customer Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Name</td>
                      <td>{{ $userDetails['name'] }}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>{{ $userDetails['email'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Order Status</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <form action="{{ url('admin/update-order-status') }}" method="POST">@csrf
                          <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                          <select style="height: 1.7rem;" name="order_status" id="order_status" required>
                            <option value="">Select Status</option>
                            @foreach ($orderStatuses as $status)
                              <option value="{{ $status['name'] }}"
                                @if (isset($orderDetails['order_status']) && $orderDetails['order_status'] == $status['name'])
                                  selected
                                @endif
                              >
                                {{ $status['name'] }}
                              </option>
                            @endforeach
                          </select>
                          <input type="text" style="width: 30%;" name="courier_name" id="courier_name" value="{{ $orderDetails['courier_name'] }}" placeholder="Courier Name">
                          <input type="text" style="width: 30%;" name="tracking_number" id="tracking_number" value="{{ $orderDetails['tracking_number'] }}" placeholder="Tracking Number ">
                          <button type="submit" class="btn btn-outline-primary" style="padding-bottom: 1px; padding-top: 2px;">Update</button>
                        </form>
                      </td>
                    </tr>
                     
                    <tr>
                      <td colspan="2">
                        @foreach ($orderLog as $log)
                          <strong>{{ $log['order_status'] }}</strong>
                          <span style="float: right;">
                            {{ date('j F, Y, g:i a', strtotime($log['created_at'])) }}
                          </span>
                          <hr>
                        @endforeach
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Billing Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Name</td>
                      <td>{{ $userDetails['name'] }}</td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td>{{ $userDetails['address'] }}</td>
                    </tr>
                    <tr>
                      <td>City</td>
                      <td>{{ $userDetails['city'] }}</td>
                    </tr>
                    <tr>
                      <td>State</td>
                      <td>{{ $userDetails['state'] }}</td>
                    </tr>
                    <tr>
                      <td>Country</td>
                      <td>{{ $userDetails['country'] }}</td>
                    </tr>
                    <tr>
                      <td>Pincode</td>
                      <td>{{ $userDetails['pincode'] }}</td>
                    </tr>
                    <tr>
                      <td>Mobile</td>
                      <td>{{ $userDetails['mobile'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ordered Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection