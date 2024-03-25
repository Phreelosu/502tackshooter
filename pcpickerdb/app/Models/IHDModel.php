<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IHDModel extends Model
{
    protected $table = 'internal_hard_drive';
    protected $fillable = ['Hard_drive_name', 'Hard_drive_price', 'Hard_drive_capacity_ID', 'Hard_drive_type_ID', 'Hard_drive_cache', 'Hard_drive_form_factor_ID', 'Hard_drive_interface_ID'];
}
