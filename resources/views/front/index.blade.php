@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <div class="well well-small">
    <h4>Featured Products <small class="pull-right">{{ $featuredItemsCount }} featured products</small></h4>
    <div class="row-fluid">
      <div id="featured" @if ($featuredItemsCount > 4) class="carousel slide" @endif>
        <div class="carousel-inner">
          @foreach ($featuredItemsChunk as $key => $featuredItem)
            <div class="item @if ($key == 1)
              active
            @endif">
              <ul class="thumbnails">
                @foreach ($featuredItem as $item)
                  <li class="span3">
                    <div class="thumbnail">
                      <i class="tag"></i>
                      <a href="{{ url('product/'.$item['id']) }}">
                        @php
                          $product_image_path = "images/product_images/small/".$item['main_image'];
                        @endphp
                        @if (!empty($item['main_image']) && file_exists($product_image_path))
                          <img src="{{ asset($product_image_path) }}" alt="">
                        @else
                          <img src="{{ asset('images/product_images/small/no_image.png') }}" alt="">
                        @endif
                      </a>
                      <div class="caption">
                        <?php $discounted_price = App\Models\Product::getDiscountedPrice($item['id']); ?>
                        <h5>{{ $item['product_name'] }}</h5>
                        <h4>
                          <a class="btn" href="{{ url('product/'.$item['id']) }}">VIEW</a> 
                          @if ($discounted_price < $item['product_price'])
                            <del class="pull-right">{{ $item['product_price'] }} $</del>
                            <br/>
                            <font style="line-height: 24px; margin-top: -.7rem;" color="red" class="pull-right">{{ $discounted_price }} $</font>
                          @else
                            <span class="pull-right">{{ $item['product_price'] }} $</span>
                          @endif
                        </h4>
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </div>
        {{-- <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
        <a class="right carousel-control" href="#featured" data-slide="next">›</a> --}}
      </div>
    </div>
  </div>
  <h4>Latest Products </h4>
  <ul class="thumbnails">
    @foreach ($newItems as $item)
      <li class="span3">
        <div class="thumbnail" style="height: 320px;">
          <a  href="{{ url('product/'.$item['id']) }}">
            @php
              $product_image_path = "images/product_images/small/".$item['main_image'];
            @endphp
            @if (!empty($item['main_image']) && file_exists($product_image_path))
              <img width="160" src="{{ asset($product_image_path) }}" alt="">
            @else
              <img width="160" src="{{ asset('images/product_images/small/no_image.png') }}" alt="">
            @endif
          </a>
          <div class="caption">
            <?php $discounted_price = App\Models\Product::getDiscountedPrice($item['id']); ?>
            <h5>{{ $item['product_name'] }}</h5>
            <p>
              {{ $item['product_code'] }} ({{ $item['product_color'] }})
            </p>
            
            <h4 style="text-align:center">
              {{-- <a class="btn" href="{{ url('product/'.$item['id']) }}"> 
                <i class="icon-zoom-in"></i>
              </a>  --}}
              <a class="btn" href="#">
                Add to 
                <i class="icon-shopping-cart"></i>
              </a> 
              <a class="btn btn-primary" href="#">
                @if ($discounted_price < $item['product_price'])
                  <del class="pull-right">{{ $item['product_price'] }} $</del>
                @else
                  <span class="pull-right">{{ $item['product_price'] }} $</span>
                @endif
              </a>
            </h4>
            @if ($discounted_price < $item['product_price'])
            <h5 style="color: red;">
              Discounted Price: {{ $discounted_price }} $
            </h5>
            @endif
          </div>
        </div>
      </li>
    @endforeach
  </ul>
</div>
@endsection