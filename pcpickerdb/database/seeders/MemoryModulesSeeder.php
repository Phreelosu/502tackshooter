<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemoryModulesSeeder extends Seeder
{
    public function run(): void
    {
        function extractMemoryModulesFromCSV($filePath) {
            $memoryModules = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $memoryModuleColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'modules') { 
                        $memoryModuleColumnIndex = $index;
                        break;
                    }
                }
        
                if ($memoryModuleColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$memoryModuleColumnIndex])) {
                            $memoryModule = $data[$memoryModuleColumnIndex];
                            $memoryModules[] = $memoryModule;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $memoryModules;
        }
        
        function mapMemoryModulesToIDs($memoryModules) {
            $memoryModuleIDs = array();
            foreach ($memoryModules as $memoryModule) {
                $memoryModuleID = getMemoryModuleIDFromTable($memoryModule); // Retrieve the ID for the current memory module
                $memoryModuleIDs[$memoryModule] = $memoryModuleID; // Assign the retrieved ID to the current memory module
            }
            return $memoryModuleIDs;
        }        
        
        function seedMemoryModulesTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $memoryModules = extractMemoryModulesFromCSV($filePath);
                $memoryModuleIDs = mapMemoryModulesToIDs($memoryModules);
                
                // seeding process
                foreach ($memoryModuleIDs as $memoryModule => $memoryModuleIDs) {
                    insertMemoryModuleIntoTable($memoryModule, $memoryModuleIDs);
                }
            }
        }
        
        function insertMemoryModuleIntoTable($memoryModule, $memoryModuleIDs) {
            try {
                DB::table('memory_modules')->insert([
                    'memory_modules' => $memoryModule,
                    'id' => $memoryModuleIDs
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) { // If there's a duplicate entry
                    // Ignore the error and continue
                    return;
                } else {
                    throw $e;
                }
            }
        }        
        
        function getMemoryModuleIDFromTable($memoryModule) {
            $memoryModuleRow = DB::table('memory_modules')->where('memory_modules', $memoryModule)->first();
            if ($memoryModuleRow) {
                return $memoryModuleRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '/assets/unprocessedpaths/memory.csv',
        );
        seedMemoryModulesTableFromCSVs($csvFilePaths);
    }
}
