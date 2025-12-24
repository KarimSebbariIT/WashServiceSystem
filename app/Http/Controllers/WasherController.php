<?php

namespace App\Http\Controllers;

use App\Models\Washer;
use Illuminate\Http\Request;

class WasherController extends Controller
{
    public function index()
    {
        $washers = Washer::with('region')->get();
        return response()->json($washers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:washers,email',
            'region_id' => 'required|exists:regions,id',
        ]);

        $washer = Washer::create($validated);

        return response()->json($washer->load('region'), 201);
    }


    public function show($id)
    {
        return response()->json(
            Washer::with('region')->findOrFail($id)
        );
    }


     public function update(Request $request, $id)
    {
        $washer = Washer::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:washers,email,' . $washer->id,
            'region_id' => 'required|exists:regions,id',
        ]);

        $washer->update($validated);

        return response()->json($washer->load('region'));
    }


    public function destroy($id)
    {
        Washer::findOrFail($id)->delete();

        return response()->json(['message' => 'Washer deleted successfully']);
    }
}
