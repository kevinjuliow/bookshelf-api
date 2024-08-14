<?php

use App\Http\Controllers\api\bookController;
use App\Http\Controllers\api\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Create User 
Route::post('/register', [userController::class, 'signup']);

//GET ALL BOOKS
Route::get('books' , [bookController::class , 'index'] );