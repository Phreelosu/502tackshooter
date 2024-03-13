<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CPU_CoolerSeeder extends Seeder
{
    public function run(): void
    {
        function extractDataFromCSV($filePath, $maxRows = 50) {
            $data = array();
            $rowCount = 0;
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $nameIndex = array_search('name', $headers);
                $priceIndex = array_search('price', $headers);
                $rpmIndex = array_search('rpm', $headers);
                $colorIndex = array_search('color', $headers);
        
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE && $rowCount < $maxRows) {
                    $name = $row[$nameIndex];
                    $price = $row[$priceIndex];
                    $rpm = $row[$rpmIndex];
                    $color = $row[$colorIndex];
        
                    if (strpos($rpm, ',') !== false) {
                        $rpmValues = explode(',', $rpm);
                        $rpmMin = isset($rpmValues[0]) ? (int)$rpmValues[0] : null;
                        $rpmMax = isset($rpmValues[1]) ? (int)$rpmValues[1] : null;
                    } else {
                        $rpmMin = $rpmMax = (int)$rpm;
                    }
        
                    $data[] = compact('name', 'price', 'rpmMin', 'rpmMax', 'color');
                    $rowCount++;
                }
        
                fclose($handle);
            }
        
            return $data;
        }        
        
        function mapColorsToIDs($colors) {
            $colorIDs = array();
            foreach ($colors as $color) {
                $colorID = getColorIDFromTable($color);
                $colorIDs[$color] = $colorID;
            }
            return $colorIDs;
        }
        
        function insertDataIntoCPUCoolerTable($data, $colorIDs) {
            foreach ($data as $row) {
                // Check if price is not empty
                if (!empty($row['price'])) {
                    $colorID = $colorIDs[$row['color']];
                    DB::table('cpu_cooler')->insert([
                        'Cooler_name' => $row['name'],
                        'Cooler_price' => $row['price'],
                        'Cooler_RPM_Min' => $row['rpmMin'],
                        'Cooler_RPM_Max' => $row['rpmMax'],
                        'Cooler_color_ID' => $colorID,
                    ]);
                }
            }
        }        
        
        function getColorIDFromTable($color) {
            $colorRow = DB::table('colors')->where('Color', $color)->first();
            if ($colorRow) {
                return $colorRow->id;
            }
            return null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/cpu-cooler.csv';
        
        $data = extractDataFromCSV($csvFilePath, 50);
        
        $colors = array_unique(array_column($data, 'color'));
        
        $colorIDs = mapColorsToIDs($colors);
        
        insertDataIntoCPUCoolerTable($data, $colorIDs);
    }
}
