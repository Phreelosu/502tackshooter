<?php

namespace App\Http\Controllers;

use App\Models\PSUEfficiencyModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PSUEfficiencyController extends Controller
{
    public function index()
    {
        $psu_efficiency = PSUEfficiencyModel::all();
        return response()->json($psu_efficiency);
    }
    public function show($id)
    {
        $psu_efficiency = PSUEfficiencyModel::findOrFail($id);
        return response()->json($psu_efficiency);
    }
}
