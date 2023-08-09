<div class="tab-pane" id="listView">
  @foreach ($categoryProducts as $product)
    <div class="row">
      <div class="span2">
        @if (isset($product['main_image']))
          @php
            $product_image_path = "images/product_images/medium/".$product['main_image'];
          @endphp
        @else
          @php
            $product_image_path = "";
          @endphp
        @endif
        @if (!empty($product['main_image']) && file_exists($product_image_path))
          <img src="{{ asset($product_image_path) }}" alt="">
        @else
          <img src="{{ asset('images/product_images/medium/no_image.png') }}" alt="">
        @endif
      </div>
      <div class="span4">
        <h3>{{ $product['brand']['name'] }}</h3>
        <hr class="soft"/>
        <h4>{{ $product['product_name'] }}</h4>
        <p>
          {{ $product['description'] }}
        </p>
        <a class="btn btn-small pull-right" href="{{ url('product/'.$product['id']) }}">View Details</a>
        <br class="clr"/>
      </div>
      <div class="span3 alignR">
        <form class="form-horizontal qtyFrm">
          <h3> {{ $product['product_price'] }} $</h3>
          <label class="checkbox">
            <input type="checkbox">  Adds product to compare
          </label><br/>
          
          <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
          <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>
          
        </form>
      </div>
    </div>
    <hr class="soft"/>
  @endforeach
</div>
<div class="tab-pane  active" id="blockView">
  <ul class="thumbnails">
    @foreach ($categoryProducts as $product)
      <li class="span3">
        <div class="thumbnail">
          <a href="{{ url('product/'.$product['id']) }}">
            @if (isset($product['main_image']))
              @php
                $product_image_path = "images/product_images/medium/".$product['main_image'];
              @endphp
            @else
              @php
                $product_image_path = "";
              @endphp
            @endif
            @if (!empty($product['main_image']) && file_exists($product_image_path))
              <img src="{{ asset($product_image_path) }}" alt="">
            @else
              <img src="{{ asset('images/product_images/medium/no_image.png') }}" alt="">
            @endif
          </a>
          <div class="caption">
            <h5>{{ $product['product_name'] }}</h5>
            <p>
              {{ $product['brand']['name'] }} / {{ $product['fabric'] }}
            </p>
            <?php $discounted_price = App\Models\Product::getDiscountedPrice($product['id']); ?>
            <h4 style="text-align:center">
              {{-- <a class="btn" href="{{ url('product/'.$product['id']) }}"> 
                <i class="icon-zoom-in"></i>
              </a> --}} 
              <a class="btn" href="#">
                Add to <i class="icon-shopping-cart"></i>
              </a> 
              <a class="btn btn-primary" href="#">
                @if ($discounted_price < $product['product_price'])
                  <del>{{ $product['product_price'] }} $</del>
                  <font color="gold">{{ $discounted_price }} $</font>
                @else
                  {{ $product['product_price'] }} $
                @endif
              </a>
              {{-- @if ($discounted_price < $product['product_price'])
                <font color="red">Discounted Price: {{ $discounted_price }} $</font>
              @endif --}}
            </h4>
          </div>
        </div>
      </li>
    @endforeach
  </ul>
  <hr class="soft"/>
</div>