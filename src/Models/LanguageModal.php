<?php

namespace Eren\Lms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageModal extends Model
{
    use HasFactory;
    protected $table;
    public $timestamps = false;

    public function __construct(){
        $this->table = 'languages';
    }
}
