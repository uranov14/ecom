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
              <li class="breadcrumb-item active">Sections</li>
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
            
            <div class="card">
              <div class="card-header">
                <h2 class="card-title text-bold">Sections</h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($sections as $section)
                    <tr>
                      <td>{{ $section->id }}</td>
                      <td>{{ $section->name }}</td>
                      <td>
                        @if ($section->status == 1)
                          <p id="show-status-{{ $section['id'] }}" style=" color: green;">Active</p>
                        @else
                          <p id="show-status-{{ $section['id'] }}" style=" color: red;">Inactive</p>
                        @endif
                      </td>
                      <td>
                        @if ($section['status'] == 1)
                          <a class="updateSectionStatus" 
                            id="section-{{ $section['id'] }}"
                            section_id="{{ $section['id'] }}"
                            href="javascript:;"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <a class="updateSectionStatus"
                            id="section-{{ $section['id'] }}" 
                            section_id="{{ $section['id'] }}"
                            href="javascript:;"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
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