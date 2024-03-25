<?php

namespace App\Http\Controllers;

use App\Models\IHDFormFactorModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IHDFormFactorController extends Controller
{
    public function index()
    {
        $ihd_form_factor = IHDFormFactorModel::all();
        return response()->json($ihd_form_factor);
    }
    public function show($id)
    {
        $ihd_form_factor = IHDFormFactorModel::findOrFail($id);
        return response()->json($ihd_form_factor);
    }
}
