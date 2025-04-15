<?php

namespace App\Http\Controllers;
use App\Models\Book;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
        ]);

        return Book::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $book;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info("123123123");
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'exists:authors,id',
            'published_year' => 'integer'
        ]);

        $book->update($validated);
        return $book;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book->delete();
        return response()->noContent();
    }
}
