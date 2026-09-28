<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BazarController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

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


    Route::get('/', [HomeController::class, 'frontdHome'])->name('front_home');
    Route::get('our/bazars', [HomeController::class, 'ourBazarList'])->name('our.bazars');
    Route::get('our/policy', [HomeController::class, 'ourPolicy'])->name('our.policy');
    Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact_us');
    Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('terms-and-conditions', [HomeController::class, 'termsAndConditions'])->name('terms-and-conditions');
    Route::get('/products/filter', [HomeController::class, 'filterProducts'])->name('products.filter');
    Route::get('product/{id}', [HomeController::class, 'frontdProductDetails'])->name('home.product.details');
    Route::get('ecommerce-product/{id}', [HomeController::class, 'frontdEcommerceProductDetails'])->name('home.ecom_product.details');
    Route::post('/contact/submit', [HomeController::class, 'contactUsStore'])->name('contact.submit');


    Route::get('/package/details/{id}', [PackageController::class, 'packageDetails'])->name('home.package.details');



// routes/web.php
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/barazid/clear/add', [CartController::class, 'clearAndAdd'])->name('bazarid.clear.add');
    // Route::get('/view/cart', [CartController::class, 'sessionViewCart'])->name('session.view.cart');
    Route::get('/cart/fetch', [CartController::class, 'viewCardItems'])->name('cart.fetch');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeSessionItem'])->name('cart.remove');

    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
     
    Route::post('/save-order', [CartController::class, 'saveOrder'])->name('save.order');

    
Route::prefix('rider')->middleware(['auth','role:rider'])->group(function () {
    // ========================= rider routes =================
    Route::get('dashboard', [RiderController::class, 'riderDashboard'])->name('rider.dashboard');
    Route::get('orders', [RiderController::class, 'riderOrders'])->name('rider.orders');
    Route::get('products', [RiderController::class, 'riderProducts'])->name('rider.products');
    Route::post('products/store', [RiderController::class, 'riderProductStore'])->name('rider.products.store');
    Route::get('earnings', [RiderController::class, 'riderEarnings'])->name('rider.earnings');
    Route::get('support', [RiderController::class, 'riderSupport'])->name('rider.support');
    Route::get('settings', [RiderController::class, 'riderSettings'])->name('rider.settings');
 
    // Rider pending order list (for auto-load)
    Route::get('orders/pending', [RiderController::class, 'pendingOrders'])->name('rider.orders.pending');

    // Rider accept order
    Route::post('orders/accept', [RiderController::class, 'acceptOrder'])->name('rider.orders.accept');
    // routes/web.php
    Route::post('orders/deliver/{id}', [RiderController::class, 'markAsDelivered'])->name('rider.orders.deliver');
});


Route::get('/register-user', [RegisterController::class, 'create'])->name('user.register');
Route::post('/register-user', [RegisterController::class, 'store'])->name('user.register.store');

Route::get('rider/{id}', [HomeController::class, 'riderProfile'])->name('riders.show');

Route::get('place-order', [HomeController::class, 'homePlaceOrder'])->name('home.place.order');
Route::get('order-success', [HomeController::class, 'homeOrderDone'])->name('home.order.done');

Route::get('/become-rider', [RiderController::class, 'riderRegForm'])->name('rider.register');
Route::post('/become-rider', [RiderController::class, 'reiderStore'])->name('rider.register.store');



Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    // admin dashboard routes
    Route::get('dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('dashboard/manage_products', [AdminDashboardController::class, 'adminManageProducts'])->name('admin.manage_products');
    Route::get('dashboard/create-product', [AdminDashboardController::class, 'adminManageCreateProducts'])->name('admin.product.create');
    Route::get('dashboard/ecommerce-product-create', [AdminDashboardController::class, 'ecommerceCreateProducts'])->name('admin.ecom_product.create');
    // Route::post('dashboard/store-product', [AdminDashboardController::class, 'adminStoreProducts'])->name('admin.products.store');
    Route::get('dashboard/all_orders', [AdminDashboardController::class, 'adminAllOrders'])->name('admin.all_orders');
    Route::get('dashboard/rider_list', [AdminDashboardController::class, 'adminRiderList'])->name('admin.rider_list');
    Route::get('dashboard/customer_list', [AdminDashboardController::class, 'adminCustomerList'])->name('admin.customer_list');
    Route::get('dashboard/staff_list', [AdminDashboardController::class, 'adminStaffList'])->name('admin.staff_list');
    Route::get('dashboard/settings', [AdminDashboardController::class, 'adminSettings'])->name('admin.settings');


    Route::get('dashboard/rider/slug', [AdminDashboardController::class, 'riderProfile'])->name('admin.rider.profile');
    
    Route::get('live/orders', [AdminDashboardController::class, 'adminLiveOrders'])->name('admin.orders.live');

    // ========================= backend =================
    Route::get('dashboard/manage-bazar', [BazarController::class, 'adminManageBazar'])->name('admin.manage_bazar');

    Route::post('/bazars/store', [BazarController::class, 'store'])->name('admin.bazars.store');
    Route::get('/bazars/{id}/edit', [BazarController::class, 'edit'])->name('admin.bazars.edit');
    Route::post('/bazars/update', [BazarController::class, 'bazarUpdate'])->name('admin.bazars.update');
    Route::get('/bazars/{id}', [BazarController::class, 'destroy'])->name('bazar.delete');

    Route::post('/bazar/areas', [BazarController::class, 'getAreas'])->name('admin.bazar.areas');
    Route::post('/bazars/areas/store', [BazarController::class, 'bazarAreastore'])->name('admin.bazar.areas.store');
    Route::post('/bazars/areas/delete', [BazarController::class, 'bazarAreadestroy'])->name('admin.bazar.areas.delete');
 

    Route::get('/package-management', [PackageController::class, 'index'])->name('admin.package_management');
    Route::get('/create-package', [PackageController::class, 'createPkg'])->name('admin.package_create');
    Route::post('/store-package', [PackageController::class, 'storePkg'])->name('admin.pakcage.store');
    Route::post('/package/update', [PackageController::class, 'updatePkg'])
    ->name('admin.package.update');
    Route::post('/store-package-items', [PackageController::class, 'getPkgItems'])->name('admin.package.items');
    Route::post('/package/items/store', [PackageController::class, 'storePackageItem'])
    ->name('admin.package.items.store');




    Route::get('/products', [ProductController::class, 'index'])->name('manage_products');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/riders', [RiderController::class, 'index'])->name('admin.riders.index');
    Route::post('/riders', [RiderController::class, 'riderStore'])->name('admin.riders.store');
    Route::delete('/riders/{id}', [RiderController::class, 'destroy'])->name('admin.riders.destroy');

    Route::post('/product/update-price',[ProductController::class,'updatePrice'])->name('admin.product.updatePrice');

    Route::get('/products/{product}/edit', [ProductController::class, 'productEdit'])
    ->name('admin.products.edit');

    Route::post('/products/{product}', [ProductController::class, 'productUpdate'])
    ->name('admin.products.update');
    Route::get('products/{product}/view', [ProductController::class, 'productView'])
    ->name('admin.products.view');
});


// user dashboard routes
Route::prefix('user')->middleware(['auth','role:user'])->group(function () {
    Route::get('dashboard', [UserDashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('dashboard/my-orders', [UserDashboardController::class, 'myOrders'])->name('user.my_orders');
    Route::get('dashboard/my-cart', [UserDashboardController::class, 'myCart'])->name('user.my_cart');
    Route::get('dashboard/settings', [UserDashboardController::class, 'mySettings'])->name('user.settings');

    Route::get('order/ajax/details', [UserDashboardController::class, 'details'])->name('rider.order.details');
    Route::post('order/accept', [UserDashboardController::class, 'accept'])->name('rider.order.accept');
    Route::post('order/cancell', [UserDashboardController::class, 'orderCancell'])->name('rider.order.cancell');
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
