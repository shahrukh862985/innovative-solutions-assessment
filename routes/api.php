<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentsController;
use App\Http\Controllers\API\FilmsController;
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


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::controller(FilmsController::class)->group(function () {
    Route::get('/films', 'index');
    Route::get('/films/{id}', 'show');
});
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout',[AuthController::class,'logout']);

    Route::controller(FilmsController::class)->group(function () {
        Route::post('/films', 'store');
    });

    Route::post('/comments',[CommentsController::class,'store']);
});
