@extends('layouts.admin_layouts.admin_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-bold">Admins/Sub-Admins</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Admins/Sub-Admins</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- SELECT2 EXAMPLE -->
      <div class="card card-default">
        <div class="card-header">
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <h5 class="text-bold">{{ $title }}</h5>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if (Session::has('success_message'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success: </strong>{{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        <form name="roleForm" id="roleForm" 
          action="{{ url('admin/update-role/'.$adminDetails['id']) }}" 
          method="POST"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-5">
                @if (!empty($adminRoles))
                  @foreach ($adminRoles as $role)
                    @if ($role['module'] == "categories")
                      @if ($role['view_access'] == 1)
                        <?php $viewCategories = "checked"; ?>
                      @else
                        <?php $viewCategories = ""; ?>
                      @endif
                      @if ($role['edit_access'] == 1)
                        <?php $editCategories = "checked"; ?>
                      @else
                        <?php $editCategories = ""; ?>
                      @endif
                      @if ($role['full_access'] == 1)
                        <?php $fullCategories = "checked"; ?>
                      @else
                        <?php $fullCategories = ""; ?>
                      @endif
                    @endif
                  @endforeach
                @else
                  <?php $viewCategories = ""; ?>
                  <?php $editCategories = ""; ?>
                  <?php $fullCategories = ""; ?>
                @endif
                <div class="form-group">
                  <label>Categories</label>
                  <div>
                    <input type="checkbox" name="categories[view]" style="scale: 1.2;" value="1" @if (isset($viewCategories))
                      {{ $viewCategories }}
                    @endif> View Access &nbsp;&nbsp;
                    <input type="checkbox" name="categories[edit]" style="scale: 1.2;" value="1" @if (isset($viewCategories))
                      {{ $editCategories }}
                    @endif> Edit Access &nbsp;&nbsp;
                    <input type="checkbox" name="categories[full]" style="scale: 1.2;" value="1" @if (isset($viewCategories))
                      {{ $fullCategories }}
                    @endif> Full Access &nbsp;&nbsp;
                  </div>
                </div> 
                <hr>
                @if (!empty($adminRoles))
                  @foreach ($adminRoles as $role)
                    @if ($role['module'] == "products")
                      @if ($role['view_access'] == 1)
                        <?php $viewProducts = "checked"; ?>
                      @else
                        <?php $viewProducts = ""; ?>
                      @endif
                      @if ($role['edit_access'] == 1)
                        <?php $editProducts = "checked"; ?>
                      @else
                        <?php $editProducts = ""; ?>
                      @endif
                      @if ($role['full_access'] == 1)
                        <?php $fullProducts = "checked"; ?>
                      @else
                        <?php $fullProducts = ""; ?>
                      @endif
                    @endif
                  @endforeach
                @else
                  <?php $viewProducts = ""; ?>
                  <?php $editProducts = ""; ?>
                  <?php $fullProducts = ""; ?>
                @endif
                <div class="form-group">
                  <label>Products</label>
                  <div>
                    <input type="checkbox" name="products[view]" style="scale: 1.2;" value="1" @if (isset($viewProducts))
                      {{ $viewProducts }}
                    @endif> View Access &nbsp;&nbsp;
                    <input type="checkbox" name="products[edit]" style="scale: 1.2;" value="1" @if (isset($editProducts))
                      {{ $editProducts }}
                    @endif> Edit Access &nbsp;&nbsp;
                    <input type="checkbox" name="products[full]" style="scale: 1.2;" value="1" @if (isset($fullProducts))
                      {{ $fullProducts }}
                    @endif> Full Access &nbsp;&nbsp;
                  </div>
                </div> 
                <hr>
                @if (!empty($adminRoles))
                  @foreach ($adminRoles as $role)
                    @if ($role['module'] == "coupons")
                      @if ($role['view_access'] == 1)
                        <?php $viewCoupons = "checked"; ?>
                      @else
                        <?php $viewCoupons = ""; ?>
                      @endif
                      @if ($role['edit_access'] == 1)
                        <?php $editCoupons = "checked"; ?>
                      @else
                        <?php $editCoupons = ""; ?>
                      @endif
                      @if ($role['full_access'] == 1)
                        <?php $fullCoupons = "checked"; ?>
                      @else
                        <?php $fullCoupons = ""; ?>
                      @endif
                    @endif
                  @endforeach
                @else
                  <?php $viewCoupons = ""; ?>
                  <?php $editCoupons = ""; ?>
                  <?php $fullCoupons = ""; ?>
                @endif
                <div class="form-group">
                  <label>Coupons</label>
                  <div>
                    <input type="checkbox" name="coupons[view]" style="scale: 1.2;" value="1" @if (isset($viewCoupons))
                      {{ $viewCoupons }}
                    @endif> View Access &nbsp;&nbsp;
                    <input type="checkbox" name="coupons[edit]" style="scale: 1.2;" value="1" @if (isset($editCoupons))
                      {{ $editCoupons }}
                    @endif> Edit Access &nbsp;&nbsp;
                    <input type="checkbox" name="coupons[full]" style="scale: 1.2;" value="1" @if (isset($fullCoupons))
                      {{ $fullCoupons }}
                    @endif> Full Access &nbsp;&nbsp;
                  </div>
                </div>
                <hr> 
                @if (!empty($adminRoles))
                  @foreach ($adminRoles as $role)
                    @if ($role['module'] == "orders")
                      @if ($role['view_access'] == 1)
                        <?php $viewOrders = "checked"; ?>
                      @else
                        <?php $viewOrders = ""; ?>
                      @endif
                      @if ($role['edit_access'] == 1)
                        <?php $editOrders = "checked"; ?>
                      @else
                        <?php $editOrders = ""; ?>
                      @endif
                      @if ($role['full_access'] == 1)
                        <?php $fullOrders = "checked"; ?>
                      @else
                        <?php $fullOrders = ""; ?>
                      @endif
                    @endif
                  @endforeach
                @else
                  <?php $viewOrders = ""; ?>
                  <?php $editOrders = ""; ?>
                  <?php $fullOrders = ""; ?>
                @endif
                <div class="form-group">
                  <label>Orders</label>
                  <div>
                    <input type="checkbox" name="orders[view]" style="scale: 1.2;" value="1" @if (isset($viewOrders))
                      {{ $viewOrders }}
                    @endif> View Access &nbsp;&nbsp;
                    <input type="checkbox" name="orders[edit]" style="scale: 1.2;" value="1" @if (isset($editOrders))
                      {{ $editOrders }}
                    @endif> Edit Access &nbsp;&nbsp;
                    <input type="checkbox" name="orders[full]" style="scale: 1.2;" value="1" @if (isset($fullOrders))
                      {{ $fullOrders }}
                    @endif> Full Access &nbsp;&nbsp;
                  </div>
                </div> 
                <hr> 
              </div>
            </div>
          </div>       
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection