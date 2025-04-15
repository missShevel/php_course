<?php

namespace App\Http\Controllers;
use App\Models\Reader;


use Illuminate\Http\Request;

class ReaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Reader::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:readers,email',
        ]);

        return Reader::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $reader;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:readers,email,' . $reader->id,
        ]);

        $reader->update($validated);
        return $reader;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reader->delete();
        return response()->noContent();
    }
}
