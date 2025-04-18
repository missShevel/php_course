<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:books,title',
                'author_id' => 'required|exists:authors,id',
                'published_year' => 'nullable|integer|min:0|max:' . date('Y'),
            ]);

            $book = Book::create($validated);

            Log::info('Book created', ['book_id' => $book->id]);

            return response()->json($book, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Failed to create book', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create book'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            Log::warning("Book not found", ['book_id' => $id]);
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        return $book;
    }

    public function update(Request $request, string $id)
    {
        try {
            $book = Book::find($id);

            if (!$book) {
                Log::warning("Attempted to update non-existent book", ['book_id' => $id]);
                return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
            }

            $validated = $request->validate([
                'title' => 'string|max:255|unique:books,title' . $book->id,
                'author_id' => 'exists:authors,id',
                'published_year' => 'nullable|integer|min:0|max:' . date('Y'),
            ]);

            $book->update($validated);

            Log::info('Book updated', ['book_id' => $book->id]);

            return response()->json($book);
        } catch (Exception $e) {
            Log::error('Failed to update book', ['book_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update book'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id)
    {
        try {
            $book = Book::find($id);

            if (!$book) {
                Log::warning("Attempted to delete non-existent book", ['book_id' => $id]);
                return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
            }

            $book->delete();

            Log::info('Book deleted', ['book_id' => $id]);

            return response()->noContent();
        } catch (Exception $e) {
            Log::error('Failed to delete book', ['book_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to delete book'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
