<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;

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
Route::resource('case_type', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('cpu', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('cpu_cooler', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('gpu', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('gpu_memory', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('ihd_capacity', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('ihd_form_factor', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('ihd_interface', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('ihd_type', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('internal_hard_drive', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('memory', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('memory_modules', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('mobo_form_factor', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('mobo_max_memory', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('mobo_memory_slots', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('motherboard', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('pc', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('pc_case', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('psu', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('psu_efficieny', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('psu_modular', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('psu_type', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('side_panel_types', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
Route::resource('users', ColorController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
