<?php

namespace App\Http\Controllers;

use App\Models\CPUModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CPUController extends Controller
{
    public function index()
    {
        $cpu = CPUModel::all();
        return response()->json($cpu);
    }
    public function show($id)
    {
        $cpu = CPUModel::findOrFail($id);
        return response()->json($cpu);
    }
}
