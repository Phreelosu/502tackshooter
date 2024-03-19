<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemorySeeder extends Seeder
{
    public function run(): void
    {
        function extractMemoryFromCSV($filePath, $limit = 50) {
            $memories = array();
            $count = 0;
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $nameIndex = array_search('name', $headers);
                $priceIndex = array_search('price', $headers);
                $speedIndex = array_search('speed', $headers);
                $modulesIndex = array_search('modules', $headers);
                $colorIndex = array_search('color', $headers);
                $firstWordLatencyIndex = array_search('first_word_latency', $headers);
                $casLatencyIndex = array_search('cas_latency', $headers);
        
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $count < $limit) {
                    $count++;
                    $speed = cleanMemorySpeed($data[$speedIndex]);
                    $memory = [
                        'Memory_name' => $data[$nameIndex],
                        'Memory_price' => $data[$priceIndex] !== '' ? $data[$priceIndex] : null,
                        'Memory_speed' => $speed,
                        'Memory_modules_ID' => getMemoryModuleIDsFromTable($data[$modulesIndex]),
                        'Memory_color_ID' => getMemoryColorIDsFromTable($data[$colorIndex]),
                        'First_word_latency' => $data[$firstWordLatencyIndex],
                        'CAS_latency' => $data[$casLatencyIndex],
                    ];
                    $memories[] = $memory;
                }
        
                fclose($handle);
            }
        
            return $memories;
        }
        
        function seedMemoryTableFromCSV($filePath) {
            $memories = extractMemoryFromCSV($filePath);
            
            foreach ($memories as $memory) {
                DB::table('memory')->insert($memory);
            }
        }
        
        function cleanMemorySpeed($speed) {
            // Remove non-numeric characters and convert to integer
            return preg_replace("/[^0-9]/", "", $speed);
        }
        
        function getMemoryModuleIDsFromTable($moduleName) {
            $moduleRow = DB::table('memory_modules')->where('memory_modules', $moduleName)->first();
            return $moduleRow ? $moduleRow->id : null;
        }
        
        function getMemoryColorIDsFromTable($color) {
            $colorRow = DB::table('colors')->where('Color', $color)->first();
            return $colorRow ? $colorRow->id : null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/memory.csv';
        seedMemoryTableFromCSV($csvFilePath);
    }
}
