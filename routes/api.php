<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::get('/email/{id}/{type?}', [UserController::class, 'email']);
Route::post('login', [UserController::class, 'login']);
Route::get('/user',[UserController::class, 'getUser'])->middleware('auth:api');
Route::get('/user-by-admin',[UserController::class, 'getUserByAdmin'])->middleware('auth:api');
Route::post('/create/{type?}',[UserController::class, 'createStundent'])->middleware('auth:api');
Route::delete('/delete-student/{id}',[UserController::class, 'deleteStundent'])->middleware('auth:api');
Route::delete('/delete-teacher/{id}',[UserController::class, 'deleteTeacher'])->middleware('auth:api');
Route::post('/messages/{id?}',[UserController::class, 'sendMessage'])->middleware('auth:api');
Route::get('/messages/{id?}',[UserController::class, 'getMessage'])->middleware('auth:api');