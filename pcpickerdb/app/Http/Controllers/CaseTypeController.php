<?php

namespace App\Http\Controllers;

use App\Models\CaseTypeModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CaseTypeController extends Controller
{
    public function index()
    {
        $case_type = CaseTypeModel::all();
        return response()->json($case_type);
    }
    public function show($id)
    {
        $case_type = CaseTypeModel::findOrFail($id);
        return response()->json($case_type);
    }
}
