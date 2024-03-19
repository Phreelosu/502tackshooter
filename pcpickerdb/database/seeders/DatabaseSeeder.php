<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ColorSeeder::class,
            CaseTypeSeeder::class,
            SidePanelTypesSeeder::class,
            PC_CaseSeeder::class,
            CPUSeeder::class,
            CPU_CoolerSeeder::class,
            GPU_MemorySeeder::class,
            GPUSeeder::class,
            IHD_CapacitySeeder::class,
            IHD_FormFactorSeeder::class,
            IHD_InterfaceSeeder::class,
            IHD_TypeSeeder::class,
            IHDSeeder::class,
            MemoryModulesSeeder::class,
            MemorySeeder::class,
            MOBOFFSeeder::class,
            MOBOMMSeeder::class,
            MOBOMSSeeder::class,
            MOBOSeeder::class,
            PSUEfficiencySeeder::class,
            PSUModularSeeder::class,
            PSUTypeSeeder::class,
            PSUSeeder::class,
        ]);
    }
}
