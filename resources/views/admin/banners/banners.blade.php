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
              <li class="breadcrumb-item active">Banners</li>
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
                <h3 class="card-title text-bold">Banners</h3>
                <a href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add Banners</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="banners" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Link</th>
                    <th>Title</th>
                    <th>Alt</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($banners as $banner)
                    <tr>
                      <td>{{ $banner['id'] }}</td>
                      <td>
                        <img width="180" src="{{ asset('images/banner_images/'.$banner['image']) }}" alt="Banner">
                      </td>
                      <td>{{ $banner['type'] }}</td>
                      <td>{{ $banner['link'] }}</td>
                      <td>{{ $banner['title'] }}</td>
                      <td>{{ $banner['alt'] }}</td>
                      <td>
                        @if ($banner['status'] == 1)
                          <p id="show-status-{{ $banner['id'] }}" style=" color: green;">Active</p>
                        @else
                          <p id="show-status-{{ $banner['id'] }}" style=" color: red;">Inactive</p>
                        @endif
                      </td>
                      <td>
                        @if ($banner['status'] == 1)
                          <a class="updateBannerStatus" 
                            id="banner-{{ $banner['id'] }}"
                            banner_id="{{ $banner['id'] }}"
                            href="javascript:;"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <a class="updateBannerStatus"
                            id="banner-{{ $banner['id'] }}" 
                            banner_id="{{ $banner['id'] }}"
                            href="javascript:;"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                          </a>
                        @endif
                        <br>
                        <a href="{{ url('admin/add-edit-banner/'.$banner['id']) }}" title="edit banner">
                          <i style="scale: 1.2;" class="fas fa-edit"></i>
                        </a>
                        <br>
                        <a 
                          href="javascript:;"
                          class="confirmDelete"
                          record="banner"
                          recordid="{{ $banner['id'] }}"
                          title="Delete Banner"
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