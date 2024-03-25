<?php

namespace App\Http\Controllers;

use App\Models\PSUModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PSUController extends Controller
{
    public function index()
    {
        $psu = PSUModel::all();
        return response()->json($psu);
    }
    public function show($id)
    {
        $psu = PSUModel::findOrFail($id);
        return response()->json($psu);
    }
}
