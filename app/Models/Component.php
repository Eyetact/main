<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['attachment', 'image', 'part_no.', 'part_no'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['attachment' => 'string', 'image' => 'string', 'part_no.' => 'string', 'part_no' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    
    
    
	public function setAttachmentAttribute($value)
	{
		if ($value){
			$file = $value;
			$extension = $file->getClientOriginalExtension(); // getting image extension
			$filename =time().mt_rand(1000,9999).'.'.$extension;
			$file->move(public_path('files/'), $filename);
			$this->attributes['attachment'] =  'files/'.$filename;
		}
	}	
	public function setImageAttribute($value)
	{
		if ($value){
			$file = $value;
			$extension = $file->getClientOriginalExtension(); // getting image extension
			$filename =time().mt_rand(1000,9999).'.'.$extension;
			$file->move(public_path('files/'), $filename);
			$this->attributes['image'] =  'files/'.$filename;
		}
	}

}
