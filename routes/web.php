<?php

use App\Helpers\Helper;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\MenuManagerController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleManagerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGroupController;
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
        Route::get('/attribute-by-module/{module}', 'getAttrByModel')->name('attribute.get');
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
        Route::get('{id?}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('update/{id?}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('change-password/{id?}', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('profile-upload/{id?}', [ProfileController::class, 'uploadProfileImage'])->name('profile.upload-image');
    });

    Route::get('example-datatable', function () {
        return view('example_datatable.index');
    });

    Route::controller(SettingController::class)->group(function () {
        Route::get('/setting', 'index')->name('setting.index');
        //        Route::get('/setting/countries', 'countries')->name('setting.countries')->middleware('permission:countries.setting');
//        Route::get('/setting/status/{id}/{status}', 'settingCountry')->name('setting.status')->middleware('permission:countries.status');
//        Route::get('/setting/states', 'states')->name('setting.states')->middleware('permission:states.setting');
//        Route::get('/setting/cities', 'cities')->name('setting.cities')->middleware('permission:cities.setting');
        Route::post('/setting', 'store')->name('setting.store');
        Route::post('/storeUrl', 'storeUrl')->name('setting.store.url');
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

    Route::post('theme-setting/update', [Helper::class, 'update'])->name('update.theme');

    Route::controller(ModuleManagerController::class)->group(function () {
        Route::get('/module_manager', 'index')->name('module_manager.index');
        Route::get('module_manager/create', 'create')->name('module_manager.create');
        Route::post('module_manager/store', 'store')->name('module_manager.store');
        Route::post('module_manager/menu_update', 'menu_update')->name('module_manager.menu_update');
        Route::get('module_manager/{module}/edit', 'edit')->name('module_manager.edit');
        // Route::post('module_manager/{menu}', 'update')->name('module_manager.update');
        Route::post('module_manager/update/{module}', 'update')->name('module_manager.update');
        Route::delete('module_manager/{menu}', 'destroy')->name('module_manager.destroy');

        // update is deleted menu item
        Route::post('module_manager/menu_delete', 'menuDelete')->name('module_manager.menu_delete');
    });
    Route::get('/myadmins/{user_id}', [UserController::class, 'myAdmins'])->name('users.myadmins');
    Route::get('/vendors', [UserController::class, 'vendors'])->name('users.vendors');
    Route::get('/admins', [UserController::class, 'admins'])->name('users.admins');
    Route::get('/users', [UserController::class, 'users'])->name('users.users');

    Route::post('add-user', [UserController::class, 'store'])->name('users.store');

    Route::get('add-user', [UserController::class, 'create'])->name('users.create');
    Route::get('add-vendor', [UserController::class, 'createvendor'])->name('vendor.create');
    Route::get('add-admin', [UserController::class, 'createAdmin'])->name('admin.create');

    Route::get('add-admin', [UserController::class, 'createAdmin'])->name('admin.create');

    Route::get('/user/{id}', [UserController::class, 'show'])->name('users.view');

    Route::post('/user/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('/', 'index')->name('role.index');
        Route::get('create', 'create')->name('role.create')->middleware('can:create.role');
        Route::post('store', 'store')->name('role.store')->middleware('can:create.role');
        Route::get('{role}/edit', 'edit')->name('role.edit')->middleware('can:edit.role');
        Route::post('{role}', 'update')->name('role.update')->middleware('can:edit.role');
        Route::post('delete/{role}', 'destroy')->name('role.destroy')->middleware('can:delete.role');
        Route::get('permission', 'assignPermissionList')->name('role.permission.index');
    });

    Route::controller(PermissionController::class)->prefix('permission')->group(function () {
        Route::get('/', 'index')->name('permission.index')->middleware('can:view.permission');
        Route::get('create', 'create')->name('permission.create')->middleware('can:create.permission');
        Route::post('store', 'store')->name('permission.store')->middleware('can:create.permission');
        Route::get('{permission}/edit', 'edit')->name('permission.edit')->middleware('can:edit.permission');
        Route::post('update', 'update')->name('permission.update')->middleware('can:edit.can');
        Route::delete('{permission}', 'destroy')->name('permission.destroy')->middleware('can:delete.permission');

        Route::post('permission/delete/{id}', 'deleteSinglePermission')->name('permission.delete')->middleware('can:delete.permission');

        Route::post('module/store', 'moduleStore')->name('permission.module');
    });

    //plan
    Route::get('/plans', [planController::class, 'index'])->name('plans.index');

    Route::get('add-plan', [planController::class, 'create'])->name('plans.create');
    Route::post('add-plan', [planController::class, 'store'])->name('plans.store');

    Route::get('/plan/{id}', [planController::class, 'show'])->name('plans.view');
    Route::post('update-plan/{id}', [planController::class, 'update'])->name('plans.update');

    Route::post('/plan/delete/{id}', [planController::class, 'destroy'])->name('plans.destroy');

    //subscription
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    Route::get('add-subscription', [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('add-subscription', [SubscriptionController::class, 'store'])->name('subscriptions.store');

    Route::get('/subscription/{id}', [SubscriptionController::class, 'show'])->name('subscriptions.view');
    Route::post('update-subscription/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');

    Route::post('/subscription/delete/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

    //customer group
    Route::get('/groups', [CustomerGroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/sub/{id}', [CustomerGroupController::class, 'sub'])->name('groups.sub');

    Route::get('add-group', [CustomerGroupController::class, 'create'])->name('groups.create');
    Route::post('add-group', [CustomerGroupController::class, 'store'])->name('groups.store');

    Route::get('/group/{id}', [CustomerGroupController::class, 'show'])->name('groups.view');
    Route::get('/showCustomer/{id}', [CustomerGroupController::class, 'showCustomer'])->name('groups.view2');
    Route::post('update-group/{id}', [CustomerGroupController::class, 'update'])->name('groups.update');

    Route::post('/group/delete/{id}', [CustomerGroupController::class, 'destroy'])->name('groups.destroy');

    //user group
    Route::get('/user-groups', [UserGroupController::class, 'index'])->name('ugroups.index');
    Route::get('/user-groups/sub/{id}', [UserGroupController::class, 'sub'])->name('ugroups.sub');

    Route::get('add-user-group', [UserGroupController::class, 'create'])->name('ugroups.create');
    Route::post('add-user-group', [UserGroupController::class, 'store'])->name('ugroups.store');

    Route::get('/user/group/{id}', [UserGroupController::class, 'show'])->name('ugroups.view');
    Route::get('/user/group/users/{id}', [UserGroupController::class, 'showUsers'])->name('ugroups.view2');
    Route::post('update-user-group/{id}', [UserGroupController::class, 'update'])->name('ugroups.update');

    Route::post('/user-group/delete/{id}', [UserGroupController::class, 'destroy'])->name('ugroups.destroy');



    Route::get('/files', [FileManagerController::class, 'index'])->name('files');
    Route::post('/files', [FileManagerController::class, 'newFile'])->name('files');
    Route::get('/new-folder', [FileManagerController::class, 'newFolder'])->name('newfolder');
    Route::post('/new-folder', [FileManagerController::class, 'newFolder'])->name('newfolder');


    Route::get('/new-file', [FileManagerController::class, 'newFile'])->name('newfile');
    Route::post('/new-file', [FileManagerController::class, 'newFile'])->name('newfile');



    Route::get('/view-folder/{id}', [FileManagerController::class, 'viewfolder'])->name('viewfolder');

    Route::get('/show-folder/{id}', [FileManagerController::class, 'showFolder'])->name('showfolder');
    Route::post('update-folder/{id}', [FileManagerController::class, 'updateFolder'])->name('folder.update');


    Route::post('/folder/delete/{id}', [FileManagerController::class, 'destroyFolder'])->name('folder.destroy');

    Route::get('/show-file/{id}', [FileManagerController::class, 'showFile'])->name('showfile');
    Route::post('update-file/{id}', [FileManagerController::class, 'updateFile'])->name('file.update');


    Route::post('/file/delete/{id}', [FileManagerController::class, 'destroyFile'])->name('file.destroy');

    Route::get('/file/download/{id}', [FileManagerController::class,'downloadFile'])->name('downloadfile');

    Route::get('/file/share/{id}', [FileManagerController::class,'shareFile'])->name('sharefile');


    Route::get('/file/images/{id}', [FileManagerController::class,'images'])->name('images');
    Route::get('/file/videos/{id}', [FileManagerController::class,'videos'])->name('videos');
    Route::get('/file/docs/{id}', [FileManagerController::class,'docs'])->name('docs');
    Route::get('/file/music/{id}', [FileManagerController::class,'music'])->name('music');
    Route::get('/file/search/{key}', [FileManagerController::class,'search'])->name('search');

    Route::get('/file/open/{id}', [FileManagerController::class, 'openFile'])->name('open.file');

    Route::get('/file/open/{id}', [FileManagerController::class, 'openFile'])->name('open.file');


    Route::get('testview', function(){
        return view('test');
    });

});

Route::get('Test', [ App\Http\Controllers\Admin\TestController::class, 'index' ])->middleware('auth');

Route::resource('tests', App\Http\Controllers\Admin\TestController::class)->middleware('auth');
Route::get('materials', [ App\Http\Controllers\Admin\MaterialController::class, 'index' ])->middleware('auth');

Route::resource('materials', App\Http\Controllers\Admin\MaterialController::class)->middleware('auth');
Route::get('mixtures', [ App\Http\Controllers\Admin\MixtureController::class, 'index' ])->middleware('auth');

Route::resource('mixtures', App\Http\Controllers\Admin\MixtureController::class)->middleware('auth');
Route::get('components', [ App\Http\Controllers\Admin\ComponentController::class, 'index' ])->middleware('auth');

Route::resource('components', App\Http\Controllers\Admin\ComponentController::class)->middleware('auth');
Route::get('machines', [ App\Http\Controllers\Admin\MachineController::class, 'index' ])->middleware('auth');

Route::resource('machines', App\Http\Controllers\Admin\MachineController::class)->middleware('auth');

Route::get('test', [ App\Http\Controllers\Admin\TestController::class, 'index' ])->middleware('auth');

Route::resource('tests', App\Http\Controllers\Admin\TestController::class)->middleware('auth');
Route::get('category', [ App\Http\Controllers\Admin\CategoryController::class, 'index' ])->middleware('auth');

Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->middleware('auth');
Route::get('product', [ App\Http\Controllers\Admin\ProductController::class, 'index' ])->middleware('auth');

Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->middleware('auth');
Route::get('intro', [ App\Http\Controllers\Admin\IntroController::class, 'index' ])->middleware('auth');

Route::resource('intros', App\Http\Controllers\Admin\IntroController::class)->middleware('auth');
Route::get('page', [ App\Http\Controllers\Admin\PageController::class, 'index' ])->middleware('auth');

Route::resource('pages', App\Http\Controllers\Admin\PageController::class)->middleware('auth');
Route::get('category', [ App\Http\Controllers\Admin\CategoryController::class, 'index' ])->middleware('auth');

Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->middleware('auth');
Route::get('admin1', [ App\Http\Controllers\Admin\Admin1Controller::class, 'index' ])->middleware('auth');

Route::resource('admin1s', App\Http\Controllers\Admin\Admin1Controller::class)->middleware('auth');
Route::get('vendor1', [ App\Http\Controllers\Admin\Vendor1Controller::class, 'index' ])->middleware('auth');

Route::resource('vendor1s', App\Http\Controllers\Admin\Vendor1Controller::class)->middleware('auth');
Route::get('product', [ App\Http\Controllers\Admin\ProductController::class, 'index' ])->middleware('auth');

Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->middleware('auth');
Route::get('cat', [ App\Http\Controllers\Admin\CategoryController::class, 'index' ])->middleware('auth');

Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->middleware('auth');
Route::get('product', [ App\Http\Controllers\Admin\ProductController::class, 'index' ])->middleware('auth');

Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->middleware('auth');