<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->hasMany(User::class, 'ugroup_id' );
    }
}
