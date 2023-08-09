
<html>
  <body>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td>
            <table align="center" cellpadding="15" cellspacing="0" border="0">
              <tbody>
                <!-- Start header Section -->
                <tr>
                  <td style="padding-top: 30px;">
                    <table align="center" cellpadding="0" cellspacing="0" border="0" style="border-bottom: 1px solid #ccc; text-align: center;">
                      <tbody>
                        <tr>
                          <td style="padding-bottom: 10px;">
                            <img src="{{ url('http://127.0.0.1:8000/images/front_images/favicon.png') }}" alt="Logo" />
                          </td>
                        </tr>
                        <tr>
                          <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                            <strong>Order Number:</strong> {{ $order_id }} | <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($orderDetails['created_at'])->isoFormat('Do MMM YYYY')}}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <!-- End header Section --> 
                <tr>
                  <th>Hello {{ $name }}!</th>
                </tr>
                <tr>
                  <td>
                    Your order #{{ $order_id }} has been successfully placed!!
                  </td>
                </tr>
                <tr>
                  <td>
                    Your order details are as below:
                  </td>
                </tr>                    
                <!-- Start product Section -->
                <tr>
                  <td>
                    <table align="center" cellpadding="5" cellspacing="5" style="border-bottom: 1px solid #ccc;" bgcolor="#eee">
                      <tbody>
                        <tr bgcolor="#ddd">
                          <th>Product Code</th>
                          <th>Product Name</th>
                          <th>Product Size</th>
                          <th>Product Color</th>
                          <th>Product Qty</th>
                          <th>Product Price</th>
                        </tr>
                        @foreach ($orderDetails['order_products'] as $product)
                        @php
                          $image = App\Models\Product::getProductImage($product['product_id']);
                        @endphp
                        <tr>
                          <td>{{ $product['product_code'] }}</td>
                          <td>{{ $product['product_name'] }}</td>
                          <td>{{ $product['product_size'] }}</td>
                          <td>{{ $product['product_color'] }}</td>
                          <td>{{ $product['product_qty'] }}</td>
                          <td>{{ $product['product_price'] }}</td>
                        </tr>
                        @endforeach
                        <tr><td>&nbsp;</td></tr>
                        <tr style="line-height: .8rem;">
                          <td colspan="5" align="right">
                            Shipping Charges:
                          </td>
                          <td>
                            {{ $orderDetails['shipping_charges'] }} $
                          </td>
                        </tr>
                        <tr style="line-height: .8rem;">
                          <td colspan="5" align="right">
                            Coupon Discount:
                          </td>
                          <td>
                            @if (isset($orderDetails['coupon_amount']))
                              {{ $orderDetails['coupon_amount'] }} $
                            @else
                              0 $
                            @endif
                          </td>
                        </tr>
                        <tr style="line-height: .8rem;">
                          <td colspan="5" align="right">
                            <strong>Grand Total:</strong>
                          </td>
                          <td>
                            {{ $orderDetails['grand_total'] }} $
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <!-- End product Section -->
                
                <!-- Start address Section -->
                <tr>
                  <td>
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <strong>Delivery Address:</strong>
                          </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                          <td>Name:</td>
                          <td>{{ $orderDetails['name'] }}</td>
                        </tr>
                        <tr>
                          <td>Address:</td>
                          <td>{{ $orderDetails['address'] }}</td>
                        </tr>
                        <tr>
                          <td>City:</td>
                          <td>{{ $orderDetails['city'] }}</td>
                        </tr>
                        <tr>
                          <td>State:</td>
                          <td>{{ $orderDetails['state'] }}</td>
                        </tr>
                        <tr>
                          <td>Country:</td>
                          <td>{{ $orderDetails['country'] }}</td>
                        </tr>
                        <tr>
                          <td>Pincode:</td>
                          <td>{{ $orderDetails['pincode'] }}</td>
                        </tr>
                        <tr>
                          <td>Mobile:</td>
                          <td>{{ $orderDetails['mobile'] }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <!-- End address Section --> 
                <tr><td>&nbsp;</td></tr>
                <tr>
                  <th>
                    For any enquiries you can contact us at&nbsp; 
                    <a href="mailto:ynovikov14@gmail.com">Ask a Question</a>
                  </th>
                </tr>
                <tr>
                  <th>
                    Regards, <br/>
                    Team Ukrainian Sector
                  </th>
                </tr> 
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>