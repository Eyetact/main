<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryRegion extends Model
{
    use HasFactory;

    public $table = 'countries_region';

    protected $fillable = ['name', 'region'];
}
