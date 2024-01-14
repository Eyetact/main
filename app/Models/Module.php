<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_system'
    ];

    public function fields(){
        return $this->hasMany(Attribute::class, 'module');
    }

    public function menu(){
        return $this->hasOne(MenuManager::class, 'module_id');
    }
}
