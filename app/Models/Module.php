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
        'is_enable'
    ];

    public function fields(){
        return $this->hasMany(Attribute::class, 'module');
    }
}
