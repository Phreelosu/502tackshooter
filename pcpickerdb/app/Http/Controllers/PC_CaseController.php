<?php

namespace App\Http\Controllers;

use App\Models\PC_CaseModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PC_CaseController extends Controller
{
    /**
     * Display a listing of the PC cases.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pcCases = PC_CaseModel::all();
        return response()->json($pcCases);
    }

    /**
     * Store a newly created PC case in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Case_name' => 'required|string|unique:pc_case',
            'Case_price' => 'required|numeric',
            'Case_type_ID' => 'required|exists:case_type,id',
            'Case_color_ID' => 'required|exists:colors,id',
            'PSU_Watts' => 'nullable|numeric',
            'Side_panel_ID' => 'required|exists:side_panel_types,id',
            'Bay_count' => 'required|numeric',
        ]);

        $pcCase = PC_CaseModel::create($request->all());
        return response()->json($pcCase, Response::HTTP_CREATED);
    }

    /**
     * Display the specified PC case.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pcCase = PC_CaseModel::findOrFail($id);
        return response()->json($pcCase);
    }

    /**
 * Update the specified PC case in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    $pcCase = PC_CaseModel::findOrFail($id);

    $validatedData = $request->validate([
        'Case_name' => 'required|string|unique:pc_case,Case_name,' . $pcCase->id,
        'Case_price' => 'required|numeric',
        'Case_type_ID' => 'required|exists:case_type,id',
        'Case_color_ID' => 'required|exists:colors,id',
        'PSU_Watts' => 'nullable|numeric',
        'Side_panel_ID' => 'required|exists:side_panel_types,id',
        'Bay_count' => 'required|numeric',
    ]);

    $pcCase->fill($validatedData)->save();

    return response()->json($pcCase, Response::HTTP_OK);
}


    /**
     * Remove the specified PC case from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pcCase = PC_CaseModel::findOrFail($id);
        $pcCase->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
