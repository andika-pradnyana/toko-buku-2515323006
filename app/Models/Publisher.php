<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
class Publisher extends Model
{
    protected $fillable = ['name', 'city'];
}
