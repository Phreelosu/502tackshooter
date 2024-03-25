<?php

namespace App\Http\Controllers;

use App\Models\MOBOFFModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MOBOFFController extends Controller
{
    public function index()
    {
        $mobo_form_factor = MOBOFFModel::all();
        return response()->json($mobo_form_factor);
    }
    public function show($id)
    {
        $mobo_form_factor = MOBOFFModel::findOrFail($id);
        return response()->json($mobo_form_factor);
    }
}
