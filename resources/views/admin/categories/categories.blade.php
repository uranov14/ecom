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
                <h3 class="text-bold text-center">Categories</h3>
                <a href="{{ url('admin/add-edit-category') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add Category</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="categories" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Parent Category</th>
                    <th>Section</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($categories as $category)
                    @if (isset($category->parentcategory->category_name) && !empty($category->parentcategory->category_name))
                      @php $parent_category = $category->parentcategory->category_name @endphp
                    @else
                      @php $parent_category = "Root" @endphp
                    @endif
                    <tr>
                      <td>{{ $category->id }}</td>
                      <td>{{ $category->category_name }}</td>
                      <td>{{ $parent_category }}</td>
                      <td>{{ $category->section->name }}</td>
                      <td>{{ $category->url }}</td>
                      <td>
                        @if ($category->status == 1)
                          <span id="show-status-{{ $category->id }}" style=" color: green;">Active</span>
                          @if ($moduleCategories['edit_access'] == 1 || $moduleCategories['full_access'] == 1)
                            <a class="updateCategoryStatus" 
                              style="float: right;"
                              id="category-{{ $category->id }}"
                              category_id="{{ $category->id }}"
                              href="javascript:;"
                              title="toggle status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                            </a>
                          @endif
                        @else
                          <span id="show-status-{{ $category->id }}" style=" color: red;">Inactive</span>
                          @if ($moduleCategories['edit_access'] == 1 || $moduleCategories['full_access'] == 1)
                            <a class="updateCategoryStatus"
                              style="float: right;"
                              id="category-{{ $category->id }}" 
                              category_id="{{ $category->id }}"
                              href="javascript:;"
                              title="toggle status"
                            >
                              <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                            </a>
                          @endif
                        @endif
                      </td>
                      <td>
                        @if ($moduleCategories['edit_access'] == 1 || $moduleCategories['full_access'] == 1)
                          <a href="{{ url('admin/add-edit-category/'.$category->id) }}" title="edit category">
                            <i style="scale: 1.2;" class="fas fa-edit"></i>
                          </a>
                        @endif
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        @if ($moduleCategories['full_access'] == 1)
                          <a 
                            href="javascript:;"
                            class="confirmDelete"
                            record="category"
                            recordid="{{ $category->id }}"
                            title="delete category"
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