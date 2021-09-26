<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductStockController;
use App\Http\Controllers\admin\UploadController;
use Illuminate\Support\Facades\Artisan;
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
// php artisan passport:install --force

Route::get('/', function () {
    return view('documentation');
});

// Route::post('/images',[UploadController::class,'store']);

Route::get('clear-cache',function(){
    Artisan::call('cache:clear');

    Artisan::call('config:cache');
    Artisan::call('config:clear');

    // Artisan::call('route:cache');
    Artisan::call('route:clear');

    Artisan::call('view:cache');
    Artisan::call('view:clear');

    echo 'all cache cleared';
});