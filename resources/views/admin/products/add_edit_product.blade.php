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
            <li class="breadcrumb-item active">Products</li>
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
        
        @if (!empty($product->main_image))
          <div class="mx-auto my-5 d-flex" style="align-items: flex-end;">
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
        <form name="productForm" id="productForm" 
          @if (empty($product->id))
            action="{{ url('admin/add-edit-product') }}"
          @else
            action="{{ url('admin/add-edit-product/'.$product->id) }}"    
          @endif 
          method="POST" enctype="multipart/form-data"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Select Category</label>
                  <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach ($categories as $section)
                      <optgroup label="{{ $section['name'] }}"></optgroup>
                      @foreach ($section['categories'] as $category)
                        <option value="{{ $category['id'] }}" 
                          @if (!empty($product['category_id']) && $product['category_id'] == $category['id'])
                            selected
                          @endif
                        >
                          &nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}
                        </option>
                        @foreach ($category['subcategories'] as $subcategory)
                          <option value="{{ $subcategory['id'] }}" 
                            @if (!empty($product['category_id']) && $product['category_id'] == $subcategory['id'])
                              selected
                            @endif
                          >
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}
                          </option>
                        @endforeach
                      @endforeach
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Select Brand</label>
                  <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach ($brands as $brand)
                      <option value="{{ $brand['id'] }}"
                        @if (!empty($productdata['brand_id']) && $brand['id'] == $productdata['brand_id'])
                          selected
                        @endif
                      >
                        {{ $brand['name'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="product_name">Product Name</label>
                  <input type="text" class="form-control" 
                    name="product_name" id="product_name" 
                    placeholder="Enter Product Name"
                    @if (!empty($productdata['product_name']))
                      value="{{ $productdata['product_name'] }}"
                    @else
                      value="{{ old('product_name') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="product_code">Product Code</label>
                  <input type="text" class="form-control" 
                    name="product_code" id="product_code" 
                    placeholder="Enter Product Code"
                    @if (!empty($productdata['product_code']))
                      value="{{ $productdata['product_code'] }}"
                    @else
                      value="{{ old('product_code') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="product_color">Product Color</label>
                  <input type="text" class="form-control" 
                    name="product_color" id="product_color" 
                    placeholder="Enter Product Color"
                    @if (!empty($productdata['product_color']))
                      value="{{ $productdata['product_color'] }}"
                    @else
                      value="{{ old('product_color') }}"    
                    @endif 
                  >
                </div>  
                <div class="form-group">
                  <label for="product_weight">Product Weight</label>
                  <input type="text" class="form-control" 
                    name="product_weight" id="product_weight" 
                    placeholder="Enter Product Discount"
                    @if (!empty($productdata['product_weight']))
                      value="{{ $productdata['product_weight'] }}"
                    @else
                      value="{{ old('product_weight') }}"    
                    @endif 
                  >
                </div>
                <div class="form-group">
                  <label for="product_price">Product Price</label>
                  <input type="text" class="form-control" 
                    name="product_price" id="product_price" 
                    placeholder="Enter Product Price"
                    @if (!empty($productdata['product_price']))
                      value="{{ $productdata['product_price'] }}"
                    @else
                      value="{{ old('product_price') }}"    
                    @endif 
                  >
                </div> 
                <div class="form-group">
                  <label for="product_discount">Product Discount (%)</label>
                  <input type="text" class="form-control" 
                    name="product_discount" id="product_discount" 
                    placeholder="Enter Product Discount"
                    @if (!empty($productdata['product_discount']))
                      value="{{ $productdata['product_discount'] }}"
                    @else
                      value="{{ old('product_discount') }}"    
                    @endif 
                  >
                </div>
                <div class="form-group">
                  <label for="description">Product Description</label>
                  <textarea class="form-control" 
                    name="description" id="description" 
                    rows="3" placeholder="Enter ..." 
                  >
                  @if (!empty($productdata['description']))
                    {{ $productdata['description'] }}
                  @else
                    {{ old('description') }}   
                  @endif
                  </textarea>
                </div>
                <div class="form-group">
                  <label for="main_image">Product Main Image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input"
                        id="main_image" name="main_image" 
                        @if (!empty($productdata['main_image']))
                          value="{{ $productdata['main_image'] }}"
                        @else
                          value="{{ old('main_image') }}"  
                        @endif
                      >
                      <label class="custom-file-label" for="main_image">
                        @if (!empty($productdata['main_image']))
                          {{ $productdata['main_image'] }}
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
                    <span>Recommended Image Size: Width: 1000px, Height: 1000px</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="product_video">Product Video</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" 
                        class="custom-file-input" 
                        id="product_video" name="product_video"
                      >
                      <label class="custom-file-label" for="product_video">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text" id="">Upload</span>
                    </div>
                  </div>
                  <div>
                    <span>Recommended Video Size: less then 2048 KB</span>
                  </div>
                  @if(!empty($productdata['product_video']))
                    <div><a href="{{ url('videos/product_videos/'.$productdata['product_video']) }}" download>Download</a>&nbsp;|&nbsp;
                      <a class="confirmDelete" href="javascript:void(0)" record="product-video" recordid="{{ $productdata['id'] }}">Delete Video</a></div>
                  @endif
                </div>
                <div class="form-group">
                  <input type="checkbox" 
                    style="scale: 1.7; margin-left: .2rem;"
                    name="is_featured" id="is_featured" 
                    value="Yes"
                    @if (isset($productdata['is_featured']) && $productdata['is_featured'] == "Yes")
                      checked
                    @endif
                  >
                  <label for="is_featured">&nbsp; &nbsp;Featured</label>
                </div> 
              </div>
              <div class="col-md-6"> 
                <div class="form-group">
                  <label for="group_code">Group Code</label>
                  <input type="text" class="form-control" 
                    name="group_code" id="group_code" 
                    placeholder="Enter Group Code"
                    @if (!empty($productdata['group_code']))
                      value="{{ $productdata['group_code'] }}"
                    @else
                      value="{{ old('group_code') }}"    
                    @endif
                  >
                </div>
                <div class="form-group">
                  <label for="meta_title">Meta Title</label>
                  <input type="text" class="form-control" 
                    name="meta_title" id="meta_title" 
                    placeholder="Enter Meta Title"
                    @if (!empty($productdata['meta_title']))
                      value="{{ $productdata['meta_title'] }}"
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
                    @if (!empty($productdata['meta_keywords']))
                      value="{{ $productdata['meta_keywords'] }}"
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
                  @if (!empty($productdata['meta_description']))
                    {{ $productdata['meta_description'] }}
                  @else
                    {{ old('meta_description') }}    
                  @endif
                  </textarea>
                </div>
                <div class="form-group">
                  <label for="wash_care">Wash Care</label>
                  <textarea class="form-control" 
                    name="wash_care" id="wash_care" 
                    rows="3" placeholder="Enter ..." 
                  >
                  @if (!empty($product->wash_care))
                    {{ $product->wash_care }}
                  @else
                    {{ old('wash_care') }}   
                  @endif
                  </textarea>
                </div>
                <h4 class="text-bold">Product Filters</h4>
                <div class="filters p-3" style="border: 1px solid #ccc; border-radius: 10px;">
                  <div class="form-group">
                    <label>Select Fabric</label>
                    <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($productFilters['fabricArray'] as $fabric)
                        <option value="{{ $fabric }}"
                          @if (!empty($fabric) && $fabric == $product['fabric'])
                            selected
                          @endif
                        >
                          {{ $fabric }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Occasion</label>
                    <select name="occasion" id="occasion" class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($productFilters['occasionArray'] as $occasion)
                        <option value="{{ $occasion }}"
                          @if (!empty($occasion) && $occasion == $product['occasion'])
                            selected
                          @endif
                        >
                          {{ $occasion }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Sleeve</label>
                    <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($productFilters['sleeveArray'] as $sleeve)
                        <option value="{{ $sleeve }}"
                          @if (!empty($sleeve) && $sleeve == $product['sleeve'])
                            selected
                          @endif
                        >
                          {{ $sleeve }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Pattern</label>
                    <select name="pattern" id="pattern" class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($productFilters['patternArray'] as $pattern)
                        <option value="{{ $pattern }}"
                          @if (!empty($pattern) && $pattern == $product['pattern'])
                            selected
                          @endif
                        >
                          {{ $pattern }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Fit</label>
                    <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($productFilters['fitArray'] as $fit)
                        <option value="{{ $fit }}"
                          @if (!empty($fit) && $fit == $product['fit'])
                            selected
                          @endif
                        >
                          {{ $fit }}
                        </option>
                      @endforeach
                    </select>
                  </div>
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