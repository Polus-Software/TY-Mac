<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralChat extends Model
{
    use HasFactory;

    protected $table = 'instructor_student_chat';
}
