<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    protected $table = 'pc'; // mert a laravel egy fos?
    protected $fillable = ['Case_ID', 'CPU_ID', 'CPU_Cooler_ID', 'GPU_ID', 'IHD_ID', 'Memory_ID', 'Motherboard_ID', 'PSU_ID'];

    // Define the relationship with the CPU model
    public function cpu()
    {
        return $this->belongsTo(CPUModel::class, 'CPU_ID');
    }

    // Define the relationship with the GPU model
    public function gpu()
    {
        return $this->belongsTo(GPUModel::class, 'GPU_ID');
    }

    // Define the relationship with the PSU model
    public function psu()
    {
        return $this->belongsTo(PSUModel::class, 'PSU_ID');
    }

    // Define the relationship with the InternalHardDrive model
    public function internal_hard_drive()
    {
        return $this->belongsTo(IHDModel::class, 'IHD_ID');
    }

    // Define the relationship with the Memory model
    public function memory()
    {
        return $this->belongsTo(MemoryModel::class, 'Memory_ID');
    }

    // Define the relationship with the Motherboard model
    public function motherboard()
    {
        return $this->belongsTo(MOBOModel::class, 'Motherboard_ID');
    }

    // Define the relationship with the PCCase model
    public function pc_case()
    {
        return $this->belongsTo(PC_CaseModel::class, 'Case_ID');
    }

    // Define the relationship with the CPUCooler model
    public function cpu_cooler()
    {
        return $this->belongsTo(CPUCoolerModel::class, 'CPU_Cooler_ID');
    }
}
