<?php

namespace App\Http\Controllers;

use App\Models\MOBOMMModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MOBOMMController extends Controller
{
    public function index()
    {
        $mobo_max_memory = MOBOMMModel::all();
        return response()->json($mobo_max_memory);
    }
    public function show($id)
    {
        $mobo_max_memory = MOBOMMModel::findOrFail($id);
        return response()->json($mobo_max_memory);
    }
}
