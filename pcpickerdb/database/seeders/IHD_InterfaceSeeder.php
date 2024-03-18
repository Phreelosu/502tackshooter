<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IHD_InterfaceSeeder extends Seeder
{
    public function run(): void
    {
        function extractIHDInterfacesFromCSV($filePath) {
            $ihdInterfaces = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $ihdInterfaceColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'interface') { 
                        $ihdInterfaceColumnIndex = $index;
                        break;
                    }
                }
        
                if ($ihdInterfaceColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$ihdInterfaceColumnIndex])) {
                            $ihdInterface = $data[$ihdInterfaceColumnIndex];
                            $ihdInterfaces[] = $ihdInterface;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $ihdInterfaces;
        }
        
        function mapIHDInterfacesToIDs($ihdInterfaces) {
            $ihdInterfaceIDs = array();
            foreach ($ihdInterfaces as $ihdInterface) {
                $ihdInterfaceID = getIHDInterfaceIDFromTable($ihdInterface); // Retrieve the ID for the current IHD interface
                $ihdInterfaceIDs[$ihdInterface] = $ihdInterfaceID; // Assign the retrieved ID to the current IHD interface
            }
            return $ihdInterfaceIDs;
        }        
        
        function seedIHDInterfacesTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $ihdInterfaces = extractIHDInterfacesFromCSV($filePath);
                $ihdInterfaceIDs = mapIHDInterfacesToIDs($ihdInterfaces);
                
                // seeding process
                foreach ($ihdInterfaceIDs as $ihdInterface => $ihdInterfaceIDs) {
                    insertIHDInterfaceIntoTable($ihdInterface, $ihdInterfaceIDs);
                }
            }
        }
        
        function insertIHDInterfaceIntoTable($ihdInterface, $ihdInterfaceIDs) {
            try {
                DB::table('ihd_interface')->insert([
                    'ihd_interface' => $ihdInterface,
                    'id' => $ihdInterfaceIDs
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
        
        function getIHDInterfaceIDFromTable($ihdInterface) {
            $ihdInterfaceRow = DB::table('ihd_interface')->where('ihd_interface', $ihdInterface)->first();
            if ($ihdInterfaceRow) {
                return $ihdInterfaceRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '\assets\unprocessedpaths\internal-hard-drive.csv',
        );
        seedIHDInterfacesTableFromCSVs($csvFilePaths);
    }
}
