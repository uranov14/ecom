@extends('layouts.admin_layouts.admin_layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-bold">Settings</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Admin Settings</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="text-center text-bold">Update Admin Password</h4>

              @if (Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error: </strong>{{ Session::get('error_message') }}
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
              
              <form 
                role="form"
                class="forms-sample" 
                action="{{ url('/admin/update-current-password') }}" 
                method="POST"
                id="updatePasswordForm"
                name="updatePasswordForm"
              >@csrf
                {{-- <div class="form-group">
                  <label>Admin Name</label>
                  <input type="text" 
                    name="admin_name"
                    class="form-control" 
                    value="{{ $adminDetails->name }}" 
                    placeholder="Enter Name"
                    readonly>
                </div> --}}
                <div class="form-group">
                  <label for="admin_email">Admin Email</label>
                  <input id="admin_email" class="form-control" value="{{ $adminDetails->email }}" readonly>
                </div>
                <div class="form-group">
                  <label for="admin_type">Admin Type</label>
                  <input id="admin_type" class="form-control" value="{{ $adminDetails->type }}" readonly>
                </div>
                <div class="form-group">
                  <label for="current_pwd">Current Password</label>
                  <input 
                    type="password" 
                    class="form-control" 
                    name="current_pwd" 
                    id="current_pwd" 
                    placeholder="Enter Current Password"
                    required
                  >
                  <span id="check_password"></span>
                </div>
                <div class="form-group">
                  <label for="new_password">New Password</label>
                  <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New Password" required>
                </div>
                <div class="form-group">
                  <label for="confirm_assword1">Confirm Password</label>
                  <input type="password" class="form-control" name="confirm_password" id="confirm_assword1" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection