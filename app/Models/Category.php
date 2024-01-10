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
    protected $fillable = ['name', 'file', 'user_id', 'role_id', 'enum', 'enum2'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['name' => 'string', 'file' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    
    	
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}	
	public function role()
	{
		return $this->belongsTo(\App\Models\Role::class);
	}
    	
	public function setFileAttribute($value)
	{
		if ($value){
			$file = $value;
			$extension = $file->getClientOriginalExtension(); // getting image extension
			$filename =time().mt_rand(1000,9999).'.'.$extension;
			$file->move(public_path('files/'), $filename);
			$this->attributes['file'] =  'files/'.$filename;
		}
	}

}
