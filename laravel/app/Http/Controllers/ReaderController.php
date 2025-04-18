<?php

namespace App\Http\Controllers;
use App\Models\Reader;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ReaderController extends Controller
{
    public function index()
    {
        return Reader::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:readers,email',
            ]);

            $reader = Reader::create($validated);
            Log::info('Reader created', ['id' => $reader->id]);

            return $reader;
        } catch (\Throwable $e) {
            Log::error('Reader creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create reader'], 500);
        }
    }

    public function show(string $id)
    {
        return Reader::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        try {
            $reader = Reader::findOrFail($id);

            $validated = $request->validate([
                'name' => 'string|max:255',
                'email' => 'email|unique:readers,email,' . $reader->id,
            ]);

            $reader->update($validated);
            Log::info('Reader updated', ['id' => $reader->id]);

            return $reader;
        } catch (\Throwable $e) {
            Log::error('Reader update failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update reader'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $reader = Reader::findOrFail($id);
            $reader->delete();
            Log::info('Reader deleted', ['id' => $id]);

            return response()->noContent();
        } catch (\Throwable $e) {
            Log::error('Reader deletion failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete reader'], 500);
        }
    }
}
