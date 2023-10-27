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
              <li class="breadcrumb-item active">Newsletter Subscribers</li>
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
                <h3 class="card-title text-bold">Newsletter Subscribers</h3>
                <a href="{{ url('admin/export-subscribers') }}" class="btn btn-block btn-success" style="width: fit-content; float: right;">Export Subscribers</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="subscribers" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subscribed on</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($subscribers as $subscriber)
                    <tr>
                      <td>{{ $subscriber['id'] }}</td>
                      <td>{{ $subscriber['email'] }}</td>
                      <td>{{ date('d-m-Y h:i:s', strtotime($subscriber['created_at'])) }}</td>
                      <td>
                        @if ($subscriber['status'] == 1)
                          <span id="show-status-{{ $subscriber['id'] }}" style=" color: green;">Active</span>
                          <a class="updateSubscriberStatus" 
                            style="float: right;" 
                            id="subscriber-{{ $subscriber['id'] }}"
                            subscriber_id="{{ $subscriber['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-on" status="Active"></i>
                          </a>
                        @else
                          <span id="show-status-{{ $subscriber['id'] }}" style=" color: red;">Inactive</span>
                          <a class="updateSubscriberStatus"
                            style="float: right;"
                            id="subscriber-{{ $subscriber['id'] }}" 
                            subscriber_id="{{ $subscriber['id'] }}"
                            href="javascript:;"
                            title="Toggle Status"
                          >
                            <i style="scale: 1.5;" class="fas fa-toggle-off" status="Inactive"></i>
                          </a>
                        @endif
                      </td>
                      <td>
                        <a 
                          href="javascript:;"
                          class="confirmDelete"
                          record="subscriber"
                          recordid="{{ $subscriber['id'] }}"
                          title="Delete subscriber"
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

@php
  Session::forget('success_message');
@endphp