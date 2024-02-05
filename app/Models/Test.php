<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['color', 'material_id', 'multi'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    
    	
	public function material()
	{
		return $this->belongsTo(\App\Models\Material::class);
	}
    
	public function setColorAttribute($value)
	{
		if($value){$this->attributes['color'] = json_encode($value,true);}else{ $this->attributes['colors'] = null; }
	}	
	public function setMultiAttribute($value)
	{
		if($value){$this->attributes['multi'] = json_encode($value,true);}else{ $this->attributes['multi'] = null; }
	}

}
