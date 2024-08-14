<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function bookPagination(Request $request)
    {
    $perPage = $request->input('per_page', 5);

    $books = Book::orderBy('title', 'asc')->paginate($perPage);

    return response()->json([
        'current_page' => $books->currentPage(),    
        'data' => $books->items(),
        'first_page_url' => $books->url(1),
        'from' => $books->firstItem(),
        'last_page' => $books->lastPage(),
        'last_page_url' => $books->url($books->lastPage()),
        'next_page_url' => $books->nextPageUrl(),
        'per_page' => $books->perPage(),
        'path' => $books->path(),
        'prev_page_url' => $books->previousPageUrl(),
        'to' => $books->lastItem(),
        'total' => $books->total()
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
