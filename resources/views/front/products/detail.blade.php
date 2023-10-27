@php
  use App\Models\Wishlist;
@endphp

@extends('layouts.front_layouts.front_layout')

@section('content')
<div class="span9">
  <ul class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
    <li><a href="{{ url('/'.$productDetails['category']['url']) }}">{{ $productDetails['category']['category_name'] }}</a> <span class="divider">/</span></li>
    <li class="active">{{ $productDetails['product_name'] }}</li>
  </ul>
  <div class="row">
    <div id="gallery" class="span4">
      <a href="{{ asset('images/product_images/medium/'.$productDetails['main_image']) }}" title="{{ $productDetails['product_name'] }}">
        <img src="{{ asset('images/product_images/large/'.$productDetails['main_image']) }}" style="width:100%" alt="{{ $productDetails['product_name'] }}"/>
      </a>
      <br/><br/>
      <div id="differentview" class="moreOptopm carousel slide">
        <div class="carousel-inner">
          <div class="item active">
            @foreach ($productDetails['images'] as $image)
              <a href="{{ asset('images/product_images/large/'.$image['image']) }}"> 
                <img width="50" style="max-height: 50px;" src="{{ asset('images/product_images/large/'.$image['image']) }}" alt=""/>
              </a>
            @endforeach
          </div>
        </div>
        <!--
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
        -->
      </div>
      
      <div class="btn-toolbar">
        <div class="btn-group">
          <span class="btn"><i class="icon-envelope"></i></span>
          <span class="btn" ><i class="icon-print"></i></span>
          <span class="btn" ><i class="icon-zoom-in"></i></span>
          <span class="btn" ><i class="icon-star"></i></span>
          <span class="btn" ><i class=" icon-thumbs-up"></i></span>
          <span class="btn" ><i class="icon-thumbs-down"></i></span>
        </div>
      </div>
    </div>
    <div class="span5">
      @if (Session::has('success_message'))
        <div class="alert alert-success" role="alert">
          <strong>Success: </strong>{{ Session::get('success_message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php Session::forget('success_message') ?>
      @endif
      @if (Session::has('error_message'))
        <div class="alert alert-danger" role="alert">
          {{ Session::get('error_message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php Session::forget('error_message') ?>
      @endif
      <h3>{{ $productDetails['product_name'] }}</h3>
      <div>
        <?php
          $star = 1;
          while ($star <= $avgStarRating) {
        ?>
          <span style="color: gold; font-size: 17px;">&#9733;</span>
        <?php
            $star++;
          }
        ?> ({{ $averageRating }})
      </div>
      <small>Brand: {{ $productDetails['brand']['name'] }}</small>
      <small style="float: right;">{{ $total_stock }} items in stock</small>
      
      <hr class="soft"/>

      @if (count($groupProducts) > 0)
        <div>
          <strong>More Colors</strong>
          <div style="margin: 10px 0;">
            @foreach ($groupProducts as $product)
            <a href="{{ url('product/'.$product['id']) }}">
              <img width="50" src="{{ asset('images/product_images/small/'.$product['main_image']) }}" alt="">
            </a>
            @endforeach
          </div>
        </div>
      @endif

      <form action="{{ url('add-to-cart') }}" method="POST" class="form-horizontal qtyFrm">@csrf
        <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
        <div class="control-group">
          <?php $discounted_price = App\Models\Product::getDiscountedPrice($productDetails['id']); ?>
          <h4 class="attrPrice">
            @if ($discounted_price < $productDetails['product_price'])
              <del>{{ $productDetails['product_price'] }}  <small>&#x20b4;</small></del>
              &nbsp;
              {{ $discounted_price }}  <small>&#x20b4;</small>
            @else
              {{ $productDetails['product_price'] }}  <small>&#x20b4;</small>
            @endif
          </h4>
          <span class="mainCurrencyPrices">
            @foreach ($currencies as $currency)
              {{ $currency['currency_code'] }} -
              @php
                echo round($productDetails['product_price'] / $currency['exchange_rate'], 2);
              @endphp
              <br>
            @endforeach
          </span>
          <br>
          <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}" class="span2 pull-left">
            <option value="">Select Size</option>
            @foreach ($productDetails['attributes'] as $attribute)
              <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
            @endforeach
          </select>
          &nbsp;&nbsp;
          <input type="number" name="quantity" class="span1" placeholder="Qty."/>
          <br><br>
          <button type="submit" class="btn btn-large btn-primary btn-space"> Add to cart <i class=" icon-shopping-cart"></i></button>
          @php
            $countWishlist = Wishlist::countWishlist($productDetails['id']);
          @endphp
          @if (Auth::check())
            <button type="button" id="updateWishlist" class="btn btn-large btn-primary btn-space" data-productid="{{ $productDetails['id'] }}">
              Wishlist 
              @if ($countWishlist > 0)
                <i class="icon-heart" style="color: red;" title="Product in Wishlist"></i>
              @else
                <i class="icon-heart-empty" title="Not Product in Wishlist"></i>
              @endif
            </button>
            <span id="actWishlist"></span>
          @else
            <button type="button" class="btn btn-large btn-primary btn-space btn-wishlist-not-login">
              Wishlist <i class="icon-heart-empty"></i>
            </button>
          @endif
          
          <br><br>
          <strong>Delivery</strong>
          <input type="text" class="span2" name="pincode" id="pincode" placeholder="Check pincode">
          <button type="button" id="checkPincode">Go</button>
        </div>
        <div class="sharethis-sticky-share-buttons"></div>
      </form>
    
      <hr class="soft clr"/>
      <p>
        <?php echo $productDetails['description'] ?>
      </p>
      <a class="btn btn-small pull-right" href="#detail">More Details</a>
      <br class="clr"/>
      <a href="#" name="detail"></a>
      <hr class="soft"/>
    </div>
    
    <div class="span9">
      <ul id="productDetail" class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
        <li><a href="#profile" data-toggle="tab">Related Products</a></li>
        @if (isset($productDetails['product_video']) && !empty($productDetails['product_video']))
          <li><a href="#video" data-toggle="tab">Product Video</a></li>
        @endif
        <li><a href="#ratings" data-toggle="tab">Ratings & Reviews</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="home">
          <h4>Product Information</h4>
          <table class="table table-bordered">
            <tbody>
              <tr class="techSpecRow"><th colspan="2">Product Details</th></tr>
              <tr class="techSpecRow"><td class="techSpecTD1">Brand: </td><td class="techSpecTD2">{{ $productDetails['brand']['name'] }}</td></tr>
              <tr class="techSpecRow"><td class="techSpecTD1">Code:</td><td class="techSpecTD2">{{ $productDetails['product_code'] }}</td></tr>
              <tr class="techSpecRow"><td class="techSpecTD1">Color:</td><td class="techSpecTD2">{{ $productDetails['product_color'] }}</td></tr>
              @if ($productDetails['fabric'])
                <tr class="techSpecRow"><td class="techSpecTD1">Fabric:</td><td class="techSpecTD2">{{ $productDetails['fabric'] }}</td></tr>
              @endif
              @if ($productDetails['pattern'])
                <tr class="techSpecRow"><td class="techSpecTD1">Pattern:</td><td class="techSpecTD2">{{ $productDetails['pattern'] }}</td></tr>
              @endif
              @if ($productDetails['sleeve'])
                <tr class="techSpecRow"><td class="techSpecTD1">Sleeve:</td><td class="techSpecTD2">{{ $productDetails['sleeve'] }}</td></tr>
              @endif
              @if ($productDetails['fit'])
                <tr class="techSpecRow"><td class="techSpecTD1">Fit:</td><td class="techSpecTD2">{{ $productDetails['fit'] }}</td></tr>
              @endif
              @if ($productDetails['occasion'])
                <tr class="techSpecRow"><td class="techSpecTD1">Occasion:</td><td class="techSpecTD2">{{ $productDetails['occasion'] }}</td></tr>
              @endif
            </tbody>
          </table>
          
          <h5>Washcare</h5>
          <p><?php echo $productDetails['wash_care'] ?></p>
          <h5>Disclaimer</h5>
          <p>
            There may be a slight color variation between the image shown and original product.
          </p>
        </div>
        <div class="tab-pane fade" id="profile">
          <div id="myTab" class="pull-right">
            <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
            <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
          </div>
          <br class="clr"/>
          <hr class="soft"/>
          <div class="tab-content">
            <div class="tab-pane" id="listView">
              @foreach ($relatedProducts as $product)
                <div class="row">
                  <div class="span2">
                    @if (isset($product['main_image']))
                      @php
                        $product_image_path = "images/product_images/small/".$product['main_image'];
                      @endphp
                    @else
                      @php
                        $product_image_path = "";
                      @endphp
                    @endif
                    @if (!empty($product['main_image']) && file_exists($product_image_path))
                      <img src="{{ asset($product_image_path) }}" alt="">
                    @else
                      <img src="{{ asset('images/product_images/small/no_image.png') }}" alt="">
                    @endif
                  </div>
                  <div class="span4">
                    <h3>{{ $product['product_name'] }}</h3>
                    <hr class="soft"/>
                    <h5>{{ $product['brand']['name'] }} / {{ $product['product_code'] }}</h5>
                    <p>
                      {{ $product['description'] }}
                    </p>
                    <a class="btn btn-small pull-right" href="{{ url('product/'.$product['id']) }}">View Details</a>
                    <br class="clr"/>
                  </div>
                  <div class="span3 alignR">
                    <form class="form-horizontal qtyFrm">
                      <h3>{{ $product['product_price'] }}</h3>
                      <label class="checkbox">
                        <input type="checkbox">  Adds product to compare
                      </label><br/>
                      <div class="btn-group">
                        <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
                        <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>
                      </div>
                    </form>
                  </div>
                </div>
                <hr class="soft"/>
              @endforeach
            </div>
            <div class="tab-pane active" id="blockView">
              <ul class="thumbnails">
                @foreach ($relatedProducts as $product)
                  <li class="span3">
                    <div class="thumbnail">
                      <a href="{{ url('product/'.$product['id']) }}">
                        @if (isset($product['main_image']))
                          @php
                            $product_image_path = "images/product_images/small/".$product['main_image'];
                          @endphp
                        @else
                          @php
                            $product_image_path = "";
                          @endphp
                        @endif
                        @if (!empty($product['main_image']) && file_exists($product_image_path))
                          <img src="{{ asset($product_image_path) }}" alt="">
                        @else
                          <img src="{{ asset('images/product_images/small/no_image.png') }}" alt="">
                        @endif
                      </a>
                      <div class="caption">
                        <h5>{{ $product['product_name'] }}</h5>
                        <p>
                          {{ $product['brand']['name'] }} / {{ $product['product_code'] }}
                        </p>
                        <h4 style="text-align:center">
                          <a class="btn" href="{{ url('product/'.$product['id']) }}"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">{{ $product['product_price'] }} $</a>
                        </h4>
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
              <hr class="soft"/>
            </div>
          </div>
          <br class="clr">
        </div>
        @if($productDetails['product_video'] != null)
          <div class="tab-pane fade" id="video">
            <video controls width="640" height="480">
              <source src="{{ url('videos/product_videos/'.$productDetails['product_video']) }}">
            </video>
          </div>
        @endif
        <div class="tab-pane fade" id="ratings">
          <div class="row">
            <div class="span4">
              <h4>Write a Review</h4>
              <form action="{{ url('/add-rating') }}" method="POST" name="formRating" id="formRating" class="form-horizontal">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                <div class="rate">
                  <span>Rate Product &nbsp;</span>
                  <input type="radio" id="star5" name="rating" value="5" />
                  <label for="star5" title="text">5 stars</label>
                  <input type="radio" id="star4" name="rating" value="4" />
                  <label for="star4" title="text">4 stars</label>
                  <input type="radio" id="star3" name="rating" value="3" />
                  <label for="star3" title="text">3 stars</label>
                  <input type="radio" id="star2" name="rating" value="2" />
                  <label for="star2" title="text">2 stars</label>
                  <input type="radio" id="star1" name="rating" value="1" />
                  <label for="star1" title="text">1 star</label>
                </div>
                <br>
                <div class="form-group">
                  <label for="review" class="control-label alignL">Your Review *</label>
                  <textarea name="review" id="review" class="span4" rows="3" required></textarea>
                </div>
                <br>
                <div class="form-group">
                  <button type="submit" class="btn btn-large" name="Submit">Submit</button>
                </div>
              </form>
            </div>
            <div class="span4">
              <h4>Users Reviews</h4>
              @if (count($ratings) > 0)
              @foreach ($ratings as $rating)
                <div>
                  <p>
                    By <b>{{ $rating['user']['name'] }}</b>
                    <?php
                      $star = 1;
                      while ($star <= $rating['rating']) {
                    ?>
                      <span style="color: gold; font-size: 17px;">&#9733;</span>
                    <?php
                        $star++;
                      }
                    ?>
                  </p>
                  <p>{{ $rating['review'] }}</p>
                  <p>{{ date("d-m-Y H:i", strtotime($rating['created_at'])) }}</p>
                  <hr>
                </div>
              @endforeach
              @else
                <p><b>Reviews are not available for this Product</b></p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection