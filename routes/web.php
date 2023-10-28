<?php

use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttributeController;  

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


    Route::controller(AttributeController::class)->group(function () {
        Route::get('/attribute', 'index')->name('attribute.index');
        Route::get('attribute/create', 'create')->name('attribute.create');
        Route::post('attribute/store', 'store')->name('attribute.store');
        Route::get('attribute/{attribute}/edit', 'edit')->name('attribute.edit');
        Route::post('attribute/{attribute}', 'update')->name('attribute.update');
        Route::get('remove_attribute/{attribute}', 'destroy')->name('attribute.destroy');
        Route::post('/attribute/{attributeId}/updateStatus', 'updateStatus')->name('attribute.updateStatus');
    });
    

    Route::prefix('profile')->group(function () {
        Route::get('{id?}',[ProfileController::class,'index'])->name('profile.index');
        Route::post('update/{id?}',[ProfileController::class,'update'])->name('profile.update');
        Route::post('change-password/{id?}',[ProfileController::class,'changePassword'])->name('profile.change-password');
    });

});
