<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SectionController;

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
    
    Route::post('addFoodType', [MainController::class, 'addFoodType'])->name('addFoodType');

    Route::get('allProducts', [ProductController::class, 'allProducts'])->name('allProducts');
    Route::get('getProduct/{id}', [ProductController::class, 'getProduct'])->name('getProduct');
    Route::post('addProduct', [ProductController::class, 'addProduct'])->name('addProduct');
    Route::post('editProduct/{id}', [ProductController::class, 'editProduct'])->name('editProduct');
    Route::delete('deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');


    // Get Seller Products
    Route::get('getAllProductsSeller/{seller_id}', [ProductController::class, 'getAllProductsSeller']);
    Route::get('getSpecificeProductsSeller/{seller_id}/{section_id}', [ProductController::class, 'getSpecificeProductsSeller']);


    
    // Orders
    Route::get('allOrders', [OrderController::class, 'allOrders']);
    Route::post('makeOrder/{seller_id}/{section_id}', [OrderController::class, 'makeOrder']);
    
});

