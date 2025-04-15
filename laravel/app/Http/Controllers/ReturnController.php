<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnBook;


class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReturnBook::all();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issue_id' => 'required|exists:issues,id',
            'returned_at' => 'required|date',
        ]);

        return ReturnBook::create($validated);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $return;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'issue_id' => 'required|exists:issues,id',
            'returned_at' => 'required|date',
        ]);

        $return->update($validated);
        return $return;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $return->delete();
        return response()->noContent();
    }
}
