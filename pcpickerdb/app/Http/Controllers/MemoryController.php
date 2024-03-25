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
}
