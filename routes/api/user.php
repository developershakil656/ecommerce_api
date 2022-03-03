<?php

use App\Http\Controllers\order\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function(){
    Route::middleware(['auth:user-api','user'])->group(function(){
        Route::post('/make/order',[OrderController::class,'store']);
        Route::get('/view/all/order',[OrderController::class,'index']);
    });

    #user management
    Route::post('/login',[UserController::class,'login']);
    Route::post('/register',[UserController::class,'register']);
    #user logout
    Route::post('/logout',[UserController::class,'logout'])->middleware('auth:user-api','user');

});

Route::get('login',function(){
    return send_response(false, 'you are not logged in!');
})->name('login');

