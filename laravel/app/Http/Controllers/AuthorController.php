<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    public function index()
    {
        return Author::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:authors,name',
                'birth_date' => 'required|date',
            ]);

            $author = Author::create($validated);
            Log::info('Author created', ['id' => $author->id]);

            return $author;
        } catch (\Throwable $e) {
            Log::error('Author creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create author'], 500);
        }
    }

    public function show(string $id)
    {
        return Author::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        try {
            $author = Author::findOrFail($id);

            $validated = $request->validate([
                'name' => 'string|max:255|unique:authors,name' . $author->id,
                'birth_date' => 'date',
            ]);

            $author->update($validated);
            Log::info('Author updated', ['id' => $author->id]);

            return $author;
        } catch (\Throwable $e) {
            Log::error('Author update failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update author'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->delete();
            Log::info('Author deleted', ['id' => $id]);

            return response()->noContent();
        } catch (\Throwable $e) {
            Log::error('Author deletion failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete author'], 500);
        }
    }
}
