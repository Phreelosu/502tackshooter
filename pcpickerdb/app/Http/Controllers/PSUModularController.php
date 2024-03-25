<?php

namespace App\Http\Controllers;

use App\Models\PSUModularModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PSUModularController extends Controller
{
    public function index()
    {
        $psu_modular = PSUModularModel::all();
        return response()->json($psu_modular);
    }
    public function show($id)
    {
        $psu_modular = PSUModularModel::findOrFail($id);
        return response()->json($psu_modular);
    }
}
