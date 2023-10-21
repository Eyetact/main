<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'field_type',
        'input_name',
        'input_class',
        'input_id',
        'is_required',
        'validation_message',
        'fields_info',
        'description'
    ];
}
