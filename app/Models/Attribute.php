<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'module',
        'name',
        'field_type',
        'input_name',
        'input_class',
        'input_id',
        'is_required',
        'is_system',
        'fields_info',
        'is_enable',
        'scope',
        'depend',
        'attribute',
        'validation',
        'description'
    ];
}
