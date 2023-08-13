@php
  use App\Models\Section;

  $sections = Section::with('categories')->where('status', 1)->get()->toArray();
@endphp

<div id="sidebar" class="span3">
  <div class="well well-small"><a id="myCart" href="{{ url('cart') }}"><img src="{{ asset('public/images/front_images/ico-cart.png') }}" alt="cart"><span class="totalCartItems">{{ totalCartItems() }}</span> Items in your cart</a></div>
  <ul id="sideManu" class="nav nav-tabs nav-stacked">
    @foreach ($sections as $section)
      @if (count($section['categories']) > 0)
        <li class="subMenu"><a>{{ $section['name']  }}</a>
          <ul>
            @foreach ($section['categories'] as $category)
              <li><a href="{{ url($category['url']) }}"><i class="icon-chevron-right"></i><strong>{{ $category['category_name'] }}</strong></a></li>
              <ul>
                @foreach ($category['subcategories'] as $subcategory)
                  <li><a href="{{ url($subcategory['url']) }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subcategory['category_name'] }}</a></li>
                @endforeach
              </ul>
            @endforeach
          </ul>
        </li>
      @endif
    @endforeach
  </ul>
  <br/>
  @if (isset($page_name) && $page_name == "listing" && !isset($_REQUEST['search']))
    <div class="well well-small">
      <h5>Fabric</h5>
      <ul class="nav nav-tabs">
        @foreach ($productFilters['fabricArray'] as $fabric)
          <li>
            <input class="fabric" style="margin-top: -3px;" type="checkbox" name="fabric[]" id="{{ $fabric }}" value="{{ $fabric }}"> 
            <span>{{ $fabric }}</span>
          </li>
          <br/>
        @endforeach
      </ul>
    </div>
    <div class="well well-small">
      <h5>Sleeve</h5>
      <ul class="nav nav-tabs">
        @foreach ($productFilters['sleeveArray'] as $sleeve)
          <li>
            <input class="sleeve" style="margin-top: -3px;" type="checkbox" name="sleeve[]" id="{{ $sleeve }}" value="{{ $sleeve }}"> 
            <span>{{ $sleeve }}</span>
          </li>
          <br/>
        @endforeach
      </ul>
    </div>
    <div class="well well-small">
      <h5>Pattern</h5>
      <ul class="nav nav-tabs">
        @foreach ($productFilters['patternArray'] as $pattern)
          <li>
            <input class="pattern" style="margin-top: -3px;" type="checkbox" name="pattern[]" id="{{ $pattern }}" value="{{ $pattern }}"> 
            <span>{{ $pattern }}</span>
          </li>
          <br/>
        @endforeach
      </ul>
    </div>
    <div class="well well-small">
      <h5>Fit</h5>
      <ul class="nav nav-tabs">
        @foreach ($productFilters['fitArray'] as $fit)
          <li>
            <input class="fit" style="margin-top: -3px;" type="checkbox" name="fit[]" id="{{ $fit }}" value="{{ $fit }}"> 
            <span>{{ $fit }}</span>
          </li>
          <br/>
        @endforeach
      </ul>
    </div>
    <div class="well well-small">
      <h5>Occasion</h5>
      <ul class="nav nav-tabs">
        @foreach ($productFilters['occasionArray'] as $occasion)
          <li>
            <input class="occasion" style="margin-top: -3px;" type="checkbox" name="occasion[]" id="{{ $occasion }}" value="{{ $occasion }}"> 
            <span>{{ $occasion }}</span>
          </li>
          <br/>
        @endforeach
      </ul>
    </div>
  @endif
  <br/>
  <div class="thumbnail">
    <img src="{{ asset('public/images/front_images/payment_methods.png') }}" title="Payment Methods" alt="Payments Methods">
    <div class="caption">
      <h5>Payment Methods</h5>
    </div>
  </div>
</div>