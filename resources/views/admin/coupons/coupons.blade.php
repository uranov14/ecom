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
              <li class="breadcrumb-item active">Coupons</li>
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
                <h3 class="card-title text-bold">Coupons</h3>
                <a href="{{ url('admin/add-edit-coupon') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add Coupons</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="coupons" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Coupon Type</th>
                    <th>Amount</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($coupons as $coupon)
                    <tr>
                      <td>{{ $coupon['id'] }}</td>
                      <td>{{ $coupon['coupon_code'] }}</td>
                      <td>{{ $coupon['coupon_type'] }}</td>
                      <td>
                        {{ $coupon['amount'] }}
                        @if ($coupon['amount_type'] == "Percentage")
                          %
                        @else
                          $
                        @endif
                      </td>
                      <td>{{ $coupon['expiry_date'] }}</td>
                      <td style="width: 10vw;">
                        @if ($coupon['status'] == 1)
                          <span id="show-status-{{ $coupon['id'] }}" style=" color: green;">Active</span>
                          @if ($moduleCoupons['edit_access'] == 1 || $moduleCoupons['full_access'] == 1)
                            <a class="updateCouponStatus" 
                              style="float: right;"
                              id="coupon-{{ $coupon['id'] }}"
                              coupon_id="{{ $coupon['id'] }}"
                              href="javascript:;"
                              title="Toggle Status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                            </a>
                          @endif
                        @else
                          <span id="show-status-{{ $coupon['id'] }}" style=" color: red;">Inactive</span>
                          @if ($moduleCoupons['edit_access'] == 1 || $moduleCoupons['full_access'] == 1)
                            <a class="updateCouponStatus"
                              style="float: right;"
                              id="coupon-{{ $coupon['id'] }}" 
                              coupon_id="{{ $coupon['id'] }}"
                              href="javascript:;"
                              title="Toggle Status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                            </a>
                          @endif
                        @endif
                      </td>
                      <td>
                        @if ($moduleCoupons['edit_access'] == 1 || $moduleCoupons['full_access'] == 1)
                          <a href="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}" title="Edit Coupon">
                            <i style="scale: 1.2;" class="fas fa-edit"></i>
                          </a>
                          &nbsp;&nbsp;
                        @endif
                        @if ($moduleCoupons['full_access'] == 1)
                          <a 
                            href="javascript:;"
                            class="confirmDelete"
                            record="coupon"
                            recordid="{{ $coupon['id'] }}"
                            title="Delete Coupon"
                          >
                            <i style="scale: 1.2;" class="fas fa-trash"></i>
                          </a>
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