<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseParticipant extends Model
{
    //
    public function Course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
