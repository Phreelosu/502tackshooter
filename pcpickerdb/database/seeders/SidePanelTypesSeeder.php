<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SidePanelTypesSeeder extends Seeder
{
    public function run(): void
    {
        function extractSidePanelTypesFromCSV($filePath) {
            $sidePanelTypes = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $sidePanelTypeColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'side_panel') { 
                        $sidePanelTypeColumnIndex = $index;
                        break;
                    }
                }
        
                if ($sidePanelTypeColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$sidePanelTypeColumnIndex])) {
                            $sidePanelType = $data[$sidePanelTypeColumnIndex];
                            $sidePanelTypes[] = $sidePanelType;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $sidePanelTypes;
        }
        
        function mapSidePanelTypesToIDs($sidePanelTypes) {
            $sidePanelTypeIDs = array();
            foreach ($sidePanelTypes as $sidePanelType) {
                $sidePanelTypeID = getSidePanelTypeIDFromTable($sidePanelType);
                $sidePanelTypeIDs[$sidePanelType] = $sidePanelTypeID;
            }
            return $sidePanelTypeIDs;
        }
        
        function seedSidePanelTypesTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $sidePanelTypes = extractSidePanelTypesFromCSV($filePath);
                $sidePanelTypeIDs = mapSidePanelTypesToIDs($sidePanelTypes);
                
                foreach ($sidePanelTypeIDs as $sidePanelType => $sidePanelTypeID) {
                    insertSidePanelTypeIntoTable($sidePanelType, $sidePanelTypeID);
                }
            }
        }
        
        function insertSidePanelTypeIntoTable($sidePanelType, $sidePanelTypeID) {
            try {
                DB::table('side_panel_types')->insert([
                    'Side_Panel' => $sidePanelType,
                    'id' => $sidePanelTypeID
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    return;
                } else {
                    throw $e;
                }
            }
        }        
        
        function getSidePanelTypeIDFromTable($sidePanelType) {
            $sidePanelTypeRow = DB::table('side_panel_types')->where('side_panel', $sidePanelType)->first();
            if ($sidePanelTypeRow) {
                return $sidePanelTypeRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '\assets\unprocessedpaths\case.csv',
        );
        seedSidePanelTypesTableFromCSVs($csvFilePaths);
    }
}
