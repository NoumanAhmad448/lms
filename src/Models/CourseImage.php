<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseImage extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
