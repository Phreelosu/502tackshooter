<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSUModel extends Model
{
    protected $table = 'psu';
    protected $fillable = ['PSU_name', 'PSU_price', 'PSU_type_ID', 'PSU_efficiency_ID', 'PSU_watts', 'Modular_ID', 'PSU_color_ID'];
}
