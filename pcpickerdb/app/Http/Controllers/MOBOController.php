<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MOBOController extends Controller
{
    public function index()
    {
        $motherboard = MOBOModel::all();
        return response()->json($motherboard);
    }
}
