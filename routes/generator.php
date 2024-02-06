<?php


Route::get('test', [ App\Http\Controllers\Admin\TestController::class, 'index' ])->middleware('auth');

Route::resource('tests', App\Http\Controllers\Admin\TestController::class)->middleware('auth');