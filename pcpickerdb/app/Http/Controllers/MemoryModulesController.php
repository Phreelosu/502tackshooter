<?php

namespace App\Http\Controllers;

use App\Models\MemoryModulesModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemoryModulesController extends Controller
{
    public function index()
    {
        $memory_modules = MemoryModulesModel::all();
        return response()->json($memory_modules);
    }
}
