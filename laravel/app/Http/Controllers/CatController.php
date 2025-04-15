<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cat;


class CatController extends Controller
{
    //
    public function getAll()
    {
        $cats = Cat::all();
        return response()->json($cats);
    }

    public function getById($id)
    {
        $cat = Cat::findOrFail($id);
        return response()->json($cat);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'breed' => 'required',
            'color' => 'required',
            'character' => 'required',
        ]);

        $cat = Cat::create($request->all());
        return response()->json($cat, 201);
    }

    public function update(Request $request, $id)
    {
        $cat = Cat::findOrFail($id);
        $cat->update($request->all());
        return response()->json($cat);
    }

    public function delete($id)
    {
        $cat = Cat::findOrFail($id);
        $cat->delete();
        return response()->json(null, 204);
    }
}
