<?php

namespace App\Http\Controllers;

use App\Models\SidePanelTypesModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SidePanelTypesController extends Controller
{
    public function index()
    {
        $side_panel_types = SidePanelTypesModel::all();
        return response()->json($side_panel_types);
    }
}
