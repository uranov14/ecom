@php
  use App\Models\Product;
@endphp
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Product</th>
      <th colspan="2">Description</th>
      <th>View/Delete</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($userWishlist as $item)
      <tr>
        <td>
          <img width="60" src="{{ asset('images/product_images/small/'.$item['product']['main_image']) }}" alt=""/>
        </td>
        <td colspan="2">
          {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br/>
          Color : {{ $item['product']['product_color'] }}
        </td>
        <td>
          <div class="input-append" style="display:flex; justify-content:center;">
            <a target="_blank" href="{{ url('product/'.$item['product']['id']) }}">
              <button class="btn" type="button">
                <i class="icon-file" style="scale: 1.5;"></i>
              </button>
            </a>
            <button class="btn btn-danger btnWishlistItemDelete" data-wishlistid="{{ $item['id'] }}" type="button">
              <i class="icon-remove icon-white"></i>
            </button>				
          </div>
        </td>
        <td>{{ $item['product']['product_price'] }} <small>&#x20b4;</small></td>
      </tr>
    @endforeach
  </tbody>
</table>