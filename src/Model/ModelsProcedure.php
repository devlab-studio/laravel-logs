<?php

namespace Devlab\LaravelLogs\Models;

use App\Traits\WithExtensions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelsProcedure extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
