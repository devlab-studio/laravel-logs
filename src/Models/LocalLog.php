<?php

namespace Devlab\LaravelLogs\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalLog extends Model
{
    use HasFactory;

    // public $timestamps = false;

    protected $table = 'logs';
    protected $fillable = ['procedure', 'created_user'];

}
