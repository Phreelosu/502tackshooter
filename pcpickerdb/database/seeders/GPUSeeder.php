<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GPUSeeder extends Seeder
{
    public function run(): void
    {
        function extractGPUsFromCSV($filePath, $limit = 50) {
            $GPUs = array();
        
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $nameIndex = array_search('name', $headers);
                $priceIndex = array_search('price', $headers);
                $chipsetIndex = array_search('chipset', $headers);
                $memoryIndex = array_search('memory', $headers); // Assuming this column contains GPU memory in the format you need
                $coreClockIndex = array_search('core_clock', $headers);
                $boostClockIndex = array_search('boost_clock', $headers);
                $colorIndex = array_search('color', $headers);
                $lengthIndex = array_search('length', $headers);
                $count = 0;
        
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $count < $limit) {
                    $count++;
                    $GPUs[] = [
                        'GPU_name' => $data[$nameIndex],
                        'GPU_price' => $data[$priceIndex],
                        'GPU_chipset' => $data[$chipsetIndex],
                        'GPU_memory_ID' => $data[$memoryIndex], // Assuming this contains GPU memory ID from the gpu_memory table
                        'GPU_core_clock' => $data[$coreClockIndex],
                        'GPU_boost_clock' => $data[$boostClockIndex],
                        'GPU_color_ID' => $data[$colorIndex], // Assuming this contains GPU color ID from the colors table
                        'GPU_length' => $data[$lengthIndex]
                    ];
                }
        
                fclose($handle);
            }
        
            return $GPUs;
        }
        
        
        function mapGPUDataToForeignKeys($GPUs) {
            $mappedGPUs = array();
            foreach ($GPUs as $GPU) {
                $gpuMemoryID = getGPUMemoryIDFromTable($GPU['GPU_memory_ID']);
                $gpuColorID = getGPUColorIDFromTable($GPU['GPU_color_ID']);
                
                // Handle missing or empty values
                $gpuPrice = !empty($GPU['GPU_price']) ? $GPU['GPU_price'] : null;
                $gpuChipset = !empty($GPU['GPU_chipset']) ? $GPU['GPU_chipset'] : null;
                $gpuCoreClock = !empty($GPU['GPU_core_clock']) ? $GPU['GPU_core_clock'] : null;
                $gpuBoostClock = !empty($GPU['GPU_boost_clock']) ? $GPU['GPU_boost_clock'] : null;
                $gpuLength = !empty($GPU['GPU_length']) ? $GPU['GPU_length'] : null;
                
                $mappedGPUs[] = [
                    'GPU_name' => $GPU['GPU_name'],
                    'GPU_price' => $gpuPrice,
                    'GPU_chipset' => $gpuChipset,
                    'GPU_memory_ID' => $gpuMemoryID,
                    'GPU_core_clock' => $gpuCoreClock,
                    'GPU_boost_clock' => $gpuBoostClock,
                    'GPU_color_ID' => $gpuColorID,
                    'GPU_length' => $gpuLength
                ];
            }
            return $mappedGPUs;
        }        
        
        function seedGPUTableFromCSV($filePath) {
            $GPUs = extractGPUsFromCSV($filePath);
            $mappedGPUs = mapGPUDataToForeignKeys($GPUs);
            
            foreach ($mappedGPUs as $GPU) {
                DB::table('gpu')->insert($GPU);
            }
        }
        
        function getGPUMemoryIDFromTable($gpuMemory) {
            $gpuMemoryRow = DB::table('gpu_memory')->where('GPU_Memory', $gpuMemory)->first();
            return $gpuMemoryRow ? $gpuMemoryRow->id : null;
        }
        
        function getGPUColorIDFromTable($gpuColor) {
            $gpuColorRow = DB::table('colors')->where('Color', $gpuColor)->first();
            return $gpuColorRow ? $gpuColorRow->id : null;
        }
        
        $csvFilePath = __DIR__ . '/assets/unprocessedpaths/video-card.csv';
        seedGPUTableFromCSV($csvFilePath);
    }
}
