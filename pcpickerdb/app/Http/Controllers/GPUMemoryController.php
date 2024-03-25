<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GPUMemoryController extends Controller
{
    public function index()
    {
        $gpu_memory = GPUMemoryModel::all();
        return response()->json($gpu_memory);
    }
}
