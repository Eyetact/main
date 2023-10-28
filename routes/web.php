<?php

use App\Http\Controllers\Profile\ProfileController;
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
Auth::routes();
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/dashboard', function () {
        return view('index');
    });
    Route::get('/', function () {
        return view('index');
    });

    Route::prefix('profile')->group(function () {
        Route::get('{id?}',[ProfileController::class,'index'])->name('profile.index');
        Route::post('update/{id?}',[ProfileController::class,'update'])->name('profile.update');
        Route::post('change-password/{id?}',[ProfileController::class,'changePassword'])->name('profile.change-password');
    });
});
