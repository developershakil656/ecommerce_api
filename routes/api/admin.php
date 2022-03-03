<?php

use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\category\SubCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\voucher\VoucherController;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function(){
    
    #admin login and logout
    Route::prefix('admin')->group(function(){
        Route::post('/login',[AdminController::class, 'login']);
        Route::post('/logout',[AdminController::class,'logout'])->middleware(['auth:admin-api','admin']);
    });

    #all authenticate routes
    Route::middleware(['auth:admin-api','admin'])->group(function(){
        #all api resource routes
        Route::apiResources([
            'categories' => CategoryController::class,
            'sub/categories' => SubCategoryController::class,
            'products' => ProductController::class,
            'vouchers' => VoucherController::class,
        ]);
        
        #custom trash,restore,delete,change-status
        multipleResourceUrl('/categories',Category::class);
        multipleResourceUrl('/sub/categories',SubCategory::class);
        multipleResourceUrl('/products',Product::class);
        multipleResourceUrl('/vouchers',Product::class);
    });
});


// Route::get('/dashbord',function(Request $request){
//     return send_response(true,'you are admin');
// })->middleware(['auth:admin-api','admin']);


