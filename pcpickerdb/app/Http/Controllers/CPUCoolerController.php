<?php

namespace App\Http\Controllers;

use App\Models\CPUCoolerModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CPUCoolerController extends Controller
{
    public function index()
    {
        $cpu_cooler = CPUCoolerModel::all();
        return response()->json($cpu_cooler);
    }
    public function show($id)
    {
        $cpu_cooler = CPUCoolerModel::findOrFail($id);
        return response()->json($cpu_cooler);
    }
}
