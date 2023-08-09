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
              <li class="breadcrumb-item active">Brands</li>
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
                <h3 class="card-title text-bold">Brands</h3>
                <a href="{{ url('admin/add-edit-brand') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add Brand</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="brands" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($brands as $brand)
                    <tr>
                      <td>{{ $brand->id }}</td>
                      <td>{{ $brand->name }}</td>
                      <td>
                        @if ($brand->status == 1)
                          <span id="show-status-{{ $brand['id'] }}" style=" color: green;">Active</span>
                          <a class="updateBrandStatus" 
                            style="float: right;" 
                            id="brand-{{ $brand['id'] }}"
                            brand_id="{{ $brand['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <span id="show-status-{{ $brand['id'] }}" style=" color: red;">Inactive</span>
                          <a class="updateBrandStatus"
                            style="float: right;"
                            id="brand-{{ $brand['id'] }}" 
                            brand_id="{{ $brand['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                          </a>
                        @endif
                      </td>
                      <td>
                        &nbsp;&nbsp;&nbsp;
                        <a href="{{ url('admin/add-edit-brand/'.$brand->id) }}" title="edit brand">
                          <i style="scale: 1.2;" class="fas fa-edit"></i>
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a 
                          href="javascript:;"
                          class="confirmDelete"
                          record="brand"
                          recordid="{{ $brand->id }}"
                          title="delete brand"
                        >
                          <i style="scale: 1.2;" class="fas fa-trash"></i>
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