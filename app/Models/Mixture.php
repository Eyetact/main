<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mixture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['testllllo'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    
    
    
	public function setTestlllloAttribute($value)
	{
		if($value){$this->attributes['testllllo'] = json_encode($value,true);}else{ $this->attributes['testllllo'] = null; }
	}

}
