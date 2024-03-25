<?php

namespace App\Http\Controllers;

use App\Models\MOBOMSModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MOBOMSController extends Controller
{
    public function index()
    {
        $mobo_memory_slots = MOBOMSModel::all();
        return response()->json($mobo_memory_slots);
    }
}
