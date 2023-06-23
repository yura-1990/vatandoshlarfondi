<?php

use Illuminate\Support\Facades\Route;
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


Route::post('/chat', [\App\Http\Controllers\Api\MessageController::class, 'broadcast']);


Route::get('/login', function (){
    $data = [
        'msg'=>'unauthorized'
    ];
    return response()->json($data);
})->name('login');
