<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['material_name', 'material_id', 'materials_eu_category', 'material_unit'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['material_name' => 'string', 'material_id' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    
    
    	
	public function setMaterialsEuCategoryAttribute($value)
	{
		if($value){$this->attributes['materials_eu_category'] = json_encode($value,true);}else{ $this->attributes['eu category'] = null; }
	}

}
