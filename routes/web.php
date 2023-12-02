<?php

use App\Helpers\Helper;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SmtpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\MenuManagerController;
use App\Http\Controllers\ModuleManagerController;

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


    Route::controller(ModuleController::class)->group(function () {
        Route::get('/module', 'index')->name('module.index');
        Route::get('module/create', 'create')->name('module.create');
        Route::post('module/store', 'store')->name('module.store');
        Route::get('module/{module}/edit', 'edit')->name('module.edit');
        Route::post('module/{module}', 'update')->name('module.update');
        Route::get('remove_module/{module}', 'destroy')->name('module.destroy');
        Route::post('/module/{moduleId}/updateStatus', 'updateStatus')->name('module.updateStatus');
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

    Route::controller(MenuManagerController::class)->group(function () {
        Route::get('/menu', 'index')->name('menu.index');
        Route::get('menu/create', 'create')->name('menu.create');
        Route::post('menu/store', 'store')->name('menu.store');
        Route::post('menu/menu_update', 'menu_update')->name('menu.menu_update');
        Route::get('menu/{menu}/edit', 'edit')->name('menu.edit');
        Route::post('menu/{menu}', 'update')->name('menu.update');
        Route::delete('menu/{menu}', 'destroy')->name('menu.destroy');


    });

    Route::prefix('profile')->group(function () {
        Route::get('{id?}',[ProfileController::class,'index'])->name('profile.index');
        Route::post('update/{id?}',[ProfileController::class,'update'])->name('profile.update');
        Route::post('change-password/{id?}',[ProfileController::class,'changePassword'])->name('profile.change-password');
        Route::post('profile-upload/{id?}',[ProfileController::class,'uploadProfileImage'])->name('profile.upload-image');
    });

    Route::get('example-datatable',function (){
        return view('example_datatable.index');
    });

    Route::controller(SettingController::class)->group(function () {
        Route::get('/setting', 'index')->name('setting.index');
//        Route::get('/setting/countries', 'countries')->name('setting.countries')->middleware('permission:countries.setting');
//        Route::get('/setting/status/{id}/{status}', 'settingCountry')->name('setting.status')->middleware('permission:countries.status');
//        Route::get('/setting/states', 'states')->name('setting.states')->middleware('permission:states.setting');
//        Route::get('/setting/cities', 'cities')->name('setting.cities')->middleware('permission:cities.setting');
        Route::post('/setting', 'store')->name('setting.store');
    });

    Route::controller(SmtpController::class)->group(function () {
        Route::get('/smtp', 'index')->name('smtp.index');
        Route::get('smtp/create', 'create')->name('smtp.create');
        Route::post('smtp/store', 'store')->name('smtp.store');
        Route::get('smtp/{smtp}/edit', 'edit')->name('smtp.edit');
        Route::post('smtp/{smtp}', 'update')->name('smtp.update');
        Route::delete('smtp/{smtp}', 'destroy')->name('smtp.destroy');
    });

    Route::controller(MailboxController::class)->group(function () {
        Route::get('/main_mailbox', 'index')->name('main_mailbox.index');
        Route::get('main_mailbox/create', 'create')->name('main_mailbox.create');
        Route::post('main_mailbox/store', 'store')->name('main_mailbox.store');
        Route::get('main_mailbox/{main_mailbox}/edit', 'edit')->name('main_mailbox.edit');
        Route::post('main_mailbox/{main_mailbox}', 'update')->name('main_mailbox.update');
        Route::delete('main_mailbox/{main_mailbox}', 'destroy')->name('main_mailbox.destroy');
    });

    Route::post('theme-setting/update',[Helper::class,'update'])->name('update.theme');

    Route::controller(ModuleManagerController::class)->group(function () {
        Route::get('/module_manager', 'index')->name('module_manager.index');
        Route::get('module_manager/create', 'create')->name('module_manager.create');
        Route::post('module_manager/store', 'store')->name('module_manager.store');
        Route::post('module_manager/menu_update', 'menu_update')->name('module_manager.menu_update');
        Route::get('module_manager/{menu}/edit', 'edit')->name('module_manager.edit');
        // Route::post('module_manager/{menu}', 'update')->name('module_manager.update');
        Route::post('module_manager/update/{menu?}', 'update')->name('module_manager.update');
        Route::delete('module_manager/{menu}', 'destroy')->name('module_manager.destroy');

        // update is deleted menu item
        Route::post('module_manager/menu_delete', 'menuDelete')->name('module_manager.menu_delete');
    });
});
