<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorycategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'password', 'password'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['name' => 'string', 'password' => 'string', 'password' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var string[]
    */
    protected $hidden = ['password', 'password'];
    
    	
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}	
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

}
