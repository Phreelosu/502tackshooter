<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PC_CaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('colors', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('pc_case', PC_CaseController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

//Route::put('pc_case/{id}', [PC_CaseController::class, 'update']);
