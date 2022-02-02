<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleSessionUser extends Model
{
    use HasFactory;

    protected $table = 'single_session_users';
}
