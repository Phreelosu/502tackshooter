<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        function extractColorsFromCSV($filePath) {
            $colors = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                // ez moduláris végülis de hát az egész katasztrófa ahogy működik, de legalább a mienk
                $headers = fgetcsv($handle, 1000, ",");
                $colorColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'color') { 
                        $colorColumnIndex = $index;
                        break;
                    }
                }
        
                if ($colorColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$colorColumnIndex])) {
                            $color = $data[$colorColumnIndex];
                            $colors[] = $color;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $colors;
        }
        
        function mapColorsToIDs($colors) {
            $colorIDs = array();
            foreach ($colors as $color) {
                $colorID = getColorIDFromTable($color);
                $colorIDs[$color] = $colorID;
            }
            return $colorIDs;
        }
        
        function seedColorsTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $colors = extractColorsFromCSV($filePath);
                $colorIDs = mapColorsToIDs($colors);
                
                // itt seedel
                foreach ($colorIDs as $color => $colorID) {
                    insertColorIntoTable($color, $colorID);
                }
            }
        }
        
        function insertColorIntoTable($color, $colorID) {
            try {
                DB::table('colors')->insert([
                    'Color' => $color,
                    'ID' => $colorID
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) { // ha már van duplicate entry
                    // nem fogja érdekelni és tovább csinálja, brute force
                    return;
                } else {
                    throw $e;
                }
            }
        }
        
        function getColorIDFromTable($color) {
            $colorRow = DB::table('colors')->where('Color', $color)->first();
            if ($colorRow) {
                return $colorRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '\assets\unprocessedpaths\case.csv',
            __DIR__ . '\assets\unprocessedpaths\cpu-cooler.csv',
            __DIR__ . '\assets\unprocessedpaths\memory.csv',
            __DIR__ . '\assets\unprocessedpaths\motherboard.csv',
            __DIR__ . '\assets\unprocessedpaths\power-supply.csv',
            __DIR__ . '\assets\unprocessedpaths\video-card.csv',
        );
        seedColorsTableFromCSVs($csvFilePaths);
    }
}
