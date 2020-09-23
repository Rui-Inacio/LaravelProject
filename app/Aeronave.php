<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aeronave extends Model{

	/**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
	
	use SoftDeletes;
	
	public function getRouteKeyName(){
	    return 'matricula';
	}

   	protected $fillable = [
    	'matricula', 'marca', 'modelo', 'num_lugares','conta_horas','preco_hora'
   	];

    protected $primaryKey = 'matricula';
    public $incrementing = false;

}
