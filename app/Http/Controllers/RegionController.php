<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        return response()->json(Region::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $region = Region::create($validated);

        return response()->json($region, 201);
    }

    public function show($id)
    {
        return response()->json(Region::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $region->update($validated);

        return response()->json($region);
    }

    public function destroy($id)
    {
        Region::findOrFail($id)->delete();

        return response()->json(['message' => 'Region deleted successfully']);
    }
}
