<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IHDSeeder extends Seeder
{
    public function run(): void
    {
        function extractInternalHardDrivesFromCSV($filePath, $limit = 50) {
            $internalHardDrives = array();
            $count = 0;
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $nameIndex = array_search('name', $headers);
                $priceIndex = array_search('price', $headers);
                $capacityIndex = array_search('capacity', $headers);
                $typeIndex = array_search('type', $headers);
                $cacheIndex = array_search('cache', $headers);
                $formFactorIndex = array_search('form_factor', $headers);
                $interfaceIndex = array_search('interface', $headers);
        
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $count < $limit) {
                    $count++;
                    $price = !empty($data[$priceIndex]) ? $data[$priceIndex] : null; // Handle empty price value
                    $cache = !empty($data[$cacheIndex]) ? $data[$cacheIndex] : null; // Handle empty cache value
                    $internalHardDrives[] = [
                        'Hard_drive_name' => $data[$nameIndex],
                        'Hard_drive_price' => $price,
                        'Hard_drive_capacity_ID' => getHardDriveCapacityIDs($data[$capacityIndex]),
                        'Hard_drive_type_ID' => getHardDriveTypeIDs($data[$typeIndex]),
                        'Hard_drive_cache' => $cache,
                        'Hard_drive_form_factor_ID' => getHardDriveFormFactorIDs($data[$formFactorIndex]),
                        'Hard_drive_interface_ID' => getHardDriveInterfaceIDs($data[$interfaceIndex])
                    ];
                }
        
                fclose($handle);
            }
        
            return $internalHardDrives;
        }        
        
        function getHardDriveCapacityIDs($capacity) {
            $capacityRow = DB::table('ihd_capacity')->where('IHD_Capacity', $capacity)->first();
            return $capacityRow ? $capacityRow->id : null;
        }
        
        function getHardDriveTypeIDs($type) {
            $typeRow = DB::table('ihd_type')->where('IHD_Type', $type)->first();
            return $typeRow ? $typeRow->id : null;
        }
        
        function getHardDriveFormFactorIDs($formFactor) {
            $formFactorRow = DB::table('ihd_form_factor')->where('ihd_form_factor', $formFactor)->first();
            return $formFactorRow ? $formFactorRow->id : null;
        }
        
        function getHardDriveInterfaceIDs($interface) {
            $interfaceRow = DB::table('ihd_interface')->where('ihd_interface', $interface)->first();
            return $interfaceRow ? $interfaceRow->id : null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/internal-hard-drive.csv';
        $internalHardDrives = extractInternalHardDrivesFromCSV($csvFilePath);
        
        foreach ($internalHardDrives as $hardDrive) {
            DB::table('internal_hard_drive')->insert($hardDrive);
        }
    }
}
