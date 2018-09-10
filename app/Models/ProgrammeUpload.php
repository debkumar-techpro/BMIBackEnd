<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammeUpload extends Model
{
    protected $fillable = [
        'unique_id', 'name',
    ];
}
