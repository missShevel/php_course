<?php

namespace App\Http\Controllers;
use App\Models\Issue;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $query = Issue::query();
    
        if ($request->has('book_id')) {
            $query->where('book_id', $request->query('book_id'));
        }
    
        if ($request->has('reader_id')) {
            $query->where('reader_id', $request->query('reader_id'));
        }
    
        if ($request->has('issued_at')) {
            $query->whereDate('issued_at', $request->query('issued_at'));
        }

        $perPage = $request->get('itemsPerPage', 10); // Default 10 per page
        $issues = $query->paginate($perPage);
    
        return response()->json($issues);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'book_id' => 'required|exists:books,id',
                'reader_id' => 'required|exists:readers,id',
                'issued_at' => 'required|date',
            ]);

            $issue = Issue::create($validated);
            Log::info('Issue created', ['id' => $issue->id]);

            return $issue;
        } catch (\Throwable $e) {
            Log::error('Issue creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create issue'], 500);
        }
    }

    public function show(string $id)
    {
        return Issue::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        try {
            $issue = Issue::findOrFail($id);

            $validated = $request->validate([
                'book_id' => 'exists:books,id',
                'reader_id' => 'exists:readers,id',
                'issued_at' => 'date',
            ]);

            $issue->update($validated);
            Log::info('Issue updated', ['id' => $issue->id]);

            return $issue;
        } catch (\Throwable $e) {
            Log::error('Issue update failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update issue'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $issue = Issue::findOrFail($id);
            $issue->delete();
            Log::info('Issue deleted', ['id' => $id]);

            return response()->noContent();
        } catch (\Throwable $e) {
            Log::error('Issue deletion failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete issue'], 500);
        }
    }
}

