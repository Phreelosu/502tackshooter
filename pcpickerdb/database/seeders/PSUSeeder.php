<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PSUSeeder extends Seeder
{
    public function run(): void
    {
        function extractPSUFromCSV($filePath, $limit = 50) {
            $psus = array();
            $count = 0;
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $nameIndex = array_search('name', $headers);
                $priceIndex = array_search('price', $headers);
                $typeIndex = array_search('type', $headers);
                $efficiencyIndex = array_search('efficiency', $headers);
                $wattageIndex = array_search('wattage', $headers);
                $modularIndex = array_search('modular', $headers);
                $colorIndex = array_search('color', $headers);
        
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $count < $limit) {
                    $count++;
                    // Extract PSU price, ensure it's not empty
                    $price = !empty($data[$priceIndex]) ? $data[$priceIndex] : null;
                    $psus[] = [
                        'PSU_name' => $data[$nameIndex],
                        'PSU_price' => $price,
                        'PSU_type_ID' => getTypeIDsFromTable($data[$typeIndex]),
                        'PSU_efficiency_ID' => getEfficiencyIDsFromTable($data[$efficiencyIndex]),
                        'PSU_watts' => $data[$wattageIndex],
                        'Modular_ID' => getModularIDsFromTable($data[$modularIndex]),
                        'PSU_color_ID' => getPSUColorIDsFromTable($data[$colorIndex])
                    ];
                }
        
                fclose($handle);
            }
        
            return $psus;
        }                  
        
        function seedPSUTableFromCSV($filePath) {
            $psus = extractPSUFromCSV($filePath);
            
            foreach ($psus as $psu) {
                DB::table('psu')->insert($psu);
            }
        }
        
        function getTypeIDsFromTable($type) {
            $typeRow = DB::table('psu_type')->where('PSU_Type', $type)->first();
            return $typeRow ? $typeRow->id : null;
        }
        
        function getEfficiencyIDsFromTable($efficiency) {
            $efficiencyRow = DB::table('psu_efficiency')->where('PSU_Efficiency', $efficiency)->first();
            return $efficiencyRow ? $efficiencyRow->id : null;
        }
        
        function getModularIDsFromTable($modular) {
            $modularRow = DB::table('psu_modular')->where('PSU_Modular', $modular)->first();
            return $modularRow ? $modularRow->id : null;
        }
        
        function getPSUColorIDsFromTable($color) {
            $colorRow = DB::table('colors')->where('Color', $color)->first();
            return $colorRow ? $colorRow->id : null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/power-supply.csv';
        seedPSUTableFromCSV($csvFilePath);
    }
}
