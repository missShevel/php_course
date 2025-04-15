<?php

namespace App\Http\Controllers;
use App\Models\Issue;


use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Issue::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'reader_id' => 'required|exists:readers,id',
            'issued_at' => 'required|date',
        ]);

        return Issue::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $issue;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'reader_id' => 'required|exists:readers,id',
            'issued_at' => 'required|date',
        ]);

        $issue->update($validated);
        return $issue;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $issue->delete();
        return response()->noContent();
    }
}
