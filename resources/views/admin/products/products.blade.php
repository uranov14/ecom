@extends('layouts.admin_layouts.admin_layout')
@php
  use App\Models\Brand;
@endphp
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
              <li class="breadcrumb-item active">Products</li>
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
                <h3 class="text-bold text-center">Products</h3>
                <a href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add Product</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Name (Code)</th>
                    <th>Product Color</th>
                    <th>Product Image</th>
                    <th>Section/Category</th>
                    <th>Brand</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($products as $product)
                    <tr>
                      <td>{{ $product->id }}</td>
                      <td>{{ $product->product_name }} ({{ $product->product_code }})</td>
                      <td>{{ $product->product_color }}</td>
                      <td class="text-center">
                        @php
                          $product_image_path = "public/images/product_images/small/".$product->main_image;
                        @endphp
                        @if (!empty($product->main_image) && file_exists($product_image_path))
                          <img width="100" src="{{ asset('public/images/product_images/small/'.$product->main_image) }}" alt="product image">
                        @else
                          <img width="100" src="{{ asset('public/images/product_images/small/no_image.png') }}" alt="No image">
                        @endif
                      </td>
                      <td>{{ $product->section->name }} / {{ $product->category->category_name }}</td>
                      @php
                        $brand = Brand::where(['id'=>$product->brand_id, 'status'=>1])->select('name')->first();
                      @endphp
                      <td>
                        @if ($product->brand_id == 0)
                          Not Brand
                        @else
                          {{ $brand['name'] }}
                        @endif
                      </td>
                      <td style="width: 100px;">
                        @if ($product->status == 1)
                          <span id="show-status-{{ $product->id }}" style=" color: green;">Active</span>
                        @else
                          <span id="show-status-{{ $product->id }}" style=" color: red;">Inactive</span>  
                        @endif
                        <br>
                        @if ($moduleProducts['edit_access'] == 1 || $moduleProducts['full_access'] == 1)
                          @if ($product->status == 1)
                            <a class="updateProductStatus" 
                              id="product-{{ $product->id }}"
                              product_id="{{ $product->id }}"
                              href="javascript:;"
                              title="Toggle Status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                            </a>
                          @else
                            <a class="updateProductStatus"
                              id="product-{{ $product->id }}" 
                              product_id="{{ $product->id }}"
                              href="javascript:;"
                              title="Toggle Status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                            </a>
                          @endif
                        @endif
                      </td>
                      <td class="text-center">
                        @if ($moduleProducts['edit_access'] == 1 || $moduleProducts['full_access'] == 1)
                          <a href="{{ url('admin/add-attributes/'.$product->id) }}" title="Add/Edit Attributes">
                            <i style="scale: 1.2;" class="fas fa-plus"></i>
                          </a>
                          <br>
                          <a href="{{ url('admin/add-images/'.$product->id) }}" title="Add Alternate Images">
                            <i style="scale: 1.5;" class="fas fa-regular fa-file-image"></i>
                          </a>
                          <br>
                          <a href="{{ url('admin/add-edit-product/'.$product->id) }}" title="Edit Product">
                            <i style="scale: 1.2;" class="fas fa-edit"></i>
                          </a>
                          <br>
                        @endif
                        @if ($moduleProducts['full_access'] == 1)
                          <a 
                            href="javascript:;"
                            class="confirmDelete"
                            record="product"
                            recordid="{{ $product->id }}"
                            title="Delete Product"
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