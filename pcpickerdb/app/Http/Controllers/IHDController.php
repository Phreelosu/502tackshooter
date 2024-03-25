<?php

namespace App\Http\Controllers;

use App\Models\IHDModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IHDController extends Controller
{
    public function index()
    {
        $internal_hard_drive = IHDModel::all();
        return response()->json($internal_hard_drive);
    }
}
