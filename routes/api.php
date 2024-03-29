<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

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

Route::get('/test',[ApiController::class,'test']);

Route::get('/fetch-notes',[ApiController::class,'fetchNotes']);
Route::get('/fetch-note/{slug}',[ApiController::class,'fetchNote']);
Route::post('/create-note',[ApiController::class,'createNote']);
Route::put('/update-note',[ApiController::class,'updateNote']);
Route::delete('/delete-note',[ApiController::class,'deleteNote']);

