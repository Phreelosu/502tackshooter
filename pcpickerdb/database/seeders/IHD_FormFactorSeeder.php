<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IHD_FormFactorSeeder extends Seeder
{
    public function run(): void
    {
        function extractIHDFormFactorsFromCSV($filePath) {
            $ihdFormFactors = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $ihdFormFactorColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'form_factor') { 
                        $ihdFormFactorColumnIndex = $index;
                        break;
                    }
                }
        
                if ($ihdFormFactorColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$ihdFormFactorColumnIndex])) {
                            $ihdFormFactor = $data[$ihdFormFactorColumnIndex];
                            $ihdFormFactors[] = $ihdFormFactor;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $ihdFormFactors;
        }
        
        function mapIHDFormFactorsToIDs($ihdFormFactors) {
            $ihdFormFactorIDs = array();
            foreach ($ihdFormFactors as $ihdFormFactor) {
                $ihdFormFactorID = getIHDFormFactorIDFromTable($ihdFormFactor); // Retrieve the ID for the current IHD form factor
                $ihdFormFactorIDs[$ihdFormFactor] = $ihdFormFactorID; // Assign the retrieved ID to the current IHD form factor
            }
            return $ihdFormFactorIDs;
        }        
        
        function seedIHDFormFactorsTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $ihdFormFactors = extractIHDFormFactorsFromCSV($filePath);
                $ihdFormFactorIDs = mapIHDFormFactorsToIDs($ihdFormFactors);
                
                // seeding process
                foreach ($ihdFormFactorIDs as $ihdFormFactor => $ihdFormFactorIDs) {
                    insertIHDFormFactorIntoTable($ihdFormFactor, $ihdFormFactorIDs);
                }
            }
        }
        
        function insertIHDFormFactorIntoTable($ihdFormFactor, $ihdFormFactorIDs) {
            try {
                DB::table('ihd_form_factor')->insert([
                    'ihd_form_factor' => $ihdFormFactor,
                    'id' => $ihdFormFactorIDs
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
        
        function getIHDFormFactorIDFromTable($ihdFormFactor) {
            $ihdFormFactorRow = DB::table('ihd_form_factor')->where('ihd_form_factor', $ihdFormFactor)->first();
            if ($ihdFormFactorRow) {
                return $ihdFormFactorRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '\assets\unprocessedpaths\internal-hard-drive.csv',
        );
        seedIHDFormFactorsTableFromCSVs($csvFilePaths);
    }
}
