$(document).ready(function() {

  //Check Admin Password is correct or not
  $("#current_pwd").keyup(function() {
    var current_pwd = $("#current_pwd").val();
    /* alert(current_pwd); */
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/check-current-password',
      data: {current_pwd: current_pwd},
      success: function(resp) {
        if(!resp) {
          $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
        } else {
          $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
        }
      },error: function() {
        alert('Error with Current Password');
      }
    })
  })

  //Update Admin Status
  $(document).on("click", ".updateAdminStatus", function() {
    var status = $(this).children("i").attr("status");
    var admin_id = $(this).attr("admin_id");
    //alert(admin_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-admin-status',
      data: {status: status, admin_id: admin_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#admin-"+admin_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
          $("#show-status-"+admin_id).html("<span id='show-status-{{ $admin['id'] }}' style='color: red;'>Inactive</span>")
        }else {
          $("#admin-"+admin_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+admin_id).html("<span id='show-status-{{ $admin['id'] }}' style='color: green;'>Active</span>")
        }
      },error: function() {
        alert('Error with Brand Status');
      }
    })
  })

  //Update Section Status
  $(document).on("click", ".updateSectionStatus", function() {
    var status = $(this).children("i").attr("status");
    var section_id = $(this).attr("section_id");
    //alert(section_id); 

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/admin/update-section-status',
        data: {status: status, section_id: section_id},
        success: function(resp) {
            //alert(resp);
            if (resp['status'] == 0) {
                $("#section-"+section_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
                $("#show-status-"+section_id).html("<p id='show-status-{{ $section['id'] }}' style='color: red;'>Inactive</p>")
            }else {
                $("#section-"+section_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
                $("#show-status-"+section_id).html("<p id='show-status-{{ $section['id'] }}' style='color: green;'>Active</p>")
            }
        },error: function() {
            alert('Error with Section Status');
        }
    })
  })

  //Update Brand Status
  $(document).on("click", ".updateBrandStatus", function() {
    var status = $(this).children("i").attr("status");
    var brand_id = $(this).attr("brand_id");
    //alert(brand_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-brand-status',
      data: {status: status, brand_id: brand_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#brand-"+brand_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
          $("#show-status-"+brand_id).html("<span id='show-status-{{ $brand['id'] }}' style='color: red;'>Inactive</span>")
        }else {
          $("#brand-"+brand_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+brand_id).html("<span id='show-status-{{ $brand['id'] }}' style='color: green;'>Active</span>")
        }
      },error: function() {
        alert('Error with Brand Status');
      }
    })
  })

  //Update CMS Page Status
  $(document).on("click", ".updateCMSPageStatus", function() {
    var status = $(this).children("i").attr("status");
    var page_id = $(this).attr("page_id");
    //alert(page_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-cms-page-status',
      data: {status: status, page_id: page_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#page-"+page_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
          $("#show-status-"+page_id).html("<span id='show-status-{{ $page['id'] }}' style='color: red;'>Inactive</span>")
        }else {
          $("#page-"+page_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+page_id).html("<span id='show-status-{{ $page['id'] }}' style='color: green;'>Active</span>")
        }
      },error: function() {
        alert('Error with CMS Page Status');
      }
    })
  })

  //Update User Status
  $(document).on("click", ".updateUserStatus", function() {
    var status = $(this).children("i").attr("status");
    var user_id = $(this).attr("user_id");
    //alert(user_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-user-status',
      data: {status: status, user_id: user_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#user-"+user_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
        }else {
          $("#user-"+user_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
        }
      },error: function() {
        alert('Error with User Status');
      }
    })
  })

  //Update Banner Status
  $(document).on("click", ".updateBannerStatus", function() {
    var status = $(this).children("i").attr("status");
    var banner_id = $(this).attr("banner_id");
    //alert(banner_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-banner-status',
      data: {status: status, banner_id: banner_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#banner-"+banner_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
          $("#show-status-"+banner_id).html("<p id='show-status-{{ $banner['id'] }}' style='color: red;'>Inactive</p>")
        }else {
          $("#banner-"+banner_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+banner_id).html("<p id='show-status-{{ $banner['id'] }}' style='color: green;'>Active</p>")
        }
      },error: function() {
        alert('Error with Banner Status');
      }
    })
  })

  //Update Coupon Status
  $(document).on("click", ".updateCouponStatus", function() {
    var status = $(this).children("i").attr("status");
    var coupon_id = $(this).attr("coupon_id");
    alert(coupon_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-coupon-status',
      data: {status: status, coupon_id: coupon_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#coupon-"+coupon_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
          $("#show-status-"+coupon_id).html("<span id='show-status-{{ $coupon['id'] }}' style='color: red;'>Inactive</span>")
        }else {
          $("#coupon-"+coupon_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+coupon_id).html("<span id='show-status-{{ $coupon['id'] }}' style='color: green;'>Active</span>")
        }
      },error: function() {
        alert('Error with Update Coupon Status ffffffff');
      }
    })
  })

  //Update Shipping Charges Status
  $(document).on("click", ".updateShippingStatus", function() {
    var status = $(this).children("i").attr("status");
    var shipping_id = $(this).attr("shipping_id");
    //alert(shipping_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-shipping-status',
      data: {status: status, shipping_id: shipping_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#shipping-"+shipping_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive'></i>")
        }else {
          $("#shipping-"+shipping_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
        }
      },error: function() {
        alert('Error with Shipping Charges Status');
      }
    })
  })

  //Update Currency Status
  $(document).on("click", ".updateCurrencyStatus", function() {
    var status = $(this).children("i").attr("status");
    var currency_id = $(this).attr("currency_id");
    //alert(currency_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-currency-status',
      data: {status: status, currency_id: currency_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#currency-"+currency_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive'></i>")
          $("#show-status-"+currency_id).html("<span id='show-status-{{ $currency['id'] }}' style='color: red;'>Inactive</span>")
        }else {
          $("#currency-"+currency_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+currency_id).html("<span id='show-status-{{ $currency['id'] }}' style='color: green;'>Active</span>")
        }
      },error: function() {
        alert('Error with Currency Status');
      }
    })
  })

  //Update Rating Status
  $(document).on("click", ".updateRatingStatus", function() {
    var status = $(this).children("i").attr("status");
    var rating_id = $(this).attr("rating_id");
    //alert(rating_id); 

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-rating-status',
      data: {status: status, rating_id: rating_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#rating-"+rating_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive'></i>")
          $("#show-status-"+rating_id).html("<span id='show-status-{{ $rating['id'] }}' style='color: red;'>Inactive</span>")
        }else {
          $("#rating-"+rating_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+rating_id).html("<span id='show-status-{{ $rating['id'] }}' style='color: green;'>Active</span>")
        }
      },error: function() {
        alert('Error with Update Rating Status');
      }
    })
  })

  //Show/Hide Field Coupon Code for Manual/Automatic
  $("#ManualCoupon").click(function() {
    $("#couponCode").show();
  })
  $("#AutomaticCoupon").click(function() {
    $("#couponCode").hide();
  })

  //Update Category Status
  $(document).on("click", ".updateCategoryStatus", function() {
    var status = $(this).children("i").attr("status");
    var category_id = $(this).attr("category_id");
    //alert(section_id); 

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/admin/update-category-status',
        data: {status: status, category_id: category_id},
        success: function(resp) {
            //alert(resp);
            if (resp['status'] == 0) {
                $("#category-"+category_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
                $("#show-status-"+category_id).html("<span id='show-status-{{ $category['id'] }}' style='color: red;'>Inactive</span>")
            }else {
                $("#category-"+category_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
                $("#show-status-"+category_id).html("<span id='show-status-{{ $category['id'] }}' style='color: green;'>Active</span>")
            }
        },error: function() {
            alert('Error with Category Status');
        }
    })
  })

  //Append Categories Level
  $("#section_id").change(function () {
    var section_id = $(this).val();
    //alert(section_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/admin/append-categories-level',
        data: {section_id: section_id},
        success: function(resp) {
            //alert(resp);
            $("#appendCategoriesLevel").html(resp);            
        },error: function() {
            alert('Error with Append Categories Level');
        }
    })
  })

  //Update Product Status
  $(document).on("click", ".updateProductStatus", function() {
    var status = $(this).children("i").attr("status");
    var product_id = $(this).attr("product_id");
    //alert(section_id); 

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/admin/update-product-status',
        data: {status: status, product_id: product_id},
        success: function(resp) {
            //alert(resp);
            if (resp['status'] == 0) {
                $("#product-"+product_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
                $("#show-status-"+product_id).html("<span id='show-status-{{ $product['id'] }}' style='color: red;'>Inactive</span>")
            }else {
                $("#product-"+product_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
                $("#show-status-"+product_id).html("<span id='show-status-{{ $product['id'] }}' style='color: green;'>Active</span>")
            }
        },error: function() {
            alert('Error with Product Status');
        }
    })
  })

  //Update Attribute Status
  $(document).on("click", ".updateAttributeStatus", function() {
    var status = $(this).children("i").attr("status");
    var attribute_id = $(this).attr("attribute_id");
    //alert(section_id); 

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/admin/update-attribute-status',
        data: {status: status, attribute_id: attribute_id},
        success: function(resp) {
            //alert(resp);
            if (resp['status'] == 0) {
                $("#attribute-"+attribute_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
                $("#show-status-"+attribute_id).html("<span id='show-status-{{ $attribute['id'] }}' style='color: red;'>Inactive</span>")
            } else {
                $("#attribute-"+attribute_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
                $("#show-status-"+attribute_id).html("<span id='show-status-{{ $attribute['id'] }}' style='color: green;'>Active</span>")
            }
        },error: function() {
            alert('Error with Attribute Status');
        }
    })
  })

  //Update Image Status
  $(document).on("click", ".updateImageStatus", function() {
    var status = $(this).children("i").attr("status");
    var image_id = $(this).attr("image_id");

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'post',
      url: '/admin/update-image-status',
      data: {status: status, image_id: image_id},
      success: function(resp) {
        //alert(resp);
        if (resp['status'] == 0) {
          $("#image-"+image_id).html("<i style='scale: 1.5;' class='fas fa-toggle-off' status='Inactive' style='color: gray'></i>")
          $("#show-status-"+image_id).html("<span id='show-status-{{ $image['id'] }}' style='color: red;'>Inactive</span>")
        } else {
          $("#image-"+image_id).html("<i style='scale: 1.5;' class='fas fa-toggle-on' status='Active'></i>")
          $("#show-status-"+image_id).html("<span id='show-status-{{ $image['id'] }}' style='color: green;'>Active</span>")
        }
      },error: function() {
        alert('Error with Image Status');
      }
    })
  })

  //Confirm Deletion (Sweetalert Library) 
  $(document).on("click", ".confirmDelete", function() {
    var record = $(this).attr("record");
    var recordid = $(this).attr("recordid");
    Swal.fire({
      title: 'Are you sure delete this '+record+'?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Deleted!',
          'Your '+record+' has been deleted.',
          'success'
        )

        window.location = "/admin/delete-"+record+"/"+recordid;
      }
    });

  })

  // Add Remove Input Fields Dynamically
  var maxField = 10; //Input fields increment limitation
  var addButton = $('.add_button'); //Add button selector
  var wrapper = $('.field_wrapper'); //Input field wrapper
  var fieldHTML = '<div class="mt-1"><input type="text" style="width: 20%; margin-right: 3px;" id="size" name="size[]" value="" placeholder="Size"/><input type="text" style="width: 20%; margin-right: 3px;" id="sku" name="sku[]" value="" placeholder="SKU"/><input type="number" style="width: 20%; margin-right: 3px;" id="price" name="price[]" value="" placeholder="Price"/><input type="number" style="width: 20%; margin-right: 3px;" id="stock" name="stock[]" value="" placeholder="Stock"/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
  var x = 1; //Initial field counter is 1
  
  //Once add button is clicked
  $(addButton).click(function(){
      //Check maximum number of input fields
      if(x < maxField){ 
          x++; //Increment field counter
          $(wrapper).append(fieldHTML); //Add field html
      }
  });
  
  //Once remove button is clicked
  $(wrapper).on('click', '.remove_button', function(e){
      e.preventDefault();
      $(this).parent('div').remove(); //Remove field html
      x--; //Decrement field counter
  });

  //Datemask dd/mm/yyyy
  $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
  //Datemask2 mm/dd/yyyy
  $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
  //Money Euro
  $('[data-mask]').inputmask()

  //Show Courier Name and Tracking Number in case of Shipped Order Status
  $("#order_status").change(function () {
    var order_status = $(this).val();
    //alert(order_status);
    if(order_status == "Shipped") {
      $("#courier_name").show();
      $("#tracking_number").show();
    } else {
      $("#courier_name").hide();
      $("#tracking_number").hide();
    }
  })
});