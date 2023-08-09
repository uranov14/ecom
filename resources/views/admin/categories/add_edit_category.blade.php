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
            <li class="breadcrumb-item active">Categories</li>
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
        
        @if (!empty($categorydata['category_image']))
          <div class="m-4 d-flex" style="align-items: flex-end;">
            <img width="200" src="{{ asset('images/category_images/'.$categorydata['category_image']) }}" alt="category image"> 
            <a 
              {{-- href="{{ url('admin/delete-category-image/'.$categorydata['id']) }}" --}} 
              class="confirmDelete btn btn-danger ml-2"
              record="category-image"
              recordid="{{ $categorydata['id'] }}"
              href="javascript:;" 
              style="height: fit-content;"
            >
              Delete Image
            </a>
          </div>   
        @endif
        <form name="categoryForm" id="categoryForm" 
          @if (empty($category->id))
            action="{{ url('admin/add-edit-category') }}"
          @else
            action="{{ url('admin/add-edit-category/'.$category->id) }}"    
          @endif 
          method="POST" enctype="multipart/form-data"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Category Name</label>
                  <input type="text" class="form-control" 
                    name="category_name" id="category_name" 
                    placeholder="Enter Category Name"
                    @if (!empty($category->category_name))
                      value="{{ $category->category_name }}"
                    @else
                      value="{{ old('category_name') }}"    
                    @endif 
                  >
                </div>  

                <div id="appendCategoriesLevel">
                  @include('admin.categories.append_categories_level')
                </div>

                <div class="form-group">
                  <label for="url">Category URL</label>
                  <input type="text" class="form-control" 
                    name="url" id="url" placeholder="Enter Category URL"
                    @if (!empty($category->url))
                      value="{{ $category->url }}"
                    @else
                      value="{{ old('url') }}"    
                    @endif
                  >
                </div>
                <div class="form-group">
                  <label for="category_discount">Category Discount</label>
                  <input type="text" class="form-control" 
                    name="category_discount" id="category_discount" 
                    placeholder="Enter Category Discount"
                    @if (!empty($category->category_discount))
                      value="{{ $category->category_discount }}"
                    @else
                      value="{{ old('category_discount') }}"    
                    @endif 
                  >
                </div>
                <div class="form-group">
                  <label for="description">Category Description</label>
                  <textarea class="form-control" 
                    name="description" id="description" 
                    rows="3" placeholder="Enter ..." 
                  >
                  @if (!empty($category->description))
                    {{ $category->description }}
                  @else
                    {{ old('description') }}   
                  @endif
                  </textarea>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label>Select Section</label>
                  <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach ($getSections as $section)
                      <option 
                        value="{{ $section->id }}"
                        @if (!empty($category->section_id) && $category->section_id == $section->id)
                          selected    
                        @endif
                      >
                        {{ $section->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="category_image">Category Image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="category_image" name="category_image">
                      <label class="custom-file-label" for="category_image">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text">Upload</span>
                    </div> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="meta_title">Meta Title</label>
                  <input type="text" class="form-control" 
                    name="meta_title" id="meta_title" 
                    placeholder="Enter Meta Title"
                    @if (!empty($category->meta_title))
                      value="{{ $category->meta_title }}"
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
                    @if (!empty($category->meta_keywords))
                      value="{{ $category->meta_keywords }}"
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
                  @if (!empty($category->meta_description))
                    {{ $category->meta_description }}
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