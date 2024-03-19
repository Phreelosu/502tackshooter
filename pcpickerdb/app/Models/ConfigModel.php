<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    protected $table = 'pc'; // mert a laravel egy fos?
    protected $fillable = ['Case_ID', 'CPU_ID', 'CPU_Cooler_ID', 'GPU_ID', 'IHD_ID', 'Memory_ID', 'Motherboard_ID', 'PSU_ID'];
}
