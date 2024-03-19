<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//include 'utilities.php';

class CaseTypeSeeder extends Seeder
{
    public function run(): void
    {
        function extractCaseTypesFromCSV($filePath) {
            $caseTypes = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                // ez moduláris végülis de hát az egész katasztrófa ahogy működik, de legalább a mienk
                $headers = fgetcsv($handle, 1000, ",");
                $caseTypeColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'type') { 
                        $caseTypeColumnIndex = $index;
                        break;
                    }
                }
        
                if ($caseTypeColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$caseTypeColumnIndex])) {
                            $caseType = $data[$caseTypeColumnIndex];
                            $caseTypes[] = $caseType;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $caseTypes;
        }
        
        function mapCaseTypesToIDs($caseTypes) {
            $caseTypeIDs = array();
            foreach ($caseTypes as $caseType) {
                $caseTypeID = getCaseTypeIDFromTable($caseType); // Retrieve the ID for the current case type
                $caseTypeIDs[$caseType] = $caseTypeID; // Assign the retrieved ID to the current case type
            }
            return $caseTypeIDs;
        }
        
        
        function seedCaseTypesTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $caseTypes = extractCaseTypesFromCSV($filePath);
                $caseTypeIDs = mapCaseTypesToIDs($caseTypes);
                
                // itt seedel
                foreach ($caseTypeIDs as $caseType => $caseTypeIDs) {
                    insertCaseTypeIntoTable($caseType, $caseTypeIDs);
                }
            }
        }
        
        function insertCaseTypeIntoTable($caseType, $caseTypeID) {
            try {
                DB::table('case_type')->insert([
                    'Case_type' => $caseType,
                    'id' => $caseTypeID
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
        
        function getCaseTypeIDFromTable($caseType) {
            $caseTypeRow = DB::table('case_type')->where('Case_type', $caseType)->first();
            if ($caseTypeRow) {
                return $caseTypeRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '\assets\unprocessedpaths\case.csv',
        );
        seedCaseTypesTableFromCSVs($csvFilePaths);
    }
}
