<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IHD_CapacitySeeder extends Seeder
{
    public function run(): void
    {
        function extractIHD_CapacitiesFromCSV($filePath) {
            $ihdCapacities = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $capacityIndex = array_search('capacity', $headers); // Assuming 'capacity' is the header for the capacity column
        
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $ihdCapacities[] = $data[$capacityIndex];
                }
        
                fclose($handle);
            }
        
            return $ihdCapacities;
        }
        
        function mapIHD_CapacitiesToIDs($ihdCapacities) {
            $ihdCapacityIDs = array();
            foreach ($ihdCapacities as $ihdCapacity) {
                $ihdCapacityID = getIHD_CapacityIDFromTable($ihdCapacity); // Retrieve the ID for the current IHD capacity
                $ihdCapacityIDs[$ihdCapacity] = $ihdCapacityID; // Assign the retrieved ID to the current IHD capacity
            }
            return $ihdCapacityIDs;
        }        
        
        function seedIHD_CapacitiesTableFromCSV($filePath) {
            $ihdCapacities = extractIHD_CapacitiesFromCSV($filePath);
            $ihdCapacityIDs = mapIHD_CapacitiesToIDs($ihdCapacities);
            
            // Seeding process
            foreach ($ihdCapacityIDs as $ihdCapacity => $ihdCapacityID) {
                insertIHDCapacityIntoTable($ihdCapacity, $ihdCapacityID);
            }
        }
        
        function insertIHDCapacityIntoTable($ihdCapacity, $ihdCapacityID) {
            try {
                DB::table('ihd_capacity')->insert([
                    'IHD_Capacity' => $ihdCapacity,
                    'id' => $ihdCapacityID
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
        
        function getIHD_CapacityIDFromTable($ihdCapacity) {
            $ihdCapacityRow = DB::table('ihd_capacity')->where('IHD_Capacity', $ihdCapacity)->first();
            if ($ihdCapacityRow) {
                return $ihdCapacityRow->id;
            }
            return null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/internal-hard-drive.csv';
        seedIHD_CapacitiesTableFromCSV($csvFilePath);
    }
}
