<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPUModel extends Model
{
    protected $table = 'gpu';
    protected $fillable = ['GPU_name', 'GPU_price', 'GPU_chipset', 'GPU_memory_ID', 'GPU_core_clock', 'GPU_boost_clock', 'GPU_color_ID', 'GPU_length'];
}
