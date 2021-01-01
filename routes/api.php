<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EwalletController;
use App\Http\Controllers\API\MutationController;
use App\Http\Controllers\API\TopupController;
use App\Http\Controllers\API\TransferController;
use App\Http\Controllers\API\WithdrawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=> 'auth:sanctum'], function(){
    Route::post('/transaction', [EwalletController::class, 'ewalletTransaction']);
    Route::post('/topup', [TopupController::class, 'topupEwallet']);
    Route::post('/withdraw', [WithdrawController::class, 'withdrawEwallet']);
    Route::post('/transfer', [TransferController::class, 'transferEwallet']);
    Route::get('/mutation/{id}', [MutationController::class, 'mutationEwallet']);
    Route::get('/user/{id}', [AuthController::class, 'getUserById']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
