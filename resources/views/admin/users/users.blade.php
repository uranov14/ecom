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
              <li class="breadcrumb-item active">Users</li>
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
                <h3 class="card-title text-bold">Users</h3>
                <a href="{{ url('admin/add-edit-user') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add User</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="users" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Pincode</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($users as $user)
                    <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->address }}</td>
                      <td>{{ $user->city }}</td>
                      <td>{{ $user->state }}</td>
                      <td>{{ $user->country }}</td>
                      <td>{{ $user->pincode }}</td>
                      <td>{{ $user->mobile }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                        @if ($user['status'] == 1)
                          <a class="updateUserStatus" 
                            id="user-{{ $user['id'] }}"
                            user_id="{{ $user['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <a class="updateUserStatus"
                            id="user-{{ $user['id'] }}" 
                            user_id="{{ $user['id'] }}"
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