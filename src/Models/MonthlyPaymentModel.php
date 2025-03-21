<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPaymentModel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','month','payment'];
}
