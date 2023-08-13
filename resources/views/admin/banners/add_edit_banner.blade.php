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
      <!-- SELECT2 EXAMPLE -->
      <div class="card card-default">
        <div class="card-header">
          <h4 class="text-center text-bold">{{ $title }}</h4>
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
        
        <form name="bannerForm" id="bannerForm" 
          @if (empty($banner->id))
            action="{{ url('admin/add-edit-banner') }}"
          @else
            action="{{ url('admin/add-edit-banner/'.$banner->id) }}"    
          @endif 
          method="POST" enctype="multipart/form-data"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="image">Banner Image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input"
                        id="image" name="image" 
                        @if (!empty($banner['image']))
                          value="{{ $banner['image'] }}"
                        @else
                          value="{{ old('image') }}"  
                        @endif
                      >
                      <label class="custom-file-label" for="image">
                        @if (!empty($banner['image']))
                          {{ $banner['image'] }}
                        @else
                          Choose file
                        @endif
                      </label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text">Upload</span>
                    </div> 
                  </div>
                  <div>
                    <span>Recommended Image Size: Width: 1170px, Height: 480px</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="link">Banner Link</label>
                  <input type="text" class="form-control" 
                    name="link" id="link" 
                    placeholder="Enter Banner Link"
                    @if (!empty($banner['link']))
                      value="{{ $banner['link'] }}"
                    @else
                      value="{{ old('link') }}"    
                    @endif 
                  >
                </div>
                <div class="form-group">
                  <label for="title">Banner Title</label>
                  <input type="text" class="form-control" 
                    name="title" id="title" 
                    placeholder="Enter Banner Title"
                    @if (!empty($banner['title']))
                      value="{{ $banner['title'] }}"
                    @else
                      value="{{ old('title') }}"    
                    @endif 
                  >
                </div>
                <div class="form-group">
                  <label for="alt">Banner Alternate Text</label>
                  <input type="text" class="form-control" 
                    name="alt" id="alt" 
                    placeholder="Enter Banner Alternate Text"
                    @if (!empty($banner['alt']))
                      value="{{ $banner['alt'] }}"
                    @else
                      value="{{ old('alt') }}"    
                    @endif 
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="text-center">
                  <img width="400" class="mt-5" src="{{ asset('public/images/banner_images/'.$banner['image']) }}" alt="banner image">
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