@extends('layouts.admin_layouts.admin_layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-bold">Admins</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admins & Sub-Admins</li>
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
                <h3 class="card-title text-bold">Admins / Sub-Admins</h3>
                <a href="{{ url('admin/add-edit-admin') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add Admin</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="admins" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($admins as $admin)
                    <tr>
                      <td>{{ $admin->id }}</td>
                      <td>{{ $admin->name }}</td>
                      <td>{{ $admin->mobile }}</td>
                      <td>{{ $admin->email }}</td>
                      <td>{{ $admin->type }}</td>
                      <td>
                        @if ($admin->type != "superadmin")
                          @if ($admin->status == 1)
                            <span id="show-status-{{ $admin->id }}" style=" color: green;">Active</span>
                            <a class="updateAdminStatus" 
                              style="float: right;" 
                              id="admin-{{ $admin->id }}"
                              admin_id="{{ $admin->id }}"
                              href="javascript:;"
                              title="Toggle Status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                            </a>
                          @else
                            <span id="show-status-{{ $admin->id }}" style=" color: red;">Inactive</span>
                            <a class="updateAdminStatus"
                              style="float: right;"
                              id="admin-{{ $admin->id }}" 
                              admin_id="{{ $admin->id }}"
                              href="javascript:;"
                              title="Toggle Status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                            </a>
                          @endif
                        @endif
                      </td>
                      <td>
                        @if ($admin->type != "superadmin")
                          <a href="{{ url('admin/update-role/'.$admin->id) }}" title="Set Roles/Permissions">
                            <i style="scale: 1.2;" class="fas fa-unlock"></i>
                          </a>
                          &nbsp;&nbsp;&nbsp;
                          <a href="{{ url('admin/add-edit-admin/'.$admin->id) }}" title="Edit Admin">
                            <i style="scale: 1.2;" class="fas fa-edit"></i>
                          </a>
                          &nbsp;&nbsp;&nbsp;
                          <a 
                            href="javascript:;"
                            class="confirmDelete"
                            record="admin"
                            recordid="{{ $admin->id }}"
                            title="Delete Admin"
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