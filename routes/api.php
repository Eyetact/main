<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ComponentSetController;
use App\Http\Controllers\Api\MixtureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Auth
Route::post('login', [AuthController::class, 'login']);

Route::post('user-reg', [AuthController::class, 'store']);

Route::post('check-user', [AuthController::class, 'sendOtp']);

Route::post('check-otp', [AuthController::class, 'checkOTP']);

Route::post('update-password', [AuthController::class, 'changePassword']);

Route::post('update-user', [AuthController::class, 'updateById']);





Route::middleware(['auth:api'])->group(function () {

    Route::get('my-config', [AuthController::class, 'config']);


    //Category
    Route::get('categories/{id}', [CategoryController::class, 'categories']);

    Route::post('category-create', [CategoryController::class, 'save']);
    Route::get('category/{id}', [CategoryController::class, 'view']);
    Route::get('category/delete/{id}', [CategoryController::class, 'delete']);
    Route::post('category/edit/{id}', [CategoryController::class, 'edit']);


    //Components
    Route::get('components/{id}', [ComponentSetController::class, 'components']);

    Route::post('component-create', [ComponentSetController::class, 'save']);
    Route::get('component/{id}', [ComponentSetController::class, 'view']);
    Route::get('component/delete/{id}', [ComponentSetController::class, 'delete']);
    Route::post('component/edit/{id}', [ComponentSetController::class, 'edit']);


    //mixtures
    Route::get('mixtures/{id}', [MixtureController::class, 'mixtures']);


});


