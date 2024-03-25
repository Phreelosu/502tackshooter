<?php

namespace App\Http\Controllers;

use App\Models\IHDTypeModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IHDTypeController extends Controller
{
    public function index()
    {
        $ihd_type = IHDTypeModel::all();
        return response()->json($ihd_type);
    }
}
