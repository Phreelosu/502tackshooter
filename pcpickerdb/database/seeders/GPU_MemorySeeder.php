<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GPU_MemorySeeder extends Seeder
{
    public function run(): void
    {
        function extractGPUMemoriesFromCSV($filePath) {
            $gpuMemories = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                // ez moduláris végülis de hát az egész katasztrófa ahogy működik, de legalább a mienk
                $headers = fgetcsv($handle, 1000, ",");
                $gpuMemoriesColumnIndex = null;
        
                foreach ($headers as $index => $header) {
                    if (strtolower($header) === 'memory') { 
                        $gpuMemoriesColumnIndex = $index;
                        break;
                    }
                }
        
                if ($gpuMemoriesColumnIndex !== null) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (isset($data[$gpuMemoriesColumnIndex])) {
                            $gpuMemory = $data[$gpuMemoriesColumnIndex];
                            $gpuMemories[] = $gpuMemory;
                        }
                    }
                }
        
                fclose($handle);
            }
        
            return $gpuMemories;
        }
        
        function mapGPUMemoriesToIDs($gpuMemories) {
            $gpuMemoryIDs = array();
            foreach ($gpuMemories as $gpuMemory) {
                $gpuMemoryID = getGPUMemoryIDFromTable($gpuMemory); // Retrieve the ID for the current GPU memory
                $gpuMemoryIDs[$gpuMemory] = $gpuMemoryID; // Assign the retrieved ID to the current GPU memory
            }
            return $gpuMemoryIDs;
        }        
        
        function seedGPUMemoriesTableFromCSVs($filePaths) {
            foreach ($filePaths as $filePath) {
                $gpuMemories = extractGPUMemoriesFromCSV($filePath);
                $gpuMemoryIDs = mapGPUMemoriesToIDs($gpuMemories);
                
                // seeding process
                foreach ($gpuMemoryIDs as $gpuMemory => $gpuMemoryIDs) {
                    insertGPUMemoryIntoTable($gpuMemory, $gpuMemoryIDs);
                }
            }
        }
        
        function insertGPUMemoryIntoTable($gpuMemory, $gpuMemoryIDs) {
            try {
                DB::table('gpu_memory')->insert([
                    'GPU_Memory' => $gpuMemory,
                    'id' => $gpuMemoryIDs
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
        
        function getGPUMemoryIDFromTable($gpuMemory) {
            $gpuMemoryRow = DB::table('gpu_memory')->where('GPU_Memory', $gpuMemory)->first();
            if ($gpuMemoryRow) {
                return $gpuMemoryRow->id;
            }
            return null;
        }
        
        $csvFilePaths = array(
            __DIR__ . '\assets\unprocessedpaths\video-card.csv',
        );
        seedGPUMemoriesTableFromCSVs($csvFilePaths);
    }
}
