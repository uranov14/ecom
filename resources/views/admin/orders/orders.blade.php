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
              <li class="breadcrumb-item active">Orders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">   
            
            @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: </strong>{{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="text-bold text-center">
                  Orders &nbsp; | &nbsp; <a href="{{ url('admin/view-orders-charts') }}">View Orders Report</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="orders" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Ordered Products</th>
                    <th>Order Amount</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($orders as $order)
                    <tr>
                      <td>{{ $order['id'] }}</td>
                      <td>{{ \Carbon\Carbon::parse($order['created_at'])->isoFormat('Do MMM YYYY')}}</td>
                      <td>{{ $order['name'] }}</td>
                      <td>{{ $order['email'] }}</td>
                      <td>
                        @foreach ($order['order_products'] as $key => $product)
                          {{ $key+1 }}) {{ $product['product_name'] }} * {{ $product['product_qty'] }}<br/>
                          Size: {{ $product['product_size'] }}<br/>
                        @endforeach
                      </td>
                      <td>{{ $order['grand_total'] }}</td>
                      <td>{{ $order['order_status'] }}</td>
                      <td>{{ $order['payment_method'] }}</td>
                      <td class="text-center">
                        @if ($moduleOrders['edit_access'] == 1 || $moduleOrders['full_access'] == 1)
                          <a href="{{ url('admin/orders/'.$order['id']) }}" title="View Order Details">
                            <i style="scale: 1.2;" class="fas fa-lightbulb"></i>
                          </a>
                          <br/>
                          @if ($order['order_status'] == "Shipped" || $order['order_status'] == "Delivered")
                            <a target="_blank" href="{{ url('admin/view-order-invoice/'.$order['id']) }}" title="View Order Invoice">
                              <i style="scale: 1.2;" class="fas fa-print"></i>
                            </a>
                            <br/>
                            <a target="_blank" href="{{ url('admin/print-pdf-invoice/'.$order['id']) }}" title="Print PDF Invoice">
                              <i style="scale: 1.2;" class="far fa-file-pdf"></i>
                            </a>
                          @endif
                        @endif
                      </td>
                    </tr>
                  @endforeach
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
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection