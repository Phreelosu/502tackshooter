<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MOBOMMModel extends Model
{
    protected $table = 'mobo_max_memory';
    protected $fillable = ['MOBO_Max_Memory'];
}
