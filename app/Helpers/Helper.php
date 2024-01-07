<?php

namespace App\Helpers;

use App\Models\ThemeSetting;
use App\Models\MenuManager;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Helper
{
    public static function update(Request  $request)
    {
        $classes = $request->classes;
        $themeSetting = ThemeSetting::where('user_id',Auth::id())->first();
        if(!filled($themeSetting)){
            $themeSetting = new ThemeSetting();
        }
        $classes = Str::replace('app','',$classes);
        $classes = Str::replace('sidebar-mini','',$classes);
        $themeSetting->user_id = Auth::id();
        $themeSetting->theme_classes = $classes;
        $themeSetting->save();
        return true;
    }

    public static function getThemeClasses()
    {
        $themeSetting = ThemeSetting::where('user_id', Auth::id())->first();
        if (filled($themeSetting)) {
            return $themeSetting->theme_classes;
            // Use $themeClasses as needed
        }
    }

    public static function getMenu($type) {
        $data=MenuManager::with('children.children.children')->where('parent','0')->where('menu_type',$type)->where('include_in_menu',1)->orderBy('id','asc')->get();
        return $data;
    }
}
