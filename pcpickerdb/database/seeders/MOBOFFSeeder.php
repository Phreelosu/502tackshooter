<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MOBOFFSeeder extends Seeder
{
    public function run(): void
    {
        function extractMOBOFormFactorsFromCSV($filePath) {
            $moboFormFactors = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $moboFormFactorColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'form_factor') { 
                        $moboFormFactorColumnIndex = $index;
                        break;
                    }
                }
        
                if ($moboFormFactorColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$moboFormFactorColumnIndex])) {
                            $moboFormFactor = $data[$moboFormFactorColumnIndex];
                            $moboFormFactors[] = $moboFormFactor;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $moboFormFactors;
        }
        
        function mapMOBOFormFactorsToIDs($moboFormFactors) {
            $moboFormFactorIDs = array();
            foreach ($moboFormFactors as $moboFormFactor) {
                $moboFormFactorID = getMOBOFormFactorIDFromTable($moboFormFactor); // Retrieve the ID for the current MOBO form factor
                $moboFormFactorIDs[$moboFormFactor] = $moboFormFactorID; // Assign the retrieved ID to the current MOBO form factor
            }
            return $moboFormFactorIDs;
        }        
        
        function seedMOBOFormFactorsTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $moboFormFactors = extractMOBOFormFactorsFromCSV($filePath);
                $moboFormFactorIDs = mapMOBOFormFactorsToIDs($moboFormFactors);
                
                // seeding process
                foreach ($moboFormFactorIDs as $moboFormFactor => $moboFormFactorIDs) {
                    insertMOBOFormFactorIntoTable($moboFormFactor, $moboFormFactorIDs);
                }
            }
        }
        
        function insertMOBOFormFactorIntoTable($moboFormFactor, $moboFormFactorIDs) {
            try {
                DB::table('mobo_form_factor')->insert([
                    'MOBO_Form_Factor' => $moboFormFactor,
                    'id' => $moboFormFactorIDs
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
        
        function getMOBOFormFactorIDFromTable($moboFormFactor) {
            $moboFormFactorRow = DB::table('mobo_form_factor')->where('MOBO_Form_Factor', $moboFormFactor)->first();
            if ($moboFormFactorRow) {
                return $moboFormFactorRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '/assets/unprocessedpaths/motherboard.csv',
        );
        seedMOBOFormFactorsTableFromCSVs($csvFilePaths);
    }
}
