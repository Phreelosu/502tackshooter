<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MOBOSeeder extends Seeder
{
    public function run(): void
    {
        function extractMotherboardsFromCSV($filePath, $limit = 50) {
            $motherboards = array();
            $count = 0;
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $nameIndex = array_search('name', $headers);
                $priceIndex = array_search('price', $headers);
                $socketIndex = array_search('socket', $headers);
                $formFactorIndex = array_search('form_factor', $headers);
                $maxMemoryIndex = array_search('max_memory', $headers);
                $memorySlotsIndex = array_search('memory_slots', $headers);
                $colorIndex = array_search('color', $headers);
        
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $count < $limit) {
                    $count++;
                    $motherboards[] = [
                        'Motherboard_name' => $data[$nameIndex],
                        'Motherboard_price' => $data[$priceIndex],
                        'Motherboard_socket' => $data[$socketIndex],
                        'Motherboard_form_factor_ID' => getFormFactorIDsFromTable($data[$formFactorIndex]),
                        'Motherboard_max_memory_ID' => getMaxMemoryIDsFromTable($data[$maxMemoryIndex]),
                        'Motherboard_memory_slots_ID' => getMemorySlotsIDsFromTable($data[$memorySlotsIndex]),
                        'Motherboard_color_ID' => getMOBOColorIDsFromTable($data[$colorIndex])
                    ];
                }
        
                fclose($handle);
            }
        
            return $motherboards;
        }        
        
        function seedMotherboardsTableFromCSV($filePath) {
            $motherboards = extractMotherboardsFromCSV($filePath);
            
            foreach ($motherboards as $motherboard) {
                DB::table('motherboard')->insert($motherboard);
            }
        }
        
        function getFormFactorIDsFromTable($formFactor) {
            $formFactorRow = DB::table('mobo_form_factor')->where('MOBO_Form_Factor', $formFactor)->first();
            return $formFactorRow ? $formFactorRow->id : null;
        }
        
        function getMaxMemoryIDsFromTable($maxMemory) {
            $maxMemoryRow = DB::table('mobo_max_memory')->where('MOBO_Max_Memory', $maxMemory)->first();
            return $maxMemoryRow ? $maxMemoryRow->id : null;
        }
        
        function getMemorySlotsIDsFromTable($memorySlots) {
            $memorySlotsRow = DB::table('mobo_memory_slots')->where('MOBO_Memory_Slots', $memorySlots)->first();
            return $memorySlotsRow ? $memorySlotsRow->id : null;
        }
        
        function getMOBOColorIDsFromTable($color) {
            $colorRow = DB::table('colors')->where('Color', $color)->first();
            return $colorRow ? $colorRow->id : null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/motherboard.csv';
        seedMotherboardsTableFromCSV($csvFilePath);
    }
}
