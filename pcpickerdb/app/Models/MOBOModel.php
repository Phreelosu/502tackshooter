<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MOBOModel extends Model
{
    protected $table = 'motherboard';
    protected $fillable = ['Motherboard_name', 'Motherboard_price', 'Motherboard_socket', 'Motherboard_form_factor_ID', 'Motherboard_max_memory_ID', 'Motherboard_memory_slots_ID', 'Motherboard_color_ID'];
}
