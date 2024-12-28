<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('set-location', [App\Http\Controllers\HomeController::class, 'setLocation'])->name('set-location');

Route::get('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');

Route::get('signup', [App\Http\Controllers\LoginController::class, 'signup'])->name('signup');

Route::get('search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::get('lang/change', [App\Http\Controllers\LangController::class, 'change'])->name('changeLang');

Route::get('privacy', [App\Http\Controllers\CmsController::class, 'privacypolicy'])->name('privacy');

Route::get('refund', [App\Http\Controllers\CmsController::class, 'refundpolicy'])->name('refund');

Route::get('aboutus', [App\Http\Controllers\CmsController::class, 'aboutus'])->name('aboutus');

Route::get('terms', [App\Http\Controllers\CmsController::class, 'termsofuse'])->name('terms');

Route::get('deliveryofsupport', [App\Http\Controllers\CmsController::class, 'deliveryofsupport'])->name('deliveryofsupport');

Route::post('takeaway', [App\Http\Controllers\PaymentController::class, 'takeawayOption'])->name('takeaway');

Route::get('my_order', [App\Http\Controllers\OrderController::class, 'index'])->name('my_order');

Route::get('completed_order', [App\Http\Controllers\OrderController::class, 'completedOrders'])->name('completed_order');

Route::get('pending_order', [App\Http\Controllers\OrderController::class, 'pendingOrder'])->name('pending_order');

Route::get('intransit_order', [App\Http\Controllers\OrderController::class, 'intransitOrder'])->name('intransit_order');

Route::get('contact-us', [App\Http\Controllers\ContactUsController::class, 'index'])->name('contact_us');

Route::get('help', [App\Http\Controllers\CmsController::class, 'help'])->name('help');

Route::get('notification', [App\Http\Controllers\HomeController::class, 'notification'])->name('notification');

Route::get('categories', [App\Http\Controllers\StoreController::class, 'categoryList'])->name('categorylist');

Route::get('store', [App\Http\Controllers\StoreController::class, 'index'])->name('store');

Route::get('cart', [App\Http\Controllers\ProductController::class, 'cart'])->name('cart');

Route::post('add-to-cart', [App\Http\Controllers\ProductController::class, 'addToCart'])->name('add-to-cart');

Route::post('reorder-add-to-cart', [App\Http\Controllers\ProductController::class, 'reorderaddToCart'])->name('reorder-add-to-cart');

Route::get('products', [App\Http\Controllers\ProductController::class, 'productListAll'])->name('productlist.all');

Route::get('product/{id}', [App\Http\Controllers\ProductController::class, 'productDetail'])->name('productDetail');

Route::get('products/{type}/{id}', [App\Http\Controllers\ProductController::class, 'productList'])->name('productList');

Route::post('update-cart', [App\Http\Controllers\ProductController::class, 'update'])->name('update-cart');

Route::post('remove-from-cart', [App\Http\Controllers\ProductController::class, 'remove'])->name('remove-from-cart');

Route::post('change-quantity-cart', [App\Http\Controllers\ProductController::class, 'changeQuantityCart'])->name('change-quantity-cart');

Route::post('apply-coupon', [App\Http\Controllers\ProductController::class, 'applyCoupon'])->name('apply-coupon');

Route::get('checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');

Route::post('order-complete', [App\Http\Controllers\ProductController::class, 'orderComplete'])->name('order-complete');

Route::post('order-tip-add', [App\Http\Controllers\ProductController::class, 'orderTipAdd'])->name('order-tip-add');

Route::post('order-delivery-option', [App\Http\Controllers\ProductController::class, 'orderDeliveryOption'])->name('order-delivery-option');

Route::get('pay', [App\Http\Controllers\CheckoutController::class, 'proccesstopay'])->name('pay');

Route::post('order-proccessing', [App\Http\Controllers\CheckoutController::class, 'orderProccessing'])->name('order-proccessing');

Route::post('process-stripe', [App\Http\Controllers\CheckoutController::class, 'processStripePayment'])->name('process-stripe');

Route::post('process-paypal', [App\Http\Controllers\CheckoutController::class, 'processPaypalPayment'])->name('process-paypal');

Route::post('razorpaypayment', [App\Http\Controllers\CheckoutController::class, 'razorpaypayment'])->name('razorpaypayment');

Route::post('process-mercadopago', [App\Http\Controllers\CheckoutController::class, 'processMercadoPagoPayment'])->name('process-mercadopago');

Route::get('success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('success');

Route::get('failed', [App\Http\Controllers\CheckoutController::class, 'failed'])->name('failed');

Route::get('notify', [App\Http\Controllers\CheckoutController::class, 'notify'])->name('notify');

Route::get('pay-wallet', [App\Http\Controllers\TransactionController::class, 'proccesstopaywallet'])->name('pay-wallet');

Route::post('wallet-proccessing', [App\Http\Controllers\TransactionController::class, 'walletProccessing'])->name('wallet-proccessing');

Route::post('wallet-process-stripe', [App\Http\Controllers\TransactionController::class, 'processStripePayment'])->name('wallet-process-stripe');

Route::post('wallet-process-paypal', [App\Http\Controllers\TransactionController::class, 'processPaypalPayment'])->name('wallet-process-paypal');

Route::post('razorpaywalletpayment', [App\Http\Controllers\TransactionController::class, 'razorpaypayment'])->name('razorpaywalletpayment');

Route::post('wallet-process-mercadopago', [App\Http\Controllers\TransactionController::class, 'processMercadoPagoPayment'])->name('wallet-process-mercadopago');

Route::get('wallet-success', [App\Http\Controllers\TransactionController::class, 'success'])->name('wallet-success');

Route::get('wallet-notify', [App\Http\Controllers\TransactionController::class, 'notify'])->name('wallet-notify');

Route::get('transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');

Route::get('/offers', [App\Http\Controllers\OffersController::class, 'index'])->name('offers');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

Route::get('favorite-products', [App\Http\Controllers\FavoritesController::class, 'favProduct'])->name('favorites.product');

Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');

Route::post('setToken', [App\Http\Controllers\Auth\AjaxController::class, 'setToken'])->name('setToken');

Route::post('logout', [App\Http\Controllers\Auth\AjaxController::class, 'logout'])->name('logout');

Route::post('newRegister', [App\Http\Controllers\Auth\AjaxController::class, 'newRegister'])->name('newRegister');

Route::post('checkEmail', [App\Http\Controllers\Auth\AjaxController::class, 'checkEmail'])->name('checkEmail');

Route::post('sendemail/send', [App\Http\Controllers\SendEmailController::class, 'sendMail'])->name('sendContactUsMail');

Route::get('my_order/{id}', [App\Http\Controllers\OrderController::class, 'edit'])->name('orderDetails');

Route::post('add-cart-note', [App\Http\Controllers\OrderController::class, 'addCartNote'])->name('add-cart-note');

Route::get('page/{slug}', [App\Http\Controllers\CmsController::class, 'index'])->name('page');

Route::post('send-email', [App\Http\Controllers\SendEmailController::class, 'sendMail'])->name('sendMail');

Route::get('lang/change', [App\Http\Controllers\LangController::class, 'change'])->name('changeLang');

Route::get('forgot-password', [App\Http\Controllers\Auth\LoginController::class, 'forgotPassword'])->name('forgot-password');

Route::get('/notifications/view/{id}', [App\Http\Controllers\DynamicNotificationController::class, 'view'])->name('notifications.view');

Route::get('notifications', [App\Http\Controllers\DynamicNotificationController::class, 'index'])->name('notifications.index');

Route::get('delivery-address', [App\Http\Controllers\DeliveryAddressController::class, 'index'])->name('delivery-address.index');
Route::post('store-firebase-service', [App\Http\Controllers\HomeController::class,'storeFirebaseService'])->name('store-firebase-service');
