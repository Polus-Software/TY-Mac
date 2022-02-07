<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleSession extends Model
{
    use HasFactory;

    protected $table = '1_on_1_sessions';
}
