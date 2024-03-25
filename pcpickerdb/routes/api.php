<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PC_CaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigController;


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

// Group routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::post("/newconfig", [ConfigController::class,"newConfig"]);
    Route::put("/modifyconfig", [ConfigController::class,"modifyConfig"]);
    Route::delete("/deleteconfig", [ConfigController::class,"deleteConfig"]);

    Route::post("/logout", [UserController::class, "logout"]);

    Route::get("/configs", [ConfigController::class,"getConfigs"]);
});

// Unauthenticated routes
Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);

//Indexed for Builder component
Route::resource('case_type', PC_CaseController::class)->only([
    'index'
]);
Route::resource('colors', PC_CaseController::class)->only([
    'index'
]);
Route::resource('cpu', PC_CaseController::class)->only([
    'index'
]);
Route::resource('cpu_cooler', PC_CaseController::class)->only([
    'index'
]);
Route::resource('gpu_memory', PC_CaseController::class)->only([
    'index'
]);
Route::resource('gpu', PC_CaseController::class)->only([
    'index'
]);
Route::resource('ihd_capacity', PC_CaseController::class)->only([
    'index'
]);
Route::resource('ihd_form_factor', PC_CaseController::class)->only([
    'index'
]);
Route::resource('ihd_interface', PC_CaseController::class)->only([
    'index'
]);
Route::resource('ihd_type', PC_CaseController::class)->only([
    'index'
]);
Route::resource('internal_hard_drive', PC_CaseController::class)->only([
    'index'
]);
Route::resource('memory_modules', PC_CaseController::class)->only([
    'index'
]);
Route::resource('memory', PC_CaseController::class)->only([
    'index'
]);
Route::resource('mobo_form_factor', PC_CaseController::class)->only([
    'index'
]);
Route::resource('mobo_max_memory', PC_CaseController::class)->only([
    'index'
]);
Route::resource('mobo_memory_slots', PC_CaseController::class)->only([
    'index'
]);
Route::resource('motherboard', PC_CaseController::class)->only([
    'index'
]);
Route::resource('side_panel_types', PC_CaseController::class)->only([
    'index'
]);
Route::resource('pc_case', PC_CaseController::class)->only([
    'index'
]);
Route::resource('psu_efficiency', PC_CaseController::class)->only([
    'index'
]);
Route::resource('psu_modular', PC_CaseController::class)->only([
    'index'
]);
Route::resource('psu_type', PC_CaseController::class)->only([
    'index'
]);
Route::resource('psu', PC_CaseController::class)->only([
    'index'
]);

//Route::post("/register", [UserController::class, "register"]);
//Route::post("/login", [UserController::class, "login"]);

//Route::put('pc_case/{id}', [PC_CaseController::class, 'update']);
