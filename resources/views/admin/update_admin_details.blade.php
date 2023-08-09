@extends('layouts.admin_layouts.admin_layout')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-bold">Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Settings</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="text-center text-bold">Update Admin Details</h4>

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

                <form 
                  class="forms-sample" 
                  action="{{ url('admin/update-admin-details') }}" 
                  method="POST"
                  id="updateAdminDetailsForm"
                  name="updateAdminDetailsForm"
                  enctype="multipart/form-data"
                >
                @csrf
                  <div class="form-group">
                    <label>Admin Email</label>
                    <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                  </div>
                  <div class="form-group">
                    <label>Admin Type</label>
                    <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly>
                  </div>
                  <div class="form-group">
                    <label for="admin_name">Name</label>
                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" name="admin_name" id="admin_name" placeholder="Current Name">
                  </div>
                  <div class="form-group">
                    <label for="admin_mobile">Mobile</label>
                    <input 
                      type="text" 
                      class="form-control" 
                      value="{{ Auth::guard('admin')->user()->mobile }}" 
                      name="admin_mobile" 
                      id="admin_mobile" 
                      placeholder="Enter New Mobile Number"
                      maxlength="12"
                      minlength="10"
                      required
                    >
                  </div>
                  <div class="form-group">
                    <label for="admin_image">Admin Photo</label>
                    <input 
                      type="file" 
                      class="form-control" 
                      value="{{ Auth::guard('admin')->user()->image }}" 
                      name="admin_image" 
                      id="admin_image"
                    >
                    @if (!empty(Auth::guard('admin')->user()->image))
                      <a href="{{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}" target="_blank">View Photo</a>
                      <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary mr-2">Submit</button>
                  <button type="reset" class="btn btn-light">Cancel</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection