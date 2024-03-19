<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PSUModularSeeder extends Seeder
{
    public function run(): void
    {
        function extractPSUModularFromCSV($filePath) {
            $psuModular = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $psuModularColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'modular') { 
                        $psuModularColumnIndex = $index;
                        break;
                    }
                }
        
                if ($psuModularColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$psuModularColumnIndex])) {
                            $psuModularValue = $data[$psuModularColumnIndex];
                            $psuModular[] = $psuModularValue;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $psuModular;
        }
        
        function seedPSUModularTableFromCSV($filePath) {
            $psuModularValues = extractPSUModularFromCSV($filePath);
        
            if ($psuModularValues) {
                foreach ($psuModularValues as $psuModularValue) {
                    insertPSUModularIntoTable($psuModularValue);
                }
            }
        }
        
        function insertPSUModularIntoTable($psuModularValue) {
            try {
                // Check if the PSU modular value already exists in the table
                $existingModular = DB::table('psu_modular')
                    ->where('PSU_Modular', $psuModularValue)
                    ->first();
        
                // If the modular value does not exist, insert it into the table
                if (!$existingModular) {
                    DB::table('psu_modular')->insert([
                        'PSU_Modular' => $psuModularValue,
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
        seedPSUModularTableFromCSV($csvFilePath);
    }
}
