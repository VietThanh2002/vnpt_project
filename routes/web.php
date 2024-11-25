<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Admin
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\UserListController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PdfController;
use App\Http\Controllers\admin\ChangePassWordController;
use App\Http\Controllers\admin\ListProductSellingController;

//User
use App\Http\Controllers\user\AuthController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\ContactController;
use App\Http\Controllers\user\IntroduceController;
use App\Http\Controllers\user\PaymentOnlineController;
use App\Http\Controllers\user\ShopController;
use App\Http\Controllers\user\FrontController;
use App\Http\Controllers\user\ShowSimController;

//Staff
use App\Http\Controllers\staff\StaffLoginController;
use App\Http\Controllers\staff\DeliveryController;

use App\Http\Controllers\admin\SimCardController;
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
Route::get('/sim-so', [ShowSimController::class, 'index'])->name('user.simSo');
Route::get('/product/{slug}', [ShopController::class, 'product'])->name('user.product');
// Cart
Route::get('/cart', [CartController::class, 'cart'])->name('user.cart');
Route::post('/add-to-cart', [CartController::class, 'addService'])->name('user.addService');
Route::post('/buy-sim', [CartController::class, 'buySim'])->name('user.buySim');
Route::post('/add-to-wishlist', [FrontController::class, 'addToWishlist'])->name('user.addToWishlist');

Route::post('/update-cart', [CartController::class, 'updateCart'])->name('user.updateCart');
Route::delete('/delete-item', [CartController::class, 'deleteItem'])->name('user.deleteItem.cart');

//Checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('user.checkout');
Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('user.processCheckout');

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
        Route::get('/orders', [AuthController::class, 'getOrder'])->name('user.getOrder');
        Route::get('/order-detail/{orderId}', [AuthController::class, 'getOrderDetail'])->name('user.getOrderDetail');
        Route::post('/order-cancel/{order}', [AuthController::class, 'cancelOrder'])->name('user.cancelOrder');
        Route::get('/change-password-form', [AuthController::class, 'changePassWordForm'])->name('user.changePassWordForm');
        Route::post('/change-password', [AuthController::class, 'changePassWord'])->name('user.changePassWord');
        Route::put('/update-profile/{userId}', [AuthController::class, 'updateProfile'])->name('user.updateProfile');
        Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
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
        Route::get('/ratings-products', [ProductController::class, 'productRating'])->name('products.productRating');
        Route::post('/change-rating-status', [ProductController::class, 'changeRatingStatus'])->name('products.changeRatingStatus');

        // Sim card
        Route::get('/sim-card', [SimCardController::class, 'index'])->name('sim-card.index');
        Route::get('/sim-card/create', [SimCardController::class, 'create'])->name('sim-card.create');
        Route::post('/sim-card', [SimCardController::class, 'store'])->name('sim-card.store');
        Route::get('/sim-card/{id}/edit', [SimCardController::class, 'edit'])->name('sim-card.edit');
        Route::put('/sim-card/{id}', [SimCardController::class, 'update'])->name('sim-card.update');
        Route::delete('/sim-card/{id}', [SimCardController::class, 'destroy'])->name('sim-card.destroy');

        //Get order and orderDetail
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/order-detail/{orderId}', [OrderController::class, 'detailOrder'])->name('orders.detailOrder');
        Route::post('/orders/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
        Route::post('/orders/send-email/{id}', [OrderController::class, 'sendEmailOrder'])->name('orders.sendEmailOrder');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

        //users
        Route::get('/users', [UserListController::class, 'index'])->name('users.index');
       
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

