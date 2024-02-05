<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{

    public $table = 'permissions';

    public $gurded = [];


    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::user() ? Auth::user()->id : NULL;
        });
    }

    protected $appends = array('permission_data');

    public function getPermissionDataAttribute()
    {
        return $this->permissions->pluck('id', 'id');
    }

    public function scopeFilter($query)
    {
        $userDetails = Auth::user();
        if($userDetails->accessScope && $userDetails->accessScope->name == 'Group'){
            $currentGroupUser = User::whereHas('accessScope', function($q) {
                                        $q->where('name', '!=', 'Global');
                                    })
                                    ->whereHas('groups', function($q) use($userDetails){
                                        $q->whereIn('id', $userDetails->groups->pluck('id'));
                                    })
                                ->pluck('id');

            $query->whereIn('created_by',$currentGroupUser);

        }else if($userDetails->accessScope && $userDetails->accessScope->name == 'Individual'){
            $query->where('created_by',$userDetails->id);
        }
        return $query;
    }



}
