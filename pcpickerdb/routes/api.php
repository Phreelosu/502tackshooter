<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PC_CaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CPUController;
use App\Http\Controllers\CPUCoolerController;
use App\Http\Controllers\GPUController;
use App\Http\Controllers\GPUMemoryController;
use App\Http\Controllers\IHDCapacityController;
use App\Http\Controllers\IHDController;
use App\Http\Controllers\IHDFormFactorController;
use App\Http\Controllers\IHDTypeController;
use App\Http\Controllers\MemoryController;
use App\Http\Controllers\MemoryModulesController;
use App\Http\Controllers\MOBOController;
use App\Http\Controllers\MOBOFFController;
use App\Http\Controllers\MOBOMMController;
use App\Http\Controllers\MOBOMSController;
use App\Http\Controllers\PSUEfficiencyController;
use App\Http\Controllers\PSUModularController;
use App\Http\Controllers\PSUTypeController;
use App\Http\Controllers\PSUController;
use App\Http\Controllers\SidePanelTypesController;


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

Route::middleware('auth:sanctum')->get('/configs/{id}', [ConfigController::class, 'getConfig']);

// Unauthenticated routes
Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);

//Indexed for Builder component
Route::resource('case_type', CaseTypeController::class)->only([
    'index', 'show'
]);
Route::resource('colors', ColorController::class)->only([
    'index', 'show'
]);
Route::resource('cpu', CPUController::class)->only([
    'index', 'show'
]);
Route::resource('cpu_cooler', CPUCoolerController::class)->only([
    'index', 'show'
]);
Route::resource('gpu_memory', GPUMemoryController::class)->only([
    'index', 'show'
]);
Route::resource('gpu', GPUController::class)->only([
    'index', 'show'
]);
Route::resource('ihd_capacity', IHDCapacityController::class)->only([
    'index', 'show'
]);
Route::resource('ihd_form_factor', IHDFormFactorController::class)->only([
    'index', 'show'
]);
Route::resource('ihd_interface', IHDInterfaceController::class)->only([
    'index', 'show'
]);
Route::resource('ihd_type', IHDTypeController::class)->only([
    'index', 'show'
]);
Route::resource('internal_hard_drive', IHDController::class)->only([
    'index', 'show'
]);
Route::resource('memory_modules', MemoryModulesController::class)->only([
    'index', 'show'
]);
Route::resource('memory', MemoryController::class)->only([
    'index', 'show'
]);
Route::resource('mobo_form_factor', MOBOFFController::class)->only([
    'index', 'show'
]);
Route::resource('mobo_max_memory', MOBOMMController::class)->only([
    'index', 'show'
]);
Route::resource('mobo_memory_slots', MOBOMSController::class)->only([
    'index', 'show'
]);
Route::resource('motherboard', MOBOController::class)->only([
    'index', 'show'
]);
Route::resource('side_panel_types', SidePanelTypesController::class)->only([
    'index', 'show'
]);
Route::resource('pc_case', PC_CaseController::class)->only([
    'index', 'show'
]);
Route::resource('psu_efficiency', PSUEfficiencyController::class)->only([
    'index', 'show'
]);
Route::resource('psu_modular', PSUModularController::class)->only([
    'index', 'show'
]);
Route::resource('psu_type', PSUTypeController::class)->only([
    'index', 'show'
]);
Route::resource('psu', PSUController::class)->only([
    'index', 'show'
]);

//Route::post("/register", [UserController::class, "register"]);
//Route::post("/login", [UserController::class, "login"]);

//Route::put('pc_case/{id}', [PC_CaseController::class, 'update']);
