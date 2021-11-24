<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CohortBatch extends Model
{
    use HasFactory;

    protected $casts = [
        'duration' => 'hh:mm:ss'
    ];
   
}
