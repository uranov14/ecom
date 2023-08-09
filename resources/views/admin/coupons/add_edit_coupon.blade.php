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
            <li class="breadcrumb-item active">Coupons</li>
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
          <h4 class="text-center text-bold">
            {{ $title }}
            @if (isset($coupon))
              {{ $coupon['coupon_code'] }}
            @endif
          </h4>
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
        
        <form name="couponForm" id="couponForm" 
          @if (empty($coupon->id))
            action="{{ url('admin/add-edit-coupon') }}"
          @else
            action="{{ url('admin/add-edit-coupon/'.$coupon->id) }}"    
          @endif 
          method="POST" enctype="multipart/form-data"
        >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                @if (empty($coupon['coupon_code']))
                  <div class="form-group">
                    <label for="coupon_option">Coupon Option</label>
                    <br/>
                    <span>
                      <input type="radio" 
                        name="coupon_option" 
                        id="AutomaticCoupon"
                        value="Automatic" 
                        checked
                      >
                      Automatic
                    </span>
                    <br/>
                    <span>
                      <input type="radio" 
                        name="coupon_option" 
                        id="ManualCoupon"
                        value="Manual" 
                      >
                      Manual
                    </span>
                  </div>
                  <div class="form-group" id="couponCode" style="display: none;">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" class="form-control" 
                      name="coupon_code" id="coupon_code" 
                      placeholder="Enter Coupon Code" 
                    >
                  </div>
                @else
                  <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                  <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                  <div class="form-group">
                    <label for="coupon_code">Coupon Code</label>
                    <span>{{ $coupon['coupon_code'] }}</span>
                  </div>
                @endif
                <div class="form-group">
                  <label for="coupon_type">Coupon Type</label>
                  <br/>
                  <span>
                    <input type="radio" 
                      name="coupon_type"
                      value="Multiple Times" 
                      @if ($coupon['coupon_type'] == "Multiple Times" || empty($coupon['coupon_type'])
                        checked    
                      @endif
                    >
                    Multiple Times
                  </span>
                  <br/>
                  <span>
                    <input type="radio" 
                      name="coupon_type"
                      value="Single Time"
                      @if ($coupon['coupon_type'] == "Single Time")
                        checked    
                      @endif 
                    >
                    Single Time
                  </span>
                </div>
                <div class="form-group">
                  <label for="amount_type">Amount Type</label>
                  <br/>
                  <span>
                    <input type="radio" 
                      name="amount_type"
                      value="Percentage" 
                      @if ($coupon['amount_type'] == "Percentage" || empty($coupon['amount_type']))
                        checked    
                      @endif
                    >
                    Percentage (in %)
                  </span>
                  <br/>
                  <span>
                    <input type="radio" 
                      name="amount_type"
                      value="Fixed" 
                      @if ($coupon['amount_type'] == "Fixed")
                        checked    
                      @endif
                    >
                    Fixed (in USD)
                  </span>
                </div>
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input type="number" class="form-control" 
                    name="amount" id="amount" 
                    placeholder="Enter Amount"
                    @if (!empty($coupon['amount']))
                      value="{{ $coupon['amount'] }}"
                    @else
                      value="{{ old('amount') }}"    
                    @endif 
                    required
                  >
                </div>
                <div class="form-group">
                  <label>Select Categories</label>
                  <select name="categories[]" class="form-control select2" multiple required>
                    <option value="">Select</option>
                    @foreach ($categories as $section)
                      <optgroup label="{{ $section['name'] }}"></optgroup>
                      
                      @foreach ($section['categories'] as $category)
                        @php
                          $valParentCat = array($category['id']);
                          foreach ($category['subcategories'] as $subcategory) {
                            array_push($valParentCat, $subcategory['id']);
                          }
                        @endphp
                        <option value="{{ join(",", $valParentCat) }}" 
                          @if (in_array($category['id'], $selectCats))
                            selected
                          @endif
                        >
                          &nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}
                        </option>
                        @foreach ($category['subcategories'] as $subcategory)
                          <option value="{{ $subcategory['id'] }}" 
                            @if (in_array($subcategory['id'], $selectCats))
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
                  <label>Select Users</label>
                  <select name="users[]" class="form-control select2" multiple data-live-search="true">
                    <option value="">Select</option>
                    @foreach ($users as $user)
                      <option value="{{ $user['email'] }}"
                        @if (in_array($user['email'], $selectUsers))
                          selected
                        @endif
                      >
                        {{ $user['email'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="expiry_date">Expiry Date</label>
                  <input type="text" class="form-control" 
                    name="expiry_date" id="expiry_date" 
                    placeholder="Enter Expiry Date"
                    @if (!empty($coupon['expiry_date']))
                      value="{{ $coupon['expiry_date'] }}"
                    @else
                      value="{{ old('expiry_date') }}"    
                    @endif 
                    data-inputmask-alias="datetime" 
                    data-inputmask-inputformat="yyyy/mm/dd" 
                    data-mask
                    required
                  >
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