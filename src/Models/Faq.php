<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = ['title','name','email','message','upload_img','status','f_name','slug'];
}
