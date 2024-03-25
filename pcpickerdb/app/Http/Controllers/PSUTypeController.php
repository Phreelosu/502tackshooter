<?php

namespace App\Http\Controllers;

use App\Models\PSUTypeModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PSUTypeController extends Controller
{
    public function index()
    {
        $psu_type = PSUTypeModel::all();
        return response()->json($psu_type);
    }
    public function show($id)
    {
        $psu_type = PSUTypeModel::findOrFail($id);
        return response()->json($psu_type);
    }
}
