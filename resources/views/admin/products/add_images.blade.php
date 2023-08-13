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
            <li class="breadcrumb-item active">Product Images</li>
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
        
        <form name="addImageForm" id="addImageForm" 
          action="{{ url('admin/add-images/'.$productdata['id']) }}" 
          method="POST"
          enctype="multipart/form-data"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="product_name">Product Name:</label> &nbsp;{{ $productdata['product_name'] }}
                </div> 
                <div class="form-group">
                  <label for="product_code">Product Code:</label> &nbsp;{{ $productdata['product_code'] }}
                </div> 
                <div class="form-group">
                  <label for="product_color">Product Color:</label> &nbsp;{{ $productdata['product_color'] }}
                </div>  
                <div class="form-group">
                  <label for="product_price">Product Price:</label> &nbsp;{{ $productdata['product_price'] }}
                </div> 
              </div>
              <div class="col-md-6 my-auto">
                @if (!empty($productdata['main_image']))
                  <div class="d-flex" style="align-items: flex-end; justify-content: center;">
                    <img src="{{ asset('public/images/product_images/small/'.$productdata['main_image']) }}" alt="product image"> 
                    <a 
                      class="confirmDelete btn btn-danger ml-2"
                      record="product-image"
                      recordid="{{ $productdata['id'] }}"
                      href="javascript:void(0)" 
                      style="height: fit-content;"
                    >
                      Delete Image
                    </a>
                  </div>   
                @endif
              </div>
              <div class="col-md-6">
                @if (Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" style="width: fit-content;" role="alert">
                    <strong>Error: </strong>{{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <div class="form-group">
                  <div class="field_wrapper">
                    <div>
                      <input type="file" id="image" name="image[]" value="" multiple required/>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>       
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Images</button>
          </div>
        </form>

        <form name="editImageForm" id="editImageForm" 
          action="{{ url('admin/edit-images/'.$productdata['id']) }}" 
          method="POST"
        >@csrf
          <div class="card">
            <div class="card-header">
              <h4 class="text-bold text-center">Added Product Images</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="products" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($productdata['images'] as $image)
                <input type="text" style="display: none;" name="attrId[]" value="{{ $image['id'] }}">
                  <tr>
                    <td>{{ $image['id'] }}</td>
                    <td>
                      <img width="100" src="{{ asset('public/images/product_images/small/'.$image['image']) }}" alt="product image">
                    </td>
                    <td>
                      @if ($image['status'] == 1)
                        <span id="show-status-{{ $image['id'] }}" style=" color: green;">Active</span>
                      @else
                        <span id="show-status-{{ $image['id'] }}" style=" color: red;">Inactive</span>  
                      @endif
                    </td>
                    <td>
                      @if ($image['status'] == 1)
                        <a class="updateImageStatus" 
                          id="image-{{ $image['id'] }}"
                          image_id="{{ $image['id'] }}"
                          href="javascript:;"
                          title="toggle status"
                        >
                          <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                        </a>
                      @else
                        <a class="updateImageStatus"
                          id="image-{{ $image['id'] }}" 
                          image_id="{{ $image['id'] }}"
                          href="javascript:;"
                          title="toggle status"
                        >
                          <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                        </a>
                      @endif
                      <br><br>
                      <a 
                        href="javascript:;"
                        class="confirmDelete"
                        record="image"
                        recordid="{{ $image['id'] }}"
                        title="delete image"
                      >
                        <i style="scale: 1.5;" class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Update Images</button>
            </div>
            <!-- /.card-body -->
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