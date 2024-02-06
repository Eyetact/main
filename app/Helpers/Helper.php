<?php

namespace App\Helpers;

use App\Models\MenuManager;
use App\Models\Permission;
use App\Models\ThemeSetting;
use App\Models\Module;
use App\Models\UCGroup;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Helper
{
    public static function update(Request $request)
    {
        $classes = $request->classes;
        $themeSetting = ThemeSetting::where('user_id', Auth::id())->first();
        if (!filled($themeSetting)) {
            $themeSetting = new ThemeSetting();
        }
        $classes = Str::replace('app', '', $classes);
        $classes = Str::replace('sidebar-mini', '', $classes);
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

    // public static function getMenu($type) {
    //     $data=MenuManager::with('children.children.children')->where('parent','0')->where('menu_type',$type)->orderBy('id','asc')->get();
    //     return $data;
    // }

    public static function getMenu($type)
    {



        // if (auth()->user()->access_table == "Group") {
        //     $group_ids = auth()->user()->groups()->pluck('group_id');

        //     $userids= UCGroup::whereIn('group_id', $group_ids)
        //     ->pluck('user_id');

        //     $module_ids = Module::whereIn('user_id', $userids)
        //         ->pluck('id');
        //         // dd($module_ids);

        //     $data = MenuManager::with('children.children.children')
        //         ->where('parent', '0')
        //         ->where('menu_type', $type)
        //         ->whereIn('module_id', $module_ids)
        //         ->orderBy('sequence', 'asc')
        //         ->get();

        //     return $data;
        // }

        // if (auth()->user()->access_table == "Individual") {

        //     $module_ids = Module::where('user_id', auth()->user()->id)
        //         ->pluck('id');

        //     $data = MenuManager::with('children.children.children')
        //         ->where('parent', '0')
        //         ->where('menu_type', $type)
        //         ->whereIn('module_id', $module_ids) // Filter by module_id
        //         ->orderBy('sequence', 'asc')
        //         ->get();

        //     return $data;

        // }

        //global

        $data = MenuManager::with('children.children.children')->where('parent', '0')->where('menu_type', $type)->orderBy('sequence', 'asc')->get();
        return $data;
    }


    public function canWithCount($name,$created_at){
        $count      = Permission::where('name',$name)->first()->count;
        $count_type = Permission::where('name',$name)->first()->count_type;

        if($count == 0){
            return true;
        }

        switch ($count_type) {
            case 'days':
                $date = Carbon::parse($created_at);
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff <=  $count){
                    return true;
                }
                break;
            
            default:
                # code...
                break;
        }

        return false;
        
    }

}


