<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;
    protected $fillable = ['course_id','user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }

}
