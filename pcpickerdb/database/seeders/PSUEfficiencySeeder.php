<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PSUEfficiencySeeder extends Seeder
{
    public function run(): void
    {
        function extractPSUEfficiencyFromCSV($filePath) {
            $psuEfficiency = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $psuEfficiencyColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'efficiency') { 
                        $psuEfficiencyColumnIndex = $index;
                        break;
                    }
                }
        
                if ($psuEfficiencyColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$psuEfficiencyColumnIndex])) {
                            $psuEfficiencyValue = $data[$psuEfficiencyColumnIndex];
                            $psuEfficiency[] = $psuEfficiencyValue;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $psuEfficiency;
        }
        
        function seedPSUEfficiencyTableFromCSV($filePath) {
            $psuEfficiencyValues = extractPSUEfficiencyFromCSV($filePath);
        
            if ($psuEfficiencyValues) {
                foreach ($psuEfficiencyValues as $psuEfficiencyValue) {
                    insertPSUEfficiencyIntoTable($psuEfficiencyValue);
                }
            }
        }
        
        function insertPSUEfficiencyIntoTable($psuEfficiencyValue) {
            try {
                // Check if the PSU efficiency value already exists in the table
                $existingEfficiency = DB::table('psu_efficiency')
                    ->where('PSU_Efficiency', $psuEfficiencyValue)
                    ->first();
        
                // If the efficiency value does not exist, insert it into the table
                if (!$existingEfficiency) {
                    DB::table('psu_efficiency')->insert([
                        'PSU_Efficiency' => $psuEfficiencyValue,
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
        seedPSUEfficiencyTableFromCSV($csvFilePath);
    }
}
