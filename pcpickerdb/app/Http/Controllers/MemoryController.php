<?php

namespace App\Http\Controllers;

use App\Models\MemoryModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemoryController extends Controller
{
    public function index()
    {
        $memory = MemoryModel::all();
        return response()->json($memory);
    }
    public function show($id)
    {
        $memory = MemoryModel::findOrFail($id);
        return response()->json($memory);
    }
}
