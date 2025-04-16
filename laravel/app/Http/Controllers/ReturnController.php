<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnBook;


use Illuminate\Support\Facades\Log;

class ReturnController extends Controller
{
    public function index()
    {
        return ReturnBook::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'issue_id' => 'required|exists:issues,id',
                'returned_at' => 'required|date',
            ]);

            $return = ReturnBook::create($validated);
            Log::info('Return recorded', ['id' => $return->id]);

            return $return;
        } catch (\Throwable $e) {
            Log::error('Return creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to record return'], 500);
        }
    }

    public function show(string $id)
    {
        return ReturnBook::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        try {
            $return = ReturnBook::findOrFail($id);

            $validated = $request->validate([
                'issue_id' => 'exists:issues,id',
                'returned_at' => 'date',
            ]);

            $return->update($validated);
            Log::info('Return updated', ['id' => $return->id]);

            return $return;
        } catch (\Throwable $e) {
            Log::error('Return update failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update return'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $return = ReturnBook::findOrFail($id);
            $return->delete();
            Log::info('Return deleted', ['id' => $id]);

            return response()->noContent();
        } catch (\Throwable $e) {
            Log::error('Return deletion failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete return'], 500);
        }
    }
}
