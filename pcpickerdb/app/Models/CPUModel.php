<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CPUModel extends Model
{
    protected $table = 'cpu';
    protected $fillable = ['CPU_name', 'CPU_price', 'CPU_core_count', 'CPU_core_clock', 'CPU_boost_clock', 'CPU_graphics'];
}
