$(document).ready(function() {
  $(".productSizes").hide();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $("#sort").change(function() {
    var sort = $(this).val();
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occasion = get_filter('occasion');
    var url = $('#url').val();

    $.ajax({
      url: url,
      method: "post",
      data: {sort: sort, fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, url: url},
      success: function(data) {
        $(".filter-products").html(data);
      }
    })
  });

  $(".fabric").click(function() {
    var fabric = get_filter(this);
    var sleeve = get_filter('sleeve');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occasion = get_filter('occasion');
    var sort = $("#sort option:selected").val();
    var url = $('#url').val();

    $.ajax({
      url: url,
      method: "post",
      data: {fabric: fabric, sleeve: sleeve, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url},
      success: function(data) {
        $(".filter-products").html(data);
      }
    })
  });

  $(".sleeve").click(function() {
    var sleeve = get_filter(this);
    var fabric = get_filter('fabric');
    var pattern = get_filter('pattern');
    var fit = get_filter('fit');
    var occasion = get_filter('occasion');
    var sort = $("#sort option:selected").val();
    var url = $('#url').val();

    $.ajax({
      url: url,
      method: "post",
      data: {sleeve: sleeve, fabric: fabric, pattern: pattern, fit: fit, occasion: occasion, sort: sort, url: url},
      success: function(data) {
        $(".filter-products").html(data);
      }
    })
  });

  $(".pattern").click(function() {
    var pattern = get_filter(this);
    var fabric = get_filter('fabric');
    var sleeve = get_filter('sleeve');
    var fit = get_filter('fit');
    var occasion = get_filter('occasion');
    var sort = $("#sort option:selected").val();
    var url = $('#url').val();

    $.ajax({
      url: url,
      method: "post",
      data: {pattern: pattern, fabric: fabric, sleeve: sleeve, fit: fit, occasion: occasion, sort: sort, url: url},
      success: function(data) {
        $(".filter-products").html(data);
      }
    })
  });

  $(".fit").click(function() {
    var fit = get_filter(this);
    var fabric = get_filter('fabric');
    var pattern = get_filter('pattern');
    var sleeve = get_filter('sleeve');
    var occasion = get_filter('occasion');
    var sort = $("#sort option:selected").val();
    var url = $('#url').val();

    $.ajax({
      url: url,
      method: "post",
      data: {fit: fit, fabric: fabric, pattern: pattern, sleeve: sleeve, occasion: occasion, sort: sort, url: url},
      success: function(data) {
        $(".filter-products").html(data);
      }
    })
  });

  $(".occasion").click(function() {
    var occasion = get_filter(this);
    var fabric = get_filter('fabric');
    var pattern = get_filter('pattern');
    var sleeve = get_filter('sleeve');
    var fit = get_filter(this);
    var sort = $("#sort option:selected").val();
    var url = $('#url').val();

    $.ajax({
      url: url,
      method: "post",
      data: {occasion: occasion, fabric: fabric, pattern: pattern, fit: fit, sleeve: sleeve, sort: sort, url: url},
      success: function(data) {
        $(".filter-products").html(data);
      }
    })
  });

  function get_filter(class_name) {
    var filter = [];
    $('.'+class_name+':checked').each(function() {
      filter.push($(this).val());
    });

    return filter;
  }

  $("#getPrice").change(function() {
    var size = $(this).val();
    if(size == "") {
      alert("Please select Size");
      return false;
    }
    var product_id = $(this).attr('product-id');

    $.ajax({
      url: '/get-product-price',
      type: "post",
      data: {size: size, product_id: product_id},
      success: function(resp) {
        $(".mainCurrencyPrices").hide();
        if(resp['final_price'] < resp['product_price']) {
          $(".attrPrice").html("<del>"+resp['product_price']+" <small>&#x20b4;</small></del>&nbsp;&nbsp;&nbsp;"+resp['final_price']+" <small>&#x20b4;</small><br/>"+resp['currency']);
        } else{
          $(".attrPrice").html(resp['product_price']+" <small>&#x20b4;</small><br/>"+resp['currency']);
        }
      },error: function() {
        alert("Error with add price of the size");
      }
    })
  });

  //Update Quantity Cart Items
  $(document).on("click", ".btnQuantityUpdate", function() {
    if($(this).hasClass('qtyMinus')) {
      var quantity = $(this).prev().val();
      if (quantity <= 1) {
        alert("You can`t reduce the Item Quantity less then 1!");
        return false;
      } else{
        new_qty = parseInt(quantity) - 1;
      }    
    } else if($(this).hasClass('qtyPlus')) {
      var quantity = $(this).prev().prev().val(); 
      new_qty = parseInt(quantity) + 1;
    }
    //alert(new_qty);
    var cartid = $(this).data('cartid');
    //alert(cartid);
    $.ajax({
      url: '/update-cart-item-qty',
      type: "post",
      data: {"cartid": cartid, "qty": new_qty},
      success: function(resp) {
        if(!resp.status) {
          alert(resp.message);
        } 
        $(".totalCartItems").html(resp.totalCartItems);
        $("#appendCartItems").html(resp.view);
        $(".couponAmount").html("0 $");
      },error: function() {
        alert("Error with Update Cart Item Quantity");
      }
    })
  });

  // Delete Cart Item
	$(document).on('click','.btnItemDelete',function(){
		var cartid = $(this).data('cartid');
		var result = confirm("Are you sure to delete this Cart Item?");
		if (result) {
			$.ajax({
				data:{cartid:cartid}, 
				url:'/delete-cart-item',
				type:'post',
				success:function(resp){
          $(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
				},error:function(){
					alert("Error with delete Cart Item");
				}
			});
		}
	});

  // Delete Wishlist Item
	$(document).on('click','.btnWishlistItemDelete',function(){
		var wishlistid = $(this).data('wishlistid');
    //alert(wishlistid);
		var result = confirm("Are you sure to delete this Wishlist Item?");
		if (result) {
			$.ajax({
				data:{wishlistid:wishlistid}, 
				url:'/delete-wishlist-item',
				type:'post',
				success:function(resp){
          $(".totalWishlistItems").html(resp.totalWishlistItems);
					$("#appendWishlistItems").html(resp.view);
				},error:function(){
					alert("Error with delete Wishlist Item");
				}
			});
		}
	});

  // Cancel Order
	$(document).on('click','.btnCancelOrder',function(){
		var reason = $("#cancelReason").val();
    if (reason == "") {
      alert('Please Select Reason for Cancelling this Order.');
      return false;
    }
		var result = confirm("Are you sure to cancel this Order?");
    if (!result) {
      return false;
    }
	});

  $("#returnExchange").change(function () {
    var return_exchange = $(this).val();
    if (return_exchange == "Exchange") {
      $(".productSizes").show();
    } else {
      $(".productSizes").hide();
    }
  });
  $("#returnProduct").change(function () {
    var product_info = $(this).val();
    var return_exchange = $("#returnExchange").val();
    if (return_exchange == "Exchange") {
      $.ajax({
        data:{product_info: product_info}, 
        url:'/get-product-sizes',
        type:'post',
        success:function(resp){
          $('#productSizes').html(resp);
        },error:function(){
          alert("Error with Return Exchange Product in Order");
        }
      });
    }
  });
  // Return Order
	$(document).on('click','.btnReturnOrder',function(){
    var return_exchange = $("#returnExchange").val();
    if (return_exchange == "") {
      alert('Please select return or exchange option.');
      return false;
    }
    var product = $("#returnProduct").val();
    if (product == "") {
      alert('Please Select Product for Returning this Order.');
      return false;
    }
		var reason = $("#returnReason").val();
    if (reason == "") {
      alert('Please Select Reason for Returning this Order.');
      return false;
    }
		var result = confirm("Are you sure to Return/Exchange this Order?");
    if (!result) {
      return false;
    }
	});

  // validate register form on keyup and submit
  $("#registerForm").validate({
    rules: {
      name: "required",
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true
      },
      email: {
        required: true,
        email: true,
        remote: "check-email"
      },
      password: {
        required: true,
        minlength: 6
      }
    },
    messages: {
      name: "Please enter your Name",
      mobile: {
        required: "Please enter your Mobile",
        minlength: "Your mobile must consist of at least 10 digits",
        maxlength: "Your mobile must consist of 10 digits",
        digits: "Please enter your valid Mobile Nimber"
      },
      email: {
        required: "Please enter a valid Email",
        email: "Please enter a valid email address",
        remote: "Email is already exists"
      },
      password: {
        required: "Please choose your Password",
        minlength: "Your password must be at least 6 characters long"
      }
    }
  });

  // validate login form on keyup and submit
  $("#loginForm").validate({
    rules: {
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 6
      }
    },
    messages: {
      email: {
        required: "Please enter a valid Email",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please enter your Password",
        minlength: "Your Password must be at least 6 characters long"
      }
    }
  });

  // validate account form on keyup and submit
  $("#accountForm").validate({
    rules: {
      name: "required",
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true
      }
    },
    messages: {
      name: "Please enter your Name",
      mobile: {
        required: "Please enter your Mobile",
        minlength: "Your mobile must consist of at least 10 digits",
        maxlength: "Your mobile must consist of 10 digits",
        digits: "Please enter your valid Mobile Nimber"
      }
    }
  });

  //Check User Current Password
  $("#current_pwd").keyup(function() {
    let current_pwd = $(this).val();

    $.ajax({
      data:{current_pwd: current_pwd}, 
      url:'/check-user-pwd',
      type:'post',
      success:function(resp){
        if(!resp) {
          $('#check_pwd').html("<font color='red'>Current Password is Incorrect</font>");
        } else {
          $('#check_pwd').html("<font color='green'>Current Password is Correct</font>");
        }
      },error:function(){
        alert("Error with Check User Current Password");
      }
    });
  });

  // validate password
  $("#passwordForm").validate({
    rules: {
      current_pwd: {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      new_pwd: {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      confirm_pwd: {
        required: true,
        minlength: 6,
        maxlength: 20,
        equalTo: "#new_pwd"
      }
    }
  });

  //Apply Coupon
	$("#ApplyCoupon").submit(function() {
		var user = $(this).attr("user");
		if(user == '1') {
			//do nothing
		} else {
			alert("Please login to apply Coupon!");
			return false;
		}
		var code = $("#code").val();
		$.ajax({
			url:'/apply-coupon',
			type:'post',
			data:{code: code},
			success:function(resp){
				if (resp.message != "") {
					alert(resp.message);
				}
        $(".totalCartItems").html(resp.totalCartItems);
				$("#appendCartItems").html(resp.view);
        if(resp.couponAmount > 0) {
          $(".couponAmount").text(resp.couponAmount+" $");
        } else {
          $(".couponAmount").text("0 $");
        }
        if(resp.grand_total > 0) {
          $(".grand_total").text(resp.grand_total+" $");
        }
			},error:function(){
				alert("Error with Apply Coupon");
			}
		});
	});

  // Delete Delivery Address
  $(".addressDelete").click(function() {
    var result = confirm("Want to delete this Address?");
    if(!result) {
      return false;
    }
  });

  //Calculate Grand Total
	$("input[name=address_id]").bind('change', function() {
		var shipping_charges = $(this).attr('shipping_charges');
		//alert(shipping_charges);
    var total_price = $(this).attr('total_price');
    var total_GST = $(this).attr('total_GST');
		var coupon_amount = $(this).attr('coupon_amount');
		var codpincodeCount = $(this).attr('codpincodeCount');
		var prepaidpincodeCount = $(this).attr('prepaidpincodeCount');
		if(codpincodeCount == 0 && prepaidpincodeCount == 0) {
			alert("This address is not available for COD and Prepaid Methods!");
		}
		if (codpincodeCount > 0) {
			$(".codMethod").show();
		} else{
			$(".codMethod").hide();
		}
		if (prepaidpincodeCount > 0) {
			$(".prepaidMethod").show();
		} else{
			$(".prepaidMethod").hide();
		}
		if (coupon_amount == "") {
			coupon_amount = 0;
		} 
		$(".couponAmount").html(coupon_amount + `&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong>`);
		var total_price = $(this).attr('total_price');
		$(".shippingCharges").html(shipping_charges + `&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong>`);
    $(".gstCharges").html(total_GST + `&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong>`);
    
		var grand_total = parseInt(total_price) + parseInt(shipping_charges) + parseInt(total_GST) - parseInt(coupon_amount);
		
		$(".grand_total").html(grand_total + `&nbsp;<strong style="font-size: .675rem;">&#x20b4;</strong>`);
	});

  $("#checkPincode").click(function() {
    var pincode = $("#pincode").val();
    if(pincode == "") {
      alert("Please enter your delivery pincode.");
      return false;
    }

    $.ajax({
			url:'/check-pincode',
			type:'post',
			data:{pincode: pincode},
			success:function(resp){
				alert(resp);
			},error:function(){
				alert("Error with pincode");
			}
		});
  });

  $(".btn-wishlist-not-login").click(function() {
    alert("Please Login to add products in your Wishlist.");
  });

  $("#updateWishlist").click(function() {
    var product_id = $(this).data('productid');
    //alert(product_id);

    $.ajax({
      data:{product_id: product_id}, 
      url:'/update-wishlist',
      type:'post',
      success:function(resp){
        if (resp.status) {
          $('button[data-productid='+product_id+']').html('Wishlist <i class="icon-heart" style="color: red;" title="Product in Wishlist"></i>');
          // Wishlist show act
          $("#actWishlist").html("Product added in Wishlist!");
        } else {
          $('button[data-productid='+product_id+']').html('Wishlist <i class="icon-heart-empty"></i>');
          // Wishlist show act
          $("#actWishlist").html("Product removed from Wishlist!");
        }
      },error:function(){
        alert("Error with update Wishlist");
      }
    });
  });

});

function addSubscriber() {
  var subscriber_email = $('#subscriber_email').val();
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if (regex.test(subscriber_email)) {
    $.ajax({
      data:{subscriber_email: subscriber_email}, 
      url:'/add-subscriber-email',
      type:'post',
      success:function(resp){
        if (resp == "exists") {
          alert("Subscriber Email already exists!");
        } else {
          alert("Thanks for Subscribing!");
        }
      },error:function(){
        alert("Error with add Subscriber Email");
      }
    });
  } else {
    alert("Please Enter Valid Email!");
    return false;
  }
}

var spanList = document.getElementById('list');
var spanBlock = document.getElementById('block');
if (spanList) {
  spanList.addEventListener('click', function () {
    spanList.classList.add('btn-primary');
    spanBlock.classList.remove('btn-primary');
  })
}
if (spanBlock) {
  spanBlock.addEventListener('click', function () {
    spanBlock.classList.add('btn-primary');
    spanList.classList.remove('btn-primary');
  })
}