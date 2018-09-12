<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFormat extends Model
{
	protected $fillable = ['class_id','days','schedule', 'created_at'];
    // public function classes()
    // {
    //     return $this->belongsTo(ClassFormat::class);
    // }
}
