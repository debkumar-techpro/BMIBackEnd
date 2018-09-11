<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	public function Courses()
    {
        return $this->hasMany('App\Models\Course','module_id');
    } 
 	 
}
