<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IHDCapacityController extends Controller
{
    public function index()
    {
        $ihd_capacity = IHDCapacityModel::all();
        return response()->json($ihd_capacity);
    }
}
