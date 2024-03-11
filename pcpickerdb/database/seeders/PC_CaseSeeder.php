<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PC_CaseSeeder extends Seeder
{
    public function run(): void
    {
        function extractPcCasesFromCSV($filePath) {
            $pcCases = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $nameIndex = array_search('name', $headers);
                $priceIndex = array_search('price', $headers);
                $typeIndex = array_search('type', $headers);
                $colorIndex = array_search('color', $headers);
                $psuIndex = array_search('psu', $headers);
                $sidePanelIndex = array_search('side_panel', $headers);
                $internal35BaysIndex = array_search('internal_35_bays', $headers);
        
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $pcCases[] = [
                        'name' => $data[$nameIndex],
                        'price' => $data[$priceIndex],
                        'type' => $data[$typeIndex],
                        'color' => $data[$colorIndex],
                        'psu' => $data[$psuIndex],
                        'side_panel' => $data[$sidePanelIndex],
                        'internal_35_bays' => $data[$internal35BaysIndex]
                    ];
                }
        
                fclose($handle);
            }
        
            return $pcCases;
        }
        
        function mapPcCaseDataToForeignKeys($pcCases) {
            $mappedPcCases = array();
            foreach ($pcCases as $pcCase) {
                $caseTypeID = getCaseTypeIDFromTable($pcCase['type']);
                $caseColorID = getCaseColorIDFromTable($pcCase['color']);
                $sidePanelID = getSidePanelIDFromTable($pcCase['side_panel']);
                
                // Handle missing PSU_Watts value
                $psuWatts = $pcCase['psu'] !== '' ? $pcCase['psu'] : null;
                
                // Handle missing Case_price value
                $casePrice = $pcCase['price'] !== '' ? $pcCase['price'] : null;
                
                $mappedPcCases[] = [
                    'Case_name' => $pcCase['name'],
                    'Case_price' => $casePrice,
                    'Case_type_ID' => $caseTypeID,
                    'Case_color_ID' => $caseColorID,
                    'PSU_Watts' => $psuWatts,
                    'Side_panel_ID' => $sidePanelID,
                    'Bay_count' => $pcCase['internal_35_bays']
                ];
            }
            return $mappedPcCases;
        }
        
        function seedPcCasesTableFromCSV($filePath) {
            $pcCases = extractPcCasesFromCSV($filePath);
            $mappedPcCases = mapPcCaseDataToForeignKeys($pcCases);
            
            foreach ($mappedPcCases as $pcCase) {
                DB::table('pc_case')->insert($pcCase);
            }
        }
        
        function getCaseTypeIDFromTable($caseType) {
            $caseTypeRow = DB::table('case_type')->where('Case_type', $caseType)->first();
            return $caseTypeRow ? $caseTypeRow->id : null;
        }
        
        function getCaseColorIDFromTable($caseColor) {
            $caseColorRow = DB::table('colors')->where('Color', $caseColor)->first();
            return $caseColorRow ? $caseColorRow->id : null;
        }
        
        function getSidePanelIDFromTable($sidePanelType) {
            $sidePanelRow = DB::table('side_panel_types')->where('Side_Panel', $sidePanelType)->first();
            return $sidePanelRow ? $sidePanelRow->id : null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/case.csv';
        seedPcCasesTableFromCSV($csvFilePath);
    }
}
