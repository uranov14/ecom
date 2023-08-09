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
            <li class="breadcrumb-item active">Admin & Sub-Admin</li>
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
          <h4 class="text-bold">{{ $title }}</h4>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
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
        
        <form name="adminForm" id="adminForm" 
          @if (empty($admin->id))
            action="{{ url('admin/add-edit-admin') }}"
          @else
            action="{{ url('admin/add-edit-admin/'.$admin->id) }}"    
          @endif 
          method="POST" enctype="multipart/form-data"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="admin_name">Admin Name</label>
                  <input type="text" class="form-control" 
                    name="admin_name" id="admin_name" 
                    placeholder="Enter Admin Name"
                    @if (!empty($admin['name']))
                      value="{{ $admin['name'] }}"
                    @else
                      value="{{ old('admin_name') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="admin_mobile">Admin Mobile</label>
                  <input type="text" class="form-control" 
                    name="admin_mobile" id="admin_mobile" 
                    placeholder="Enter Admin Mobile"
                    @if (!empty($admin['mobile']))
                      value="{{ $admin['mobile'] }}"
                    @else
                      value="{{ old('admin_mobile') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="admin_email">Admin Email</label>
                  <input type="email" class="form-control" 
                    name="admin_email" id="admin_email" 
                    placeholder="Enter Admin Email"
                    @if (!empty($admin['email']))
                      value="{{ $admin['email'] }}"
                      disabled
                    @else
                      value="{{ old('admin_email') }}"  
                      required  
                    @endif 
                  >
                </div>  
                <div class="form-group">
                  <label for="admin_type">Admin Type</label>
                  <select name="admin_type" id="admin_type" 
                    class="form-control select2" 
                    style="width: 100%;"
                    @if ($admin['id'] != "")
                      disabled
                    @else
                      required
                    @endif
                  >
                    <option value="">Select</option>
                    <option value="admin"
                      @if (!empty($admin['type']) && $admin['type'] == 'admin')
                        selected
                      @endif
                    >
                      Admin
                    </option>
                    <option value="subadmin"
                      @if (!empty($admin['type']) && $admin['type'] == 'subadmin')
                        selected
                      @endif
                    >
                      Sub-Admin
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="admin_image">Admin Image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input"
                        id="admin_image" name="admin_image" 
                        @if (!empty($admin['image']))
                          value="{{ $admin['image'] }}"
                        @else
                          value="{{ old('admin_image') }}"  
                        @endif
                      >
                      <label class="custom-file-label" for="main_image">
                        @if (!empty($admin['image']))
                          {{ $admin['image'] }}
                        @else
                          Choose file
                        @endif
                      </label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text">Upload</span>
                    </div> 
                  </div>
                  @if (!empty($admin['image']))
                    <a href="{{ url('images/admin_images/admin_photos/'.$admin['image']) }}" target="_blank">View Photo</a>
                    <input type="hidden" name="current_admin_image" value="{{ $admin['image'] }}">
                  @endif
                </div>
                <div class="form-group">
                  <label for="admin_password">Admin Password</label>
                  <input type="password" class="form-control" 
                    name="admin_password" id="admin_password" 
                    placeholder="Enter Admin Password"
                    @if (!empty($admin['password']))
                      value="{{ $admin['password'] }}"
                    @else
                      value="{{ old('admin_password') }}"    
                    @endif
                  >
                </div>
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