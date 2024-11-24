<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Admin
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandsController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\UserListController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\WarehouseController;
use App\Http\Controllers\admin\PdfController;
use App\Http\Controllers\admin\ChangePassWordController;
use App\Http\Controllers\admin\ListProductSellingController;
use App\Http\Controllers\admin\StaffsManagerController;

//User
use App\Http\Controllers\user\AuthController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\ContactController;
use App\Http\Controllers\user\IntroduceController;
use App\Http\Controllers\user\PaymentOnlineController;
use App\Http\Controllers\user\ShopController;
use App\Http\Controllers\user\FrontController;

//Staff
use App\Http\Controllers\staff\StaffLoginController;
use App\Http\Controllers\staff\DeliveryController;

//Test QR code
use App\Http\Controllers\admin\QrCodeController;

Route::get('/test', [QrCodeController::class, 'showHello']);
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/test', function(){
//     sendEmail(6);
// });

Route::get('/', [FrontController::class, 'index'])->name('user.home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}', [ShopController::class, 'index'])->name('user.shop');
Route::get('/product/{slug}', [ShopController::class, 'product'])->name('user.product');
// Cart
Route::get('/cart', [CartController::class, 'cart'])->name('user.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('user.addToCart');
Route::post('/add-to-wishlist', [FrontController::class, 'addToWishlist'])->name('user.addToWishlist');

Route::post('/update-cart', [CartController::class, 'updateCart'])->name('user.updateCart');
Route::delete('/delete-item', [CartController::class, 'deleteItem'])->name('user.deleteItem.cart');

//Checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('user.checkout');
Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('user.processCheckout');
Route::get('/payment-online', [PaymentOnlineController::class, 'vnpay_payment'])->name('user.payment');


//applyDiscount 
Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('user.applyDiscount');
Route::post('/remove-discount', [CartController::class, 'removeDiscount'])->name('user.removeDiscount');

Route::get('/thanks/{orderId}', [CartController::class, 'thank'])->name('user.success_order');
Route::post('/get-order-summery', [CartController::class, 'getOrderSummary'])->name('user.getOrderSummary');

Route::get('/contact',[ContactController::class, 'index'])->name('user.contact');
Route::post('send-contact-email', [ContactController::class, 'sendContactEmail'])->name('user.sendContactEmail');

Route::get('/introduce',[IntroduceController::class, 'index'])->name('user.introduce');

Route::get('/forgot-password',[AuthController::class, 'forgotPassword'])->name('user.forgotPassword');
Route::post('/execute-reset-password',[AuthController::class, 'executeResetPassword'])->name('user.executeResetPassword');
Route::get('/reset-password/{token}',[AuthController::class, 'resetPassword'])->name('user.resetPassword');
Route::post('/process-reset-password',[AuthController::class, 'processResetPassword'])->name('user.processResetPassword');

Route::post('save-rating/{productId}', [ShopController::class, 'saveRating'])->name('user.saveRating');

Route::group(['prefix'=> '/'], function(){
    Route::group(['middleware' => 'guest'], function(){
        
        Route::get('/login', [AuthController::class, 'login'])->name('user.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('user.authenticate');
        Route::get('/register', [AuthController::class, 'register'])->name('user.register');
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');

    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile', [AuthController::class, 'profile'])->name('user.profile');
        Route::get('/address-info', [AuthController::class, 'addressInfo'])->name('user.addressInfo');
        Route::get('/orders', [AuthController::class, 'getOrder'])->name('user.getOrder');
        Route::get('/order-detail/{orderId}', [AuthController::class, 'getOrderDetail'])->name('user.getOrderDetail');
        Route::post('/order-cancel/{order}', [AuthController::class, 'cancelOrder'])->name('user.cancelOrder');
        Route::get('/wishlists', [AuthController::class, 'wishList'])->name('user.wishList');
        Route::get('/change-password-form', [AuthController::class, 'changePassWordForm'])->name('user.changePassWordForm');
        Route::post('/change-password', [AuthController::class, 'changePassWord'])->name('user.changePassWord');
        Route::put('/update-profile/{userId}', [AuthController::class, 'updateProfile'])->name('user.updateProfile');
        Route::put('/update-delivery-address', [AuthController::class, 'updateUserAddress'])->name('user.updateUserAddress');
        Route::delete('/remove-product-wishlist', [AuthController::class, 'removeProductWishList'])->name('user.removeWishList');
        Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
        
        // Route::get('/checkout', [CartController::class, 'checkout'])->name('user.checkout');
        // Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('user.processCheckout');
        // Route::get('/thanks/{orderId}', [CartController::class, 'thank'])->name('user.success_order');

      
    });

});

Route::group(['prefix'=> '/staff'], function(){
    Route::group(['middleware' => 'staff.guest'], function(){
        
        Route::get('/login', [StaffLoginController::class, 'login'])->name('staff.login');
        Route::post('/authenticate', [StaffLoginController::class, 'authenticate'])->name('staff.authenticate');
      
    });

    Route::group(['middleware' => 'staff.auth'], function(){
        Route::get('/home', [StaffLoginController::class, 'home'])->name('staff.home');
        Route::get('/logout', [StaffLoginController::class, 'logout'])->name('staff.logout');
        Route::get('/orders-list-pending', [DeliveryController::class, 'ordersPending'])->name('staff.listPending');
        Route::get('/orders-list-complete', [DeliveryController::class, 'ordersComplete'])->name('staff.listComplete');
        Route::get('/view-profile', [DeliveryController::class, 'viewProfile'])->name('staff.viewProfile');
        Route::get('invoice/{orderId}', [DeliveryController::class, 'viewBill']);
        Route::put('/orders/update-status/{id}', [DeliveryController::class, 'updateOrderStatusQR'])->name('orders.updateOrderStatusQR');
        Route::get('/successful-delivery/{orderId}', [DeliveryController::class, 'successful'])->name('staff.successful-delivery');
        Route::get('/product-list', [StaffLoginController::class, 'getProducts'])->name('staff.productsList');
    });
});


Route::group(['prefix'=> 'admin'], function(){
    
    Route::group(['middleware' => 'admin.guest'], function(){

        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/orders-cancel', [HomeController::class, 'getCancelOrder'])->name('orders.cancel');
        Route::get('/orders-complete', [HomeController::class, 'getCompleteOrder'])->name('orders.complete');
        Route::get('/top-orders', [HomeController::class, 'getUserVip'])->name('orders.getUserVip');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        // Change password
        Route::get('/change-password', [ChangePassWordController::class, 'changePassWordForm'])->name('admin.changePassWordForm');
        Route::post('/change-password', [ChangePassWordController::class, 'changePassWord'])->name('admin.changePassWord');

        // statistical list of sold products
        Route::get('/products-selling-week-list', [ListProductSellingController::class, 'listProductSellingWeek'])->name('admin.sellingWeek');
        Route::get('/products-selling-month', [ListProductSellingController::class, 'listProductSellingMonth'])->name('admin.sellingMonth');
        Route::get('/products-selling-last-month', [ListProductSellingController::class, 'listProductSellingLastMonth'])->name('admin.sellingLastMonth');
        Route::get('/products-selling-year', [ListProductSellingController::class, 'listProductSellingYear'])->name('admin.sellingYear');
        Route::get('/products-selling-quarter1', [ListProductSellingController::class, 'quarter1'])->name('admin.sellingQuarter1');
        Route::get('/products-selling-quarter2', [ListProductSellingController::class, 'quarter2'])->name('admin.sellingQuarter2');
        Route::get('/products-selling-quarter3', [ListProductSellingController::class, 'quarter3'])->name('admin.sellingQuarter3');
        Route::get('/products-selling-quarter4', [ListProductSellingController::class, 'quarter4'])->name('admin.sellingQuarter4');

        // Category
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
       // Sub category
        Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories.index');
        Route::get('/sub-categories/create', [SubCategoryController::class, 'create'])->name('sub-categories.create');
        Route::post('/sub-categories', [SubCategoryController::class, 'store'])->name('sub-categories.store');
        Route::get('/sub-categories/{SubCategory}/edit', [SubCategoryController::class, 'edit'])->name('sub-categories.edit');
        Route::put('/sub-categories/{SubCategory}', [SubCategoryController::class, 'update'])->name('sub-categories.update');
        Route::delete('/sub-categories/{SubCategory}', [SubCategoryController::class, 'destroy'])->name('sub-categories.destroy');
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        // Brands 
        Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
        Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}/edit', [BrandsController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brand}', [BrandsController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandsController::class, 'destroy'])->name('brands.destroy');

        // Product
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');
        Route::delete('/product-images', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');
        // Route::get('/ratings-products', [ProductController::class, 'productRating'])->name('products.productRating');
        // Route::post('/change-rating-status', [ProductController::class, 'changeRatingStatus'])->name('products.changeRatingStatus');

        //shipping cost
        Route::get('/shipping', [ShippingController::class, 'index'])->name('shipping.index');
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{shipping}/edit', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::patch('/shipping/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('shipping.destroy');

        // DiscountCode
        Route::get('/discount', [DiscountCodeController::class, 'index'])->name('discount.index');
        Route::get('/discount/create', [DiscountCodeController::class, 'create'])->name('discount.create');
        Route::post('/discount', [DiscountCodeController::class, 'store'])->name('discount.store');
        Route::get('/discount/{id}/edit', [DiscountCodeController::class, 'edit'])->name('discount.edit');
        Route::put('/discount/{id}', [DiscountCodeController::class, 'update'])->name('discount.update');
        Route::delete('/discount/{id}', [DiscountCodeController::class, 'destroy'])->name('discount.destroy');

        //Get order and orderDetail
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/order-detail/{orderId}', [OrderController::class, 'detailOrder'])->name('orders.detailOrder');
        Route::post('/orders/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
        Route::post('/orders/send-email/{id}', [OrderController::class, 'sendEmailOrder'])->name('orders.sendEmailOrder');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Route::put('/orders/update-status/{id}', [OrderController::class, 'updateOrderStatusQR'])->name('orders.updateOrderStatusQR');
        // Route::get('/successful-delivery-/{orderId}', [OrderController::class, 'successful'])->name('orders.successful-delivery');

        //users
        Route::get('/users', [UserListController::class, 'index'])->name('users.index');

        //staff
        Route::get('/staffs', [StaffsManagerController::class, 'index'])->name('staffs.index');
        Route::get('/staffs/create', [StaffsManagerController::class, 'create'])->name('staffs.create');
        Route::post('/staffs', [StaffsManagerController::class, 'store'])->name('staffs.store');
        Route::get('/staffs/{id}/edit', [StaffsManagerController::class, 'edit'])->name('staffs.edit');
        Route::put('/staffs/{id}', [StaffsManagerController::class, 'update'])->name('staffs.update');
        Route::delete('/staffs/{id}', [StaffsManagerController::class, 'destroy'])->name('staffs.destroy');

        //warehouse
        Route::get('/warehouse-import-products', [WarehouseController::class, 'import'])->name('warehouse.import');
       
        // Export PDF
        Route::get('invoice/{orderId}', [PdfController::class, 'index']);
        Route::get('invoice/{orderId}/exportPdf', [PdfController::class, 'exportPdf']);

        
        Route::get('/getSlug', function(Request $request){
            $slug = '';
            if(!empty($request->title)){
                $slug = Str::slug($request->title); // xử lý khoảng trắng đã được thay thế bằng dấu gạch ngang và các ký tự đặc biệt khác đã bị loại bỏ
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getLSlug');

    });

});

