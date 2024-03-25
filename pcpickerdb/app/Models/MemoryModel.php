<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoryModel extends Model
{
    protected $table = 'memory';
    protected $fillable = ['Memory_name', 'Memory_price', 'Memory_speed', 'Memory_modules_ID', 'Memory_color_ID', 'First_word_latency', 'CAS_latency'];
}
