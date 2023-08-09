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
              <li class="breadcrumb-item active">Shipping Charges</li>
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
              <?php Session::forget('success_message'); ?>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="text-bold text-center">Shipping Charges</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="shipping" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>0-500g</th>
                    <th>501-1000g</th>
                    <th>1001-2000g</th>
                    <th>2001-5000g</th>
                    <th>Above 5000g</th>
                    <th>Status</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($shippingCharges as $shipping)
                    <tr>
                      <td>{{ $shipping['id'] }}</td>
                      <td style="width: 10vw;">{{ $shipping['country'] }}</td>
                      <td>{{ $shipping['0_500g'] }} &#x20b4;</td>
                      <td>{{ $shipping['501_1000g'] }} &#x20b4;</td>
                      <td>{{ $shipping['1001_2000g'] }} &#x20b4;</td>
                      <td>{{ $shipping['2001_5000g'] }} &#x20b4;</td>
                      <td>{{ $shipping['above_5000g'] }} &#x20b4;</td>
                      <td class="text-center">
                        @if ($shipping['status'] == 1)
                          <a class="updateShippingStatus" 
                            id="shipping-{{ $shipping['id'] }}"
                            shipping_id="{{ $shipping['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <a class="updateShippingStatus"
                            id="shipping-{{ $shipping['id'] }}"
                            shipping_id="{{ $shipping['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                          </a>
                        @endif
                      </td>
                      <td>{{ \Carbon\Carbon::parse($shipping['updated_at'])->isoFormat('Do MMM YYYY')}}</td>
                      <td class="text-center">
                        <a href="{{ url('admin/edit-shipping-charges/'.$shipping['id']) }}" title="Update Shipping charges">
                          <i style="scale: 1.2;" class="fas fa-edit"></i>
                        </a>
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