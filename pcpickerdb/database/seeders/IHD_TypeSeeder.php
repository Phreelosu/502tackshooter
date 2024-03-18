<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IHD_TypeSeeder extends Seeder
{
    public function run(): void
    {
        function extractIHDTypesFromCSV($filePath) {
            $ihdTypes = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $ihdTypeColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'type') { 
                        $ihdTypeColumnIndex = $index;
                        break;
                    }
                }
        
                if ($ihdTypeColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$ihdTypeColumnIndex])) {
                            $ihdType = $data[$ihdTypeColumnIndex];
                            $ihdTypes[] = $ihdType;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $ihdTypes;
        }
        
        function mapIHDTypesToIDs($ihdTypes) {
            $ihdTypeIDs = array();
            foreach ($ihdTypes as $ihdType) {
                $ihdTypeID = getIHDTypeIDFromTable($ihdType); // Retrieve the ID for the current IHD type
                $ihdTypeIDs[$ihdType] = $ihdTypeID; // Assign the retrieved ID to the current IHD type
            }
            return $ihdTypeIDs;
        }        
        
        function seedIHDTypesTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $ihdTypes = extractIHDTypesFromCSV($filePath);
                $ihdTypeIDs = mapIHDTypesToIDs($ihdTypes);
                
                // seeding process
                foreach ($ihdTypeIDs as $ihdType => $ihdTypeIDs) {
                    insertIHDTypeIntoTable($ihdType, $ihdTypeIDs);
                }
            }
        }
        
        function insertIHDTypeIntoTable($ihdType, $ihdTypeIDs) {
            try {
                DB::table('ihd_type')->insert([
                    'IHD_Type' => $ihdType,
                    'id' => $ihdTypeIDs
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
        
        function getIHDTypeIDFromTable($ihdType) {
            $ihdTypeRow = DB::table('ihd_type')->where('IHD_Type', $ihdType)->first();
            if ($ihdTypeRow) {
                return $ihdTypeRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '\assets\unprocessedpaths\internal-hard-drive.csv',
        );
        seedIHDTypesTableFromCSVs($csvFilePaths);
    }
}
