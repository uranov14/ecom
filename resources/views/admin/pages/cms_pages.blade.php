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
            {{ Session::forget('success_message') }}
            <div class="card">
              <div class="card-header">
                <h3 class="card-title text-bold">CMS Pages</h3>
                <a href="{{ url('admin/add-edit-cms-page') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Add CMS Pages</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="cmspages" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Created on</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($cms_pages as $page)
                    <tr>
                      <td>{{ $page->id }}</td>
                      <td>{{ $page->title }}</td>
                      <td>{{ $page->url }}</td>
                      <td>{{ $page->created_at }}</td>
                      <td>
                        @if ($page->status == 1)
                          <span id="show-status-{{ $page['id'] }}" style=" color: green;">Active</span>
                          <a class="updateCMSPageStatus" 
                            style="float: right;" 
                            id="page-{{ $page['id'] }}"
                            page_id="{{ $page['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <span id="show-status-{{ $page['id'] }}" style=" color: red;">Inactive</span>
                          <a class="updateCMSPageStatus"
                            style="float: right;"
                            id="page-{{ $page['id'] }}" 
                            page_id="{{ $page['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                          </a>
                        @endif
                      </td>
                      <td>
                        &nbsp;&nbsp;&nbsp;
                        <a href="{{ url('admin/add-edit-cms-page/'.$page->id) }}" title="Edit CMS Page">
                          <i style="scale: 1.2;" class="fas fa-edit"></i>
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a 
                          href="javascript:;"
                          class="confirmDelete"
                          record="page"
                          recordid="{{ $page->id }}"
                          title="Delete CMS Page"
                        >
                          <i style="scale: 1.2;" class="fas fa-trash"></i>
                        </a>
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
