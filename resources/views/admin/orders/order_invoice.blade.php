<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
  .invoice-title h2, .invoice-title h3 {
    display: inline-block;
  }

  .table > tbody > tr > .no-line {
    border-top: none;
  }

  .table > thead > tr > .no-line {
    border-bottom: none;
  }

  .table > tbody > tr > .thick-line {
    border-top: 2px solid;
  }
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2>
          <h3 class="pull-right">Order # {{ $orderDetails['id'] }}</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-4">
    				<address>
    				  <strong>Billed To:</strong><br>
              {{ $userDetails['name'] }}<br>
              @if (!empty($userDetails['address']))
                {{ $userDetails['address'] }},&nbsp;
              @endif
              @if (!empty($userDetails['city']))
                {{ $userDetails['city'] }},&nbsp;
              @endif
              @if (!empty($userDetails['state']))
                {{ $userDetails['state'] }}
              @endif
              <br>
              @if (!empty($userDetails['country']))
                {{ $userDetails['country'] }}
              @endif
              @if (!empty($userDetails['pincode']))
                ({{ $userDetails['pincode'] }})
              @endif
              <br>
              {{ $userDetails['mobile'] }}
    				</address>
    			</div>
          <div class="col-xs-4">
            <span>
              <?php echo DNS2D::getBarcodeHTML(strval($orderDetails['id']), 'QRCODE'); ?>
            </span>
          </div>
    			<div class="col-xs-4 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
    					{{ $orderDetails['name'] }}<br>
              {{ $orderDetails['address'] }}, {{ $orderDetails['city'] }}, {{ $orderDetails['state'] }}<br>
              {{ $orderDetails['country'] }} ({{ $orderDetails['pincode'] }})<br>
              {{ $orderDetails['mobile'] }}
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{ $orderDetails['payment_method'] }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ date('j F, Y', strtotime($orderDetails['created_at'])) }}
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                  <tr>
                    <td><strong>Item</strong></td>
                    <td class="text-center"><strong>Price</strong></td>
                    <td class="text-center"><strong>Quantity</strong></td>
                    <td class="text-right"><strong>Totals</strong></td>
                  </tr>
    						</thead>
    						<tbody>
                  <?php $subTotal = 0; ?>
    							@foreach ($orderDetails['order_products'] as $product)
                    <tr>
                      <td>
                        Name: {{ $product['product_name'] }}<br>
                        Code: {{ $product['product_code'] }}<br>
                        Size: {{ $product['product_size'] }}<br>
                        Color: {{ $product['product_color'] }}
                        <?php echo DNS1D::getBarcodeHTML($product['product_code'], 'C39'); ?>
                      </td>
                      <td class="text-center">${{ $product['product_price'] }}</td>
                      <td class="text-center">{{ $product['product_qty'] }}</td>
                      <td class="text-right">${{ $product['product_price'] * $product['product_qty'] }}</td>
                    </tr>
                    <?php $subTotal += $product['product_price'] * $product['product_qty']; ?>
                  @endforeach            
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-right"><strong>Sub Total:</strong></td>
    								<td class="thick-line text-right">${{ $subTotal }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Shipping Charges:</strong></td>
    								<td class="no-line text-right">${{ $orderDetails['shipping_charges'] }}</td>
    							</tr>
                  <tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>GST Charges:</strong></td>
    								<td class="no-line text-right">${{ $orderDetails['gst_charges'] }}</td>
    							</tr>
                  @if ($orderDetails['coupon_amount'] > 0)
                    <tr>
                      <td class="no-line"></td>
                      <td class="no-line"></td>
                      <td class="no-line text-right"><strong>Discount:</strong></td>
                      <td class="no-line text-right">${{ $orderDetails['coupon_amount'] }}</td>
                    </tr>
                  @endif
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Grand Total:</strong></td>
    								<td class="no-line text-right">${{ $orderDetails['grand_total'] }}</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>