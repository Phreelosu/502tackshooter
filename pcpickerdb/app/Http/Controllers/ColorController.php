<?php
namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ColorController extends Controller
{
    /**
     * Display a listing of the colors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::all();
        return response()->json($colors);
    }

    /**
     * Store a newly created color in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Color' => 'required|string|unique:colors',
        ]);

        $color = Color::create($request->all());
        return response()->json($color, Response::HTTP_CREATED);
    }

    /**
     * Display the specified color.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $color = Color::findOrFail($id);
        return response()->json($color);
    }

    /**
     * Update the specified color in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $request->validate([
            'Color' => 'required|string|unique:colors,Color,' . $color->id,
        ]);

        $color->update($request->all());
        return response()->json($color, Response::HTTP_OK);
    }

    /**
     * Remove the specified color from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
