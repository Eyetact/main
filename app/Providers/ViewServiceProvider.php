<?php

namespace App\Providers;

use App\Models\MenuManager;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){

            $menus = MenuManager::where('include_in_menu',1)->where('parent',0)->get();
            return $view->with( 'side_menus', $menus );
        });


		View::composer(['admin.tests.create', 'admin.tests.edit'], function ($view) {
            return $view->with(
                'materials',
                \App\Models\Material::select('id', 'material_name')->get()
            );
        });




		View::composer(['admin.tests.create', 'admin.tests.edit'], function ($view) {
            return $view->with(
                'materials',
                \App\Models\Material::select('id', 'material_name')->get()
            );
        });




		View::composer(['admin.tests.create', 'admin.tests.edit'], function ($view) {
            return $view->with(
                'materials',
                \App\Models\Material::select('id', 'material_name')->get()
            );
        });




	}
}