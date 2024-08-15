<?php

use App\Http\Controllers\api\bookController;
use App\Http\Controllers\api\userController;
use Illuminate\Support\Facades\Route;

//Register User 
Route::post('/register', [userController::class, 'register']);

//Login
Route::post('/login', [userController::class, 'login']);



Route::middleware('auth:sanctum')->group(function(){
    // Create a new Book
    Route::post('/books', [BookController::class, 'store']);
     
    // Show books in paginate
    Route::get('/books', [BookController::class, 'bookPagination']);

    //Show Book By ID
    Route::get('/books/{id}', [BookController::class, 'show']);
    
    //update book
    Route::put('/books/{id}', [BookController::class, 'update']);

    //delete book
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
    
 });



 



