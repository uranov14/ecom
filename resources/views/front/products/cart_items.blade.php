@php
  use App\Models\Product;
@endphp
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Product</th>
      <th colspan="2">Description</th>
      <th>Quantity/Update</th>
      <th>Price</th>
      <th>Discount</th>
      <th>Sub Total</th>
    </tr>
  </thead>
  <tbody>
    <?php $total_price = 0; ?>
    @foreach ($getCartItems as $item)
    @php
      $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
    @endphp
      <tr>
        <td>
          <img width="60" src="{{ asset('images/product_images/small/'.$item['product']['main_image']) }}" alt=""/>
        </td>
        <td colspan="2">
          {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br/>
          Color : {{ $item['product']['product_color'] }}<br/>
          Size : {{ $item['size'] }}
        </td>
        <td>
          <div class="input-append">
            <input class="span1" style="max-width:34px" value="{{ $item['quantity'] }}" id="{{ $item['id'] }}" size="16" type="text">
            <button class="btn btnQuantityUpdate qtyMinus" data-cartid="{{ $item['id'] }}" type="button">
              <i class="icon-minus"></i>
            </button>
            <button class="btn btnQuantityUpdate qtyPlus" data-cartid="{{ $item['id'] }}" type="button">
              <i class="icon-plus"></i>
            </button>
            <button class="btn btn-danger btnItemDelete" data-cartid="{{ $item['id'] }}" type="button">
              <i class="icon-remove icon-white"></i>
            </button>				
          </div>
        </td>
        <td>{{ $attrPrice['product_price'] * $item['quantity'] }} $</td>
        <td>{{ $attrPrice['discount'] * $item['quantity'] }} $</td>
        <td>{{ $attrPrice['final_price'] * $item['quantity'] }} $</td>
      </tr>
      <?php $total_price += $attrPrice['final_price'] * $item['quantity']; ?>
    @endforeach
    <tr>
      <td colspan="6" style="text-align:right">Sub Total Price 	</td>
      <td>{{ $total_price }} $</td>
    </tr>
    <tr>
      <td colspan="6" style="text-align:right">Coupon Discount 	</td>
      <td class="couponAmount">
        @if (Session::has('couponAmount'))
          {{ Session::get('couponAmount') }} $
        @else
          0 $
        @endif
      </td>
    </tr>
    <tr>
      <td colspan="6" style="text-align:right"><strong>GRAND TOTAL ({{ $total_price }} $ - <span class="couponAmount">0 $</span>) </strong></td>
      <td class="label label-important" style="display:block"> <strong class="grand_total">{{ $total_price }} $</strong></td>
    </tr>
  </tbody>
</table>