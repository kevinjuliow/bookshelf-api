<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bookController extends Controller
{
    /**
     * Display a listing of the books using pagination.
     */

    public function bookPagination()
    {

    $books = Book::orderBy('title', 'asc')->paginate(10);

    return response()->json([
        $books
    ], 200);
    }

    /**
     * Store a new book.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }


        $validRequest = Validator::make($request->all() , [
            'isbn' => 'required',
            'title' => 'required',
            "subtitle" => "nullable|string",
            "author" => "nullable|string",
            "published" => "nullable|string",
            "publisher" => "nullable|string",
            "pages" => "nullable|integer",
            "description" => "nullable|string",
            "website" => "nullable|string"
        ]);

        if ($validRequest->fails()){
            return response()->json([
                "message" => "string" , 
                "errors" => [
                    "isbn" => "[`string`]",
                    "title" => "[`string`]",
                    "subtitle" => "[`string`]",
                    "author" => "[`string`]",
                    "published" => "[`string`]",
                    "publisher" => "[`string`]",
                    "pages" => "[`string`]",
                    "description" => "[`string`]",
                    "website" => "[`string`]"
                ]
            ] , 422);
        }

       

        $book = new book ([
            'isbn' => $request->isbn,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'author' => $request->author,
            'published' => $request->published,
            'publisher' => $request->publisher,
            'pages' => $request->pages,
            'description' => $request->description,
            'website' => $request->website,
        ]);

        $user->books()->save($book);    

        return response()->json([
            "message" => "Book Created" , 
            "book" => $book
        ] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request , string $id)
    {
        $book = Book::find($id);
        $user = $request->user();

        if (!$book) {
             return response()->json([
                'message' => 'No query result for model [App\\Models\\Book] 999'
            ] , 404);
        }

        if ($book->user_id != $user->id){
            return response()->json([
                'message' => 'this action is unauthorized'
            ] , 403);
        }

        return response()->json([
            $book
        ] , 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $book = Book::find($id);
        $user = $request->user();
        
        if (!$book) {
            return response()->json([
               'message' => 'No query result for model [App\\Models\\Book] 999'
           ] , 404);
       }

       if ($book->user_id != $user->id){
           return response()->json([
               'message' => 'this action is unauthorized'
           ] , 403);
       }


        $validRequest = Validator::make($request->all() , [
            'isbn' => 'required',
            'title' => 'required',
            "subtitle" => "nullable|string",
            "author" => "nullable|string",
            "published" => "nullable|string",
            "publisher" => "nullable|string",
            "pages" => "nullable|integer",
            "description" => "nullable|string",
            "website" => "nullable|string"
        ]);

        if ($validRequest->fails()){
            return response()->json([
                "message" => "string" , 
                "errors" => [
                    "isbn" => "[`string`]",
                    "title" => "[`string`]",
                    "subtitle" => "[`string`]",
                    "author" => "[`string`]",
                    "published" => "[`string`]",
                    "publisher" => "[`string`]",
                    "pages" => "[`string`]",
                    "description" => "[`string`]",
                    "website" => "[`string`]"
                ]
            ] , 422);
        }

        $book->update($request->only([
            'isbn', 'title', 'subtitle', 'author', 'published', 'publisher', 'pages', 'description', 'website'
        ]));
    
        return response()->json([
            'message' => 'Book updated',
            'book' => $book
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $book = Book::find($id);
        $user = $request->user();
        
        if (!$book) {
            return response()->json([
               'message' => 'No query result for model [App\\Models\\Book] 999'
           ] , 404);
       }

       if ($book->user_id != $user->id){
           return response()->json([
               'message' => 'this action is unauthorized'
           ] , 403);
       }
    
        // Delete the book
        $book->delete();
    
        return response()->json([
            'message' => 'Book deleted' , 
            'book' => $book
        ], 200);
    }
}
