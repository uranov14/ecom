<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link">
    <img src="{{ asset('images/admin_images/favicon.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Ukrainian Sector</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if (!empty(Auth::guard('admin')->user()->image))
          <img src="{{ asset('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}" class="img-circle elevation-2" alt="User Image">
        @else
          <img src="{{ asset('images/admin_images/admin_photos/no-image.png') }}" class="img-circle elevation-2" alt="User Image">
        @endif
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          @if (Session::get('page') == "dashboard") 
            <?php $active = "active"; ?>
          @else
            <?php $active = ""; ?>
          @endif
          <a href="{{ url('admin/dashboard') }}" class="nav-link {{ $active }}">
            <i class="nav-icon fas fa-solid fa-bullseye"></i>
            <p>Dashboard</p>
          </a>
        </li>
        @if (Session::get('page') == "settings" || Session::get('page') == "update_admin_details") 
          <?php $active = "active"; $open = "menu-open"; ?>
        @else
          <?php $active = ""; $open = ""; ?>
        @endif
        <li class="nav-item {{ $open }}">          
          <a href="#" class="nav-link {{ $active }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              @if (Session::get('page') == "settings") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/settings') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Update Password</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "update_admin_details") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/update-admin-details') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Update Details</p>
              </a>
            </li>
          </ul>
        </li>
        @if (Auth::guard('admin')->user()->type == "superadmin" || Auth::guard('admin')->user()->type == "admin")
          <li class="nav-item">
            @if (Session::get('page') == "admins_subadmins") 
              <?php $active = "active"; ?>
            @else
              <?php $active = ""; ?>
            @endif
            <a href="{{ url('admin/admins-subadmins') }}" class="nav-link {{ $active }}">
              <i class="fas fa-people-arrows nav-icon"></i>
              <p>Admins / Sub-Admins</p>
            </a>
          </li>
        @endif
        {{-- Catalogues --}}
        @if (Session::get('page') == "sections" 
          || Session::get('page') == "categories"
          || Session::get('page') == "products"
          || Session::get('page') == "brands"
          || Session::get('page') == "banners"
          || Session::get('page') == "coupons"
          || Session::get('page') == "orders"
          || Session::get('page') == "shipping_charges"
          || Session::get('page') == "users"
          || Session::get('page') == "cmspages"
          || Session::get('page') == "currencies"
          || Session::get('page') == "ratings"
          || Session::get('page') == "return_requests"
          || Session::get('page') == "exchange_requests"
          || Session::get('page') == "newsletter_subscribers"
        ) 
          <?php $active = "active"; $open = "menu-open"; ?>
        @else
          <?php $active = ""; $open = ""; ?>
        @endif
        <li class="nav-item {{ $open }}">          
          <a href="#" class="nav-link {{ $active }}">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Catalogues
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              @if (Session::get('page') == "banners") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/banners') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Banners</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "sections") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/sections') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Sections</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "brands") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/brands') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Brands</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "categories") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/categories') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "products") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/products') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Products</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "coupons") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/coupons') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Coupons</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "orders") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/orders') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Orders</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "users") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/users') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "cmspages") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/cms-pages') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>CMS Pages</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "shipping_charges") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/view-shipping-charges') }}" class="nav-link {{ $active }}">
                <i class="fas fa-car-side nav-icon"></i>
                <p>Shipping Charges</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "currencies") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/currencies') }}" class="nav-link {{ $active }}">
                <i class="fas fa-dollar-sign nav-icon"></i>
                <p>Currencies</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "ratings") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/ratings') }}" class="nav-link {{ $active }}">
                <i class="far fa-star nav-icon"></i>
                <p>Ratings & Reviews</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "return_requests") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/return-requests') }}" class="nav-link {{ $active }}">
                <i class="fas fa-retweet nav-icon"></i>
                <p>Return Requests</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "exchange_requests") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/exchange-requests') }}" class="nav-link {{ $active }}">
                <i class="fas fa-retweet nav-icon"></i>
                <p>Exchange Requests</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "newsletter_subscribers") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/subscribers') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Newsletter Subscribers</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Catalogues --}}
        @if (Session::get('page') == "update_cod_pincodes" 
          || Session::get('page') == "update_prepaid_pincodes"
        ) 
          <?php $active = "active"; $open = "menu-open"; ?>
        @else
          <?php $active = ""; $open = ""; ?>
        @endif
        <li class="nav-item {{ $open }}">          
          <a href="#" class="nav-link {{ $active }}">
            <i class="nav-icon fas fa-file-import"></i>
            <p>
              Import CSV Pincodes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              @if (Session::get('page') == "update_cod_pincodes") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/update-cod-pincodes') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Update COD Pincodes</p>
              </a>
            </li>
            <li class="nav-item">
              @if (Session::get('page') == "update_prepaid_pincodes") 
                <?php $active = "active"; ?>
              @else
                <?php $active = ""; ?>
              @endif
              <a href="{{ url('admin/update-prepaid-pincodes') }}" class="nav-link {{ $active }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Update Prepaid Pincodes</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>