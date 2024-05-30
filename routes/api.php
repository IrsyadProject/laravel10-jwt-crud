<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('users', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('addmahasiswa', [MahasiswaController::class, 'store']);
    Route::get('mahasiswa/{id}', [MahasiswaController::class, 'show']);
    Route::put('updatemahasiswa/{id}', [MahasiswaController::class, 'update']);
    Route::delete('deletemahasiswa/{id}', [MahasiswaController::class, 'destroy']);
    Route::get('mahasiswa', [MahasiswaController::class, 'index']);
});

