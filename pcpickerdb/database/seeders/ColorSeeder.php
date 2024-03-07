<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        function extractColorsFromCSV($filePath) {
            $colors = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                // Read the header row to determine the index of the color column
                $headers = fgetcsv($handle, 1000, ",");
                $colorColumnIndex = null;
        
                // Find the index of the column containing the color data
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'color') { // Adjust based on your actual column name
                        $colorColumnIndex = $index;
                        break;
                    }
                }
        
                if ($colorColumnIndex !== null) {
                    // Iterate through each row and extract the color from the identified column
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
        
        // Function to map colors to their unique IDs
        function mapColorsToIDs($colors) {
            $colorIDs = array();
            // Assuming you have a function to query the colors table and get their IDs
            foreach ($colors as $color) {
                $colorID = getColorIDFromTable($color); // Implement this function
                $colorIDs[$color] = $colorID;
            }
            return $colorIDs;
        }
        
        // Function to seed colors table from CSVs
        function seedColorsTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $colors = extractColorsFromCSV($filePath);
                $colorIDs = mapColorsToIDs($colors);
                
                // Seed colors table
                foreach ($colorIDs as $color => $colorID) {
                    insertColorIntoTable($color, $colorID); // Implement this function to insert into your colors table
                }
            }
        }
        
        // Function to insert color data into the colors table
        function insertColorIntoTable($color, $colorID) {
            // Establish a database connection (assuming you're using Laravel's DB facade)
            // You may need to adjust this depending on your database configuration
            try {
                DB::table('colors')->insert([
                    'Color' => $color,
                    'ID' => $colorID
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                // Check if the exception is a duplicate key violation
                if ($e->errorInfo[1] == 1062) { // MySQL error code for duplicate entry
                    // Ignore the error and continue
                    return;
                } else {
                    // Re-throw the exception if it's not a duplicate key violation
                    throw $e;
                }
            }
        }
        
        
        // Function to retrieve color ID from the database based on color name
        function getColorIDFromTable($color) {
            // Implement your logic to query the colors table and retrieve the ID for the given color
            // Example:
            $colorRow = DB::table('colors')->where('Color', $color)->first();
            if ($colorRow) {
                return $colorRow->id;
            }
            return null; // Return null if color not found
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
