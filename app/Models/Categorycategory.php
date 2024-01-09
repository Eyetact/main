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
    protected $fillable = ['name', 'password', 'file', 'user_id', 'enum', 'int'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['name' => 'string', 'password' => 'string', 'file' => 'string', 'int' => 'integer', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var string[]
    */
    protected $hidden = ['password'];
    	
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
    	
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
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
