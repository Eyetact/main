<?php

namespace App\Providers\Generator;

use App\Models\MenuManager;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;


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

            $menus = MenuManager::where('include_in_menu',1)->where('parent',0)->where('is_delete',0)->get();
            return $view->with( 'side_menus', $menus );
        });











	



	





		if(Schema::hasTable('units')){
    View::composer(['admin.*', 'admin.*'], function ($view) {
            return $view->with(
                'units',
                \App\Models\Admin\Unit::select('id', 'unit_code')->get()
            );
        });
}




		if(Schema::hasTable('units')){
    View::composer(['admin.*', 'admin.*'], function ($view) {
            return $view->with(
                'units',
                \App\Models\Admin\Unit::select('id', 'unit_code')->get()
            );
        });
}




		if(Schema::hasTable('units')){
    View::composer(['admin.*', 'admin.*'], function ($view) {
            return $view->with(
                'units',
                \App\Models\Admin\Unit::select('id', 'unit_code')->get()
            );
        });
}




	}
}