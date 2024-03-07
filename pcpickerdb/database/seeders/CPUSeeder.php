<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CPUSeeder extends Seeder
{
    public function run()
    {
        // Adjust the path to your CSV file
        $csvFile = database_path('seeders\assets\csvpaths\cpu.csv');

        // Read the CSV file
        $csv = array_map('str_getcsv', file($csvFile));

        // Get the headers (first row) and remove it from the data
        $headers = array_shift($csv);

        // Insert data into the database
        foreach ($csv as $row) {
            $data = array_combine($headers, $row);

            // Handle null values for float columns
            foreach ($data as $key => $value) {
                if (is_numeric($value) && $value === '') {
                    $data[$key] = null;
                }
            }

            // Handle null values for string columns
            foreach ($data as $key => $value) {
                if ($value === '') {
                    $data[$key] = null;
                }
            }

            DB::table('cpu')->insert($data);
        }
    }
}
