<?php

use App\Http\Controllers\api\bookController;
use App\Http\Controllers\api\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Register User 
Route::post('/register', [userController::class, 'signup']);

//Login
Route::post('/login', [userController::class, 'signin']);

//GET ALL BOOKS
Route::get('/books' , [bookController::class , 'index'] );


//Create a new Book
Route::post('/books', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');