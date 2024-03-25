<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PSUModularController extends Controller
{
    public function index()
    {
        $psu_modular = PSUModularModel::all();
        return response()->json($psu_modular);
    }
}
