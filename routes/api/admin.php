<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\UploadController;
use App\Http\Controllers\AdminController;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ]);
        
        #custom trash,restore,delete,change-status
        multipleResourceUrl('/categories',Category::class);
        multipleResourceUrl('/sub/categories',SubCategory::class);
        multipleResourceUrl('/products',Product::class);
    });
});


// Route::get('/dashbord',function(Request $request){
//     return send_response(true,'you are admin');
// })->middleware(['auth:admin-api','admin']);


