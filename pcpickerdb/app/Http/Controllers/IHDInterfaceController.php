<?php

namespace App\Http\Controllers;

use App\Models\IHDInterfaceModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IHDInterfaceController extends Controller
{
    public function index()
    {
        $ihd_interface = IHDInterfaceModel::all();
        return response()->json($ihd_interface);
    }
}
