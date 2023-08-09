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
              <li class="breadcrumb-item active">Ratings & Reviews</li>
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
                <h3 class="card-title text-bold">Ratings & Reviews</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ratings" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User Email</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($ratings as $rating)
                    <tr>
                      <td>{{ $rating['id'] }}</td>
                      <td>{{ $rating['product']['product_name'] }}</td>
                      <td>{{ $rating['user']['email'] }}</td>
                      <td>{{ $rating['rating'] }}</td>
                      <td>{{ $rating['review'] }}</td>
                      <td>
                        @if ($rating['status'] == 1)
                          <span id="show-status-{{ $rating['id'] }}" style=" color: green;">Active</span>
                          <a class="updateRatingStatus" 
                            style="float: right;" 
                            id="rating-{{ $rating['id'] }}"
                            rating_id="{{ $rating['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <span id="show-status-{{ $rating['id'] }}" style=" color: red;">Inactive</span>
                          <a class="updateRatingStatus"
                            style="float: right;"
                            id="rating-{{ $rating['id'] }}" 
                            rating_id="{{ $rating['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
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

@php
  Session::forget('success_message');
@endphp