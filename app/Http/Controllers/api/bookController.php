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
    public function index()
    {
        // $books = book::orderBy('title' , 'asc')->get() ; 
        // return response()->json(['message' => 'Testing' ] , 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validRequest = Validator::make($request->all() , [
            'isbn' => 'required',
            'title' => 'required',
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


        $book = $request->user()->books()->create([
            'isbn' => $request->isbn,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'author' => $request->author,
            'published' => $request->published,
            'publisher' => $request->publisher,
            'pages' => $request->pages,
            'description' => $request->description,
            'website' => $request->website,
        ] , 201);

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
