<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ContactUsController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);


    // Sections
    Route::get('allSections', [SectionController::class, 'allSections'])->name('allSections');
    Route::post('addSection', [SectionController::class, 'addSection'])->name('addSection');
    Route::post('editSection/{id}', [SectionController::class, 'editSection'])->name('editSection');


    // Food Type
    Route::post('addFoodType', [MainController::class, 'addFoodType'])->name('addFoodType');


    // Products
    Route::get('allProducts', [ProductController::class, 'allProducts'])->name('allProducts');
    Route::get('getProduct/{id}', [ProductController::class, 'getProduct'])->name('getProduct');
    Route::post('addProduct', [ProductController::class, 'addProduct'])->name('addProduct');
    Route::post('editProduct/{id}', [ProductController::class, 'editProduct'])->name('editProduct');
    Route::delete('deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');


    // Get Seller Products
    Route::get('getAllProductsSeller/{seller_id}', [ProductController::class, 'getAllProductsSeller']);
    Route::get('getSpecificeProductsSeller/{seller_id}/{section_id}', [ProductController::class, 'getSpecificeProductsSeller']);


    // Customers
    Route::get('myOrders', [CustomerController::class, 'myOrders']);


    // Sellers
    Route::get('myOrders', [SellerController::class, 'myOrders']);


    // Carts
    Route::post('addToCart/{seller_id}', [CartController::class, 'addToCart']);
    Route::get('getCustomerCart', [CartController::class, 'getCustomerCart']);
    Route::delete('deleteProductFromCart/{product_id}', [CartController::class, 'deleteProductFromCart']);


    // Confirm Order In Cart
    Route::post('confirmOrder/{seller_id}', [OrderController::class, 'confirmOrder']);



    // Orders
    // user make order must be cutomer type
    Route::get('getPendingOrders', [OrderController::class, 'getPendingOrders']);
    Route::get('getProcessingOrders', [OrderController::class, 'getProcessingOrders']);
    Route::get('getPreviousOrders', [OrderController::class, 'getPreviousOrders']);
    Route::post('cancelOrder/{order_id}', [OrderController::class, 'cancelOrder']);
    Route::post('makeOrder/{cart_id}', [OrderController::class, 'makeOrder']); // confirm order after add to cart


    // Seller Orders
    Route::get('newOrders', [UserController::class, 'newOrders']);
    Route::get('previousOrders', [UserController::class, 'previousOrders']);
    Route::get('currnetOrders', [UserController::class, 'currnetOrders']);

    Route::get('acceptPendingOrders/{customer_id}', [UserController::class, 'acceptPendingOrders']);
    Route::get('rejectPendingOrders/{customer_id}', [UserController::class, 'rejectPendingOrders']);



    // ContactUs
    Route::post('sendContactUsMessage', [ContactUsController::class, 'sendContactUsMessage']);


    //Rate
    Route::post('rateSeller/{seller_id}', [RateController::class, 'rateSeller']);
});

