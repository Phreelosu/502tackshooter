<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigModel;

class ConfigController extends Controller
{
    public function newConfig(Request $request)
    {
        $request->validate([
            'case_id' => 'required|exists:pc_case,id',
            'cpu_id' => 'required|exists:cpu,id',
            'cpu_cooler_id' => 'required|exists:cpu_cooler,id',
            'gpu_id' => 'required|exists:gpu,id',
            'ihd_id' => 'required|exists:internal_hard_drive,id',
            'memory_id' => 'required|exists:memory,id',
            'motherboard_id' => 'required|exists:motherboard,id',
            'psu_id' => 'required|exists:psu,id',
        ]);

        $config = new ConfigModel();
        $config->case_id = $request->case_id;
        $config->cpu_id = $request->cpu_id;
        $config->cpu_cooler_id = $request->cpu_cooler_id;
        $config->gpu_id = $request->gpu_id;
        $config->ihd_id = $request->ihd_id;
        $config->memory_id = $request->memory_id;
        $config->motherboard_id = $request->motherboard_id;
        $config->psu_id = $request->psu_id;
        $config->user_id = auth()->id();
        $config->save();

        return response()->json(['message' => 'Config created successfully'], 201);
    }

    public function modifyConfig(Request $request)
{
    $request->validate([
        'config_id' => 'required|exists:pc,id',
        'case_id' => 'sometimes|required|exists:pc_case,id',
        'cpu_id' => 'sometimes|required|exists:cpu,id',
        'cpu_cooler_id' => 'sometimes|required|exists:cpu_cooler,id',
        'gpu_id' => 'sometimes|required|exists:gpu,id',
        'ihd_id' => 'sometimes|required|exists:internal_hard_drive,id',
        'memory_id' => 'sometimes|required|exists:memory,id',
        'motherboard_id' => 'sometimes|required|exists:motherboard,id',
        'psu_id' => 'sometimes|required|exists:psu,id',
    ]);

    $config = ConfigModel::findOrFail($request->config_id);

    if ($request->has('case_id')) {
        $config->case_id = $request->case_id;
    }
    if ($request->has('cpu_id')) {
        $config->cpu_id = $request->cpu_id;
    }
    if ($request->has('cpu_cooler_id')) {
        $config->cpu_cooler_id = $request->cpu_cooler_id;
    }
    if ($request->has('gpu_id')) {
        $config->gpu_id = $request->gpu_id;
    }
    if ($request->has('ihd_id')) {
        $config->ihd_id = $request->ihd_id;
    }
    if ($request->has('memory_id')) {
        $config->memory_id = $request->memory_id;
    }
    if ($request->has('motherboard_id')) {
        $config->motherboard_id = $request->motherboard_id;
    }
    if ($request->has('psu_id')) {
        $config->psu_id = $request->psu_id;
    }

    $config->save();

    return response()->json(['message' => 'Config updated successfully']);
}

public function deleteConfig(Request $request)
{
    $request->validate([
        'config_id' => 'required|exists:pc,id',
    ]);

    $config = ConfigModel::findOrFail($request->config_id);
    $config->delete();

    return response()->json(['message' => 'Config deleted successfully']);
}

public function getConfig($id)
{
    $config = ConfigModel::with(['cpu', 'gpu', 'psu', 'internal_hard_drive', 'memory', 'motherboard', 'pc_case', 'cpu_cooler'])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    // Format the response data as needed
    $formattedConfig = [
        'id' => $config->id,
        'cpu' => $config->cpu->CPU_name,
        'cpu_cooler' => $config->cpu_cooler->Cooler_name,
        'internal_hard_drive' => $config->internal_hard_drive->Hard_drive_name,
        'memory' => $config->memory->Memory_name,
        'motherboard' => $config->motherboard->Motherboard_name,
        'case' => $config->pc_case->Case_name,
        'gpu' => $config->gpu->GPU_name,
        'psu' => $config->psu->PSU_name,
    ];

    return response()->json($formattedConfig);
}


public function getConfigs()
{
    $configs = ConfigModel::with(['cpu', 'gpu', 'psu', 'internal_hard_drive', 'memory', 'motherboard', 'pc_case', 'cpu_cooler'])
        ->where('user_id', auth()->id())
        ->get();

    $formattedConfigs = $configs->map(function ($config) {
        return [
            'id' => $config->id,
            'cpu' => $config->cpu->CPU_name,
            'cpu_cooler' => $config->cpu_cooler->Cooler_name,
            'internal_hard_drive' => $config->internal_hard_drive->Hard_drive_name,
            'memory' => $config->memory->Memory_name,
            'motherboard' => $config->motherboard->Motherboard_name,
            'case' => $config->pc_case->Case_name,
            'gpu' => $config->gpu->GPU_name,
            'psu' => $config->psu->PSU_name,
        ];
    });

    return response()->json($formattedConfigs);
}
}
