<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function(){
    Route::middleware(['auth:user-api','user'])->group(function(){
        #post management
        Route::apiResource('post',PostController::class);
    });

    #user management
    Route::prefix('user')->group(function(){
        Route::post('/login',[UserController::class,'login']);
        Route::post('/register',[UserController::class,'register']);
        #user logout
        Route::post('/logout',[UserController::class,'logout'])->middleware('auth:user-api','user');
    });

    #posts
    Route::get("/posts",[PostController::class,'posts']);
});

Route::get('login',function(){
    return send_response(false, 'you are not logged in!');
})->name('login');

