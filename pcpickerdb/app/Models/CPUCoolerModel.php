<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CPUCoolerModel extends Model
{
    protected $table = 'cpu_cooler';
    protected $fillable = ['Cooler_name', 'Cooler_price', 'Cooler_RPM', 'Cooler_color_ID', 'Cooler_RPM_Min', 'Cooler_RPM_Max'];
}
