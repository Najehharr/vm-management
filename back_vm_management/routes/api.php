<?php
use App\Http\Controllers\VmController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\AllocationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//when i usel the casual route doesn't work?
Route::post('/login', function () {
    return response()->json(['success' => true]);
});



Route::post('/register', [RegisterController::class, 'register']);


Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients', [ClientController::class, 'index']);
Route::put('/clients/{id}', [ClientController::class, 'update']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
Route::get('clients/cins', [ClientController::class, 'getAllClientsCINs']);



Route::put('/servers/{id}', [ServerController::class, 'update']);
Route::get('/servers', [ServerController::class, 'index']);
Route::delete('/servers/{id}', [ServerController::class, 'destroy']);



Route::get('/vms', [VmController::class, 'index']);
Route::post('/vms', [VmController::class, 'store']);
Route::put('/vms/{id}', [VmController::class, 'update']);
Route::delete('/vms/{id}', [VmController::class, 'destroy']);





Route::get('/allocations', [AllocationController::class, 'index']);

Route::post('/allocations', [AllocationController::class, 'store']);

Route::put('/allocations/{id}', [AllocationController::class, 'update']);

Route::delete('/allocations/{id}', [AllocationController::class, 'destroy']);

Route::get('/client-email/{cin}', [AllocationController::class, 'getClientEmail']);

Route::post('/send-allocation-email', [AllocationController::class, 'sendAllocationEmail']);

Route::get('clients/cins', [AllocationController::class, 'getAllClientsCINs']);





