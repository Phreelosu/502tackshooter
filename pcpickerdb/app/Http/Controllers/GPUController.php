<?php

namespace App\Http\Controllers;

use App\Models\GPUModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GPUController extends Controller
{
    public function index()
    {
        $gpu = GPUModel::all();
        return response()->json($gpu);
    }
    public function show($id)
    {
        $gpu = GPUModel::findOrFail($id);
        return response()->json($gpu);
    }
}
