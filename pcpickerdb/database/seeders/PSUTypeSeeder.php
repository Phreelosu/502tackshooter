<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PSUTypeSeeder extends Seeder
{
    public function run(): void
    {
        function extractPSUTypeFromCSV($filePath) {
            $psuTypes = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $psuTypeColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'type') { 
                        $psuTypeColumnIndex = $index;
                        break;
                    }
                }
        
                if ($psuTypeColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$psuTypeColumnIndex])) {
                            $psuTypeValue = $data[$psuTypeColumnIndex];
                            $psuTypes[] = $psuTypeValue;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $psuTypes;
        }
        
        function seedPSUTypeTableFromCSV($filePath) {
            $psuTypes = extractPSUTypeFromCSV($filePath);
        
            if ($psuTypes) {
                foreach ($psuTypes as $psuType) {
                    insertPSUTypeIntoTable($psuType);
                }
            }
        }
        
        function insertPSUTypeIntoTable($psuType) {
            try {
                // Check if the PSU type already exists in the table
                $existingType = DB::table('psu_type')
                    ->where('PSU_Type', $psuType)
                    ->first();
        
                // If the PSU type does not exist, insert it into the table
                if (!$existingType) {
                    DB::table('psu_type')->insert([
                        'PSU_Type' => $psuType,
                    ]);
                }
            } catch (\Illuminate\Database\QueryException $e) {
                // Handle the exception, if needed
                if ($e->errorInfo[1] != 1062) { // If the error is not a duplicate entry error
                    throw $e;
                }
            }
        }        
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/power-supply.csv';
        seedPSUTypeTableFromCSV($csvFilePath);
    }
}
