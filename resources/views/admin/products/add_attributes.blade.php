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
            <li class="breadcrumb-item active">Product Attributes</li>
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
        
        <form name="addAttributeForm" id="addAttributeForm" 
          action="{{ url('admin/add-attributes/'.$productdata['id']) }}" 
          method="POST"
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
                    <img src="{{ asset('images/product_images/small/'.$productdata['main_image']) }}" alt="product image"> 
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
                        <input type="text" style="width: 20%;" id="size" name="size[]" value="" placeholder="Size" required/>
                        <input type="text" style="width: 20%;" id="sku" name="sku[]" value="" placeholder="SKU" required/>
                        <input type="number" style="width: 20%;" id="price" name="price[]" value="" placeholder="Price" required/>
                        <input type="number" style="width: 20%;" id="stock" name="stock[]" value="" placeholder="Stock" required/>
                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>       
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Attributes</button>
          </div>
        </form>

        <form name="editAttributeForm" id="editAttributeForm" 
          action="{{ url('admin/edit-attributes/'.$productdata['id']) }}" 
          method="POST"
        >@csrf
          <div class="card">
            <div class="card-header">
              <h4 class="text-bold text-center">Added Product Attributes</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="products" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Size</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($productdata['attributes'] as $attribute)
                <input type="text" style="display: none;" name="attrId[]" value="{{ $attribute['id'] }}">
                  <tr>
                    <td>{{ $attribute['id'] }}</td>
                    <td>{{ $attribute['size'] }}</td>
                    <td>{{ $attribute['sku'] }}</td>
                    <td style="width: 100px;">
                      <input type="number" name="price[]" value="{{ $attribute['price'] }}" required/>
                    </td>
                    <td style="width: 100px;">
                      <input type="number" name="stock[]" value="{{ $attribute['stock'] }}" required/>
                    </td>
                    <td>
                      @if ($attribute['status'] == 1)
                        <span id="show-status-{{ $attribute['id'] }}" style=" color: green;">Active</span>
                      @else
                        <span id="show-status-{{ $attribute['id'] }}" style=" color: red;">Inactive</span>  
                      @endif
                    </td>
                    <td>
                      @if ($attribute['status'] == 1)
                        <a class="updateAttributeStatus" 
                          id="attribute-{{ $attribute['id'] }}"
                          attribute_id="{{ $attribute['id'] }}"
                          href="javascript:;"
                          title="toggle status"
                        >
                          <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                        </a>
                      @else
                        <a class="updateAttributeStatus"
                          id="attribute-{{ $attribute['id'] }}" 
                          attribute_id="{{ $attribute['id'] }}"
                          href="javascript:;"
                          title="toggle status"
                        >
                          <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                        </a>
                      @endif
                      &nbsp;&nbsp;&nbsp;
                      <a 
                        href="javascript:;"
                        class="confirmDelete"
                        record="attribute"
                        recordid="{{ $attribute['id'] }}"
                        title="delete attribute"
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
              <button type="submit" class="btn btn-primary">Update Attributes</button>
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