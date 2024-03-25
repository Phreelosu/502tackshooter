<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GPUController extends Controller
{
    public function index()
    {
        $gpu = GPUModel::all();
        return response()->json($gpu);
    }
}
