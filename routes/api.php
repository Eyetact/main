<?php

use App\Http\Controllers\Api\CategoryController;
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
   Route::get('categories/{id}', [CategoryController::class, 'listCategories']);

});


