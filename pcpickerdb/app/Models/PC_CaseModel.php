<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PC_CaseModel extends Model
{
    protected $table = 'pc_case'; // mert a laravel egy fos?
    protected $fillable = ['Case_name', 'Case_price', 'Case_type_ID', 'PSU_Watts', 'Side_panel_ID', 'Bay_count'];
}
