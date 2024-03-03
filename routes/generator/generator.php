<?php
Route::get('product', [ App\Http\Controllers\Admin\ProductController::class, 'index' ])->middleware('auth');

Route::get('create-less/products', [ App\Http\Controllers\Admin\ProductController::class, 'createLess' ])->middleware('auth');

Route::get('edit-less/products/{id}', [ App\Http\Controllers\Admin\ProductController::class, 'editLess' ])->middleware('auth');

Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->middleware('auth');