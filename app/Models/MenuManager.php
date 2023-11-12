<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuManager extends Model
{
    use HasFactory;
    protected $table='menus';
    protected $fillable=[
        'module_id',
        'menu_type',
        'name',
        'code',
        'path',
        'status',
        'include_in_menu',
        'meta_title',
        'meta_description',
        'created_date',
        'assigned_attributes',
        'sequence',
        'parent'
    ];
}
