<?php

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

    Route::controller(AttributeController::class)->prefix('attribute')->group(function () {
        Route::get('/', 'index')->name('attribute.index');
        Route::get('create', 'create')->name('attribute.create');
        Route::post('store', 'store')->name('attribute.store');
        Route::get('{attribute}/edit', 'edit')->name('attribute.edit');
        Route::post('{attribute}', 'update')->name('attribute.update');
        Route::delete('{attribute}', 'destroy')->name('attribute.destroy');
    });
    
});
