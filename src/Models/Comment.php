<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function rating()
    {
        return $this->hasOne(RatingModal::class,'student_id','user_id');
    }
}
