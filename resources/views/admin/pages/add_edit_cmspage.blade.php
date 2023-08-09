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
            <li class="breadcrumb-item active">CMS Pages</li>
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
        <form name="cmspageForm" id="cmspageForm" 
          @if (empty($cmspage->id))
            action="{{ url('admin/add-edit-cms-page') }}"
          @else
            action="{{ url('admin/add-edit-cms-page/'.$cmspage->id) }}"    
          @endif 
          method="POST"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" 
                    name="title" id="title" 
                    placeholder="Enter Title"
                    @if (!empty($cmspage->title))
                      value="{{ $cmspage->title }}"
                    @else
                      value="{{ old('title') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="url">URL</label>
                  <input type="text" class="form-control" 
                    name="url" id="url" 
                    placeholder="Enter cmspage URL"
                    @if (!empty($cmspage->url))
                      value="{{ $cmspage->url }}"
                    @else
                      value="{{ old('url') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" 
                    name="description" id="description" 
                    rows="3" placeholder="Enter ..." 
                  >
                  @if (!empty($cmspage->description))
                    {{ $cmspage->description }}
                  @else
                    {{ old('description') }}   
                  @endif
                  </textarea>
                </div> 
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="meta_title">Meta Title</label>
                  <input type="text" class="form-control" 
                    name="meta_title" id="meta_title" 
                    placeholder="Enter Meta Title"
                    @if (!empty($cmspage->meta_title))
                      value="{{ $cmspage->meta_title }}"
                    @else
                      value="{{ old('meta_title') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="meta_keywords">Meta Keywords</label>
                  <input type="text" class="form-control" 
                    name="meta_keywords" id="meta_keywords" 
                    placeholder="Enter Meta Keywords"
                    @if (!empty($cmspage->meta_keywords))
                      value="{{ $cmspage->meta_keywords }}"
                    @else
                      value="{{ old('meta_keywords') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="meta_description">Meta Description</label>
                  <textarea class="form-control" 
                    name="meta_description" id="meta_description" 
                    rows="3" placeholder="Enter ..." 
                  >
                  @if (!empty($cmspage->meta_description))
                    {{ $cmspage->meta_description }}
                  @else
                    {{ old('meta_description') }}   
                  @endif
                  </textarea>
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