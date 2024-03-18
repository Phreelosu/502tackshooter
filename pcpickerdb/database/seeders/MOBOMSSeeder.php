<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MOBOMSSeeder extends Seeder
{
    public function run(): void
    {
        function extractMOBOMemorySlotsFromCSV($filePath) {
            $moboMemorySlots = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $moboMemorySlotsColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'memory_slots') { 
                        $moboMemorySlotsColumnIndex = $index;
                        break;
                    }
                }
        
                if ($moboMemorySlotsColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$moboMemorySlotsColumnIndex])) {
                            $moboMemorySlotsValue = $data[$moboMemorySlotsColumnIndex];
                            $moboMemorySlots[] = $moboMemorySlotsValue;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $moboMemorySlots;
        }
        
        function mapMOBOMemorySlotsToIDs($moboMemorySlots) {
            $moboMemorySlotsIDs = array();
            foreach ($moboMemorySlots as $moboMemorySlotsValue) {
                $moboMemorySlotsID = getMOBOMemorySlotsIDFromTable($moboMemorySlotsValue); // Retrieve the ID for the current MOBO memory slots
                $moboMemorySlotsIDs[$moboMemorySlotsValue] = $moboMemorySlotsID; // Assign the retrieved ID to the current MOBO memory slots
            }
            return $moboMemorySlotsIDs;
        }        
        
        function seedMOBOMemorySlotsTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $moboMemorySlotsValues = extractMOBOMemorySlotsFromCSV($filePath);
                $moboMemorySlotsIDs = mapMOBOMemorySlotsToIDs($moboMemorySlotsValues);
                
                // seeding process
                foreach ($moboMemorySlotsIDs as $moboMemorySlotsValue => $moboMemorySlotsIDs) {
                    insertMOBOMemorySlotsIntoTable($moboMemorySlotsValue, $moboMemorySlotsIDs);
                }
            }
        }
        
        function insertMOBOMemorySlotsIntoTable($moboMemorySlotsValue, $moboMemorySlotsIDs) {
            try {
                DB::table('mobo_memory_slots')->insert([
                    'MOBO_Memory_Slots' => $moboMemorySlotsValue,
                    'id' => $moboMemorySlotsIDs
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
        
        function getMOBOMemorySlotsIDFromTable($moboMemorySlotsValue) {
            $moboMemorySlotsRow = DB::table('mobo_memory_slots')->where('MOBO_Memory_Slots', $moboMemorySlotsValue)->first();
            if ($moboMemorySlotsRow) {
                return $moboMemorySlotsRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '/assets/unprocessedpaths/motherboard.csv',
        );
        seedMOBOMemorySlotsTableFromCSVs($csvFilePaths);
    }
}
