<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorAnn extends Model
{
    use HasFactory;
    protected $fillable = ['message'];
}
