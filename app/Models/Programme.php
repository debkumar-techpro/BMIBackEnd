<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    public function module()
    {
        return $this->hasMany('App\Models\Module','programme_id');
    }
    
    public function course()
    {
        return $this->hasMany('App\Models\Course','programme_id');
    }  
}
