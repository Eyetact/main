<?php

namespace App\Helpers;



use App\Models\ThemeSetting;
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
        return ThemeSetting::where('user_id',Auth::id())->first()->theme_classes;
    }
}
