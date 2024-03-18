<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MOBOMMSeeder extends Seeder
{
    public function run(): void
    {
        function extractMOBOMaxMemoryFromCSV($filePath) {
            $moboMaxMemory = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $moboMaxMemoryColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'max_memory') { 
                        $moboMaxMemoryColumnIndex = $index;
                        break;
                    }
                }
        
                if ($moboMaxMemoryColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$moboMaxMemoryColumnIndex])) {
                            $moboMaxMemoryValue = $data[$moboMaxMemoryColumnIndex];
                            $moboMaxMemory[] = $moboMaxMemoryValue;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $moboMaxMemory;
        }
        
        function mapMOBOMaxMemoryToIDs($moboMaxMemory) {
            $moboMaxMemoryIDs = array();
            foreach ($moboMaxMemory as $moboMaxMemoryValue) {
                $moboMaxMemoryID = getMOBOMaxMemoryIDFromTable($moboMaxMemoryValue); // Retrieve the ID for the current MOBO max memory
                $moboMaxMemoryIDs[$moboMaxMemoryValue] = $moboMaxMemoryID; // Assign the retrieved ID to the current MOBO max memory
            }
            return $moboMaxMemoryIDs;
        }        
        
        function seedMOBOMaxMemoryTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $moboMaxMemoryValues = extractMOBOMaxMemoryFromCSV($filePath);
                $moboMaxMemoryIDs = mapMOBOMaxMemoryToIDs($moboMaxMemoryValues);
                
                // seeding process
                foreach ($moboMaxMemoryIDs as $moboMaxMemoryValue => $moboMaxMemoryIDs) {
                    insertMOBOMaxMemoryIntoTable($moboMaxMemoryValue, $moboMaxMemoryIDs);
                }
            }
        }
        
        function insertMOBOMaxMemoryIntoTable($moboMaxMemoryValue, $moboMaxMemoryIDs) {
            try {
                DB::table('mobo_max_memory')->insert([
                    'MOBO_Max_Memory' => $moboMaxMemoryValue,
                    'id' => $moboMaxMemoryIDs
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
        
        function getMOBOMaxMemoryIDFromTable($moboMaxMemoryValue) {
            $moboMaxMemoryRow = DB::table('mobo_max_memory')->where('MOBO_Max_Memory', $moboMaxMemoryValue)->first();
            if ($moboMaxMemoryRow) {
                return $moboMaxMemoryRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '/assets/unprocessedpaths/motherboard.csv',
        );
        seedMOBOMaxMemoryTableFromCSVs($csvFilePaths);
    }
}
