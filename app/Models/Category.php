<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['category', 'date'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['category' => 'integer', 'date' => 'date:d/m/Y', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    
    
    

}
