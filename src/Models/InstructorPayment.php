<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorPayment extends Model
{
    use HasFactory;
    protected $table = 'instructor_payments';
    protected $guarded = [];

}
