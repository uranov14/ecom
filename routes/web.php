<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\CmsPage;

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function() {
    //Admin Login Route
    Route::match(['get', 'post'], '/', [AdminController::class, 'login']);

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard']);
        Route::get('settings', [AdminController::class, 'settings']);
        Route::get('logout', [AdminController::class, 'logout']);

        //Check and Update Admin Password
        Route::post('check-current-password', [AdminController::class, 'checkCurrentPassword']);
        Route::post('update-current-password', [AdminController::class, 'updateCurrentPassword']);

        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails']);

        //Sections
        Route::get('sections', [AdminController::class, 'sections']);
        Route::post('update-section-status', [AdminController::class, 'updateSectionStatus']);

        //Brands
        Route::get('brands', 'BrandController@brands');
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');

        //Categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::post('append-categories-level', 'CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');

        //Products
        Route::get('products', 'ProductsController@products');
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        Route::get('delete-product/{id}', 'ProductsController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

        //Attributes
        Route::match(['get', 'post'], 'add-attributes/{id}', 'ProductsController@addAttributes');
        Route::post('edit-attributes/{id}', 'ProductsController@editAttributes');
        Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');

        //Images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductsController@addImages');
        Route::post('update-image-status', 'ProductsController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductsController@deleteImage');

        //Banners
        Route::get('banners', 'BannersController@banners');
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}', 'BannersController@deleteBanner');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');

        //Coupons
        Route::get('coupons', 'CouponsController@coupons');
        Route::post('update-coupon-status', 'CouponsController@updateCouponStatus');
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}', 'CouponsController@addEditCoupon');
        Route::get('delete-coupon/{id}', 'CouponsController@deleteCoupon');

        //Orders
        Route::get('orders', 'OrdersController@orders');
        Route::get('orders/{id}', 'OrdersController@orderDetails');
        Route::post('update-order-status', 'OrdersController@updateOrderStatus');
        Route::get('view-order-invoice/{id}', 'OrdersController@viewOrderInvoice');
        Route::get('print-pdf-invoice/{id}', 'OrdersController@printPDFInvoice');

        // Shipping Charges
        Route::get('view-shipping-charges', 'ShippingController@viewShippingCharges');
        Route::match(['get', 'post'], 'edit-shipping-charges/{id}', 'ShippingController@editShippingCharges');
        Route::post('update-shipping-status', 'ShippingController@updateShippingStatus');

        // Users
        Route::get('users', 'UsersController@users');
        Route::post('update-user-status', 'UsersController@updateUserStatus');

        // View Users Charts
        Route::get('view-users-charts', 'UsersController@viewUsersCharts');

        // CMS Pages
        Route::get('cms-pages','CmsController@cmspages');
        Route::post('update-cms-page-status', 'CmsController@updateCMSPageStatus');
        Route::match(['get', 'post'], 'add-edit-cms-page/{id?}', 'CmsController@addEditCMSPage');
        Route::get('delete-page/{id}', 'CmsController@deleteCMSPage');

        // Admins / Sub-Admins
        Route::get('admins-subadmins','AdminController@adminsSubadmins');
        Route::post('update-admin-status', 'AdminController@updateAdminStatus');
        Route::match(['get', 'post'], 'add-edit-admin/{id?}', 'AdminController@addEditAdmin');
        Route::get('delete-admin/{id}', 'AdminController@deleteAdmin');
        Route::match(['get', 'post'], 'update-role/{id}', 'AdminController@updateRole');

        // Currencies
        Route::get('currencies','CurrencyController@currencies');
        Route::match(['get', 'post'], 'add-edit-currency/{id?}', 'CurrencyController@addEditCurrency');
        Route::post('update-currency-status', 'CurrencyController@currencyStatus');
        Route::get('delete-currency/{id}', 'CurrencyController@deleteCurrency');

        // Ratings
        Route::get('ratings','RatingsController@ratings');
        Route::post('update-rating-status', 'RatingsController@updateRatingStatus');
    });
    
}); 

Route::namespace('App\Http\Controllers\Front')->group(function() {
    //Home Page Route
    Route::get('/', 'IndexController@index');
    //Licting Categories Routes
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $key => $url) {
        Route::get('/'.$url, 'ProductsController@listing');
    }
    //CMS Page Routes
    $cmsUrls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($cmsUrls as $key => $url) {
        Route::get('/'.$url, 'CmsController@cmsPage');
    }
    //Product Details Route
    Route::get('/product/{id}', 'ProductsController@detail');
    Route::post('/get-product-price', 'ProductsController@getProductPrice');
    //Add to Cart
    Route::post('/add-to-cart', 'ProductsController@addToCart');
    //Show Cart
    Route::get('/cart', 'ProductsController@cart');
    //Update Cart Item Quantity
    Route::post('/update-cart-item-qty', 'ProductsController@updateCartItemQty');
    //Delete Cart Item
    Route::post('/delete-cart-item', 'ProductsController@deleteCartItem');
    // Login/Register User
    Route::get('/login-register', ['as'=>'login', 'uses'=>'UsersController@loginRegister']);
    Route::post('/login', 'UsersController@loginUser');
    Route::post('/register', 'UsersController@registerUser');
    // Check if Email already exists
    Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');
    // Logout User
    Route::get('/logout', 'UsersController@logoutUser');
    // Confirm Account
    Route::match(['get', 'post'], '/confirm/{code}', 'UsersController@confirmAccount');
    // Forgot password
    Route::match(['get', 'post'], '/forgot-password', 'UsersController@forgotPassword');
    //Check Delivery Pincode
    Route::post('check-pincode', 'ProductsController@checkPincode');
    // Search Products
    Route::get('/search-products', 'ProductsController@listing');
    // Contact
    Route::match(['get', 'post'], '/contact', 'CmsController@contact');
    //Add Rating/Review
    Route::post('add-rating', 'RatingsController@addRating');
    // Share Buttons
    Route::get('/post', 'ShareButtonsController@share');

    Route::group(['middleware'=>['auth']], function() {       
        // User Account
        Route::match(['get', 'post'], '/account', 'UsersController@account');
        // User Orders
        Route::get('/orders', 'OrdersController@orders');
        // User Order Details
        Route::get('/orders/{id}', 'OrdersController@orderDetails');
        // Check User Current Password
        Route::post('/check-user-pwd', 'UsersController@checkUserPwd');
        // Update User Password
        Route::post('/update-user-pwd', 'UsersController@updateUserPwd');
        // Apply Coupon
        Route::post('/apply-coupon', 'ProductsController@applyCoupon');
        // Checkout
        Route::match(['get', 'post'], '/checkout', 'ProductsController@checkout');
        // Add/Edit Delivery Address
        Route::match(['get', 'post'], '/add-edit-delivery-address/{id?}', 'ProductsController@addEditDeliveryAddress');
        // Delete Delivery Address
        Route::get('/delete-delivery-address/{id?}', 'ProductsController@deleteDeliveryAddress');
        // Thanks
        Route::get('/thanks', 'ProductsController@thanks');
        // Paypal
        //Route::view('/paypal/payment', 'paypal.index')->name('create.payment');
        Route::get('/paypal', 'PaypalController@paypal');
        // Paypal Success
        Route::get('/paypal/success', 'PaypalController@success');
        // Paypal Fail
        Route::get('/paypal/fail', 'PaypalController@fail');
        // Paypal IPN
        Route::post('/paypal/ipn', 'PaypalController@ipn');

        /* Route::controller(PaymentController::class)
            ->prefix('paypal')
            ->group(function () {
                Route::view('payment', 'paypal.index')->name('create.payment');
                Route::get('/', 'paypal')->name('make.payment');
                Route::get('fail', 'paymentCancel')->name('cancel.payment');
                Route::get('success', 'paymentSuccess')->name('success.payment');
            }); */
    });
});
