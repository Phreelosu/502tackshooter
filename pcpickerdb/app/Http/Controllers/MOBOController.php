<?php

namespace App\Http\Controllers;

use App\Models\MOBOModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MOBOController extends Controller
{
    public function index()
    {
        $motherboard = MOBOModel::all();
        return response()->json($motherboard);
    }
    public function show($id)
    {
        $motherboard = MOBOModel::findOrFail($id);
        return response()->json($motherboard);
    }
}
