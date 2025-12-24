<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    // GET /slots
    public function index()
    {
        return response()->json(Slot::all());
    }

    // POST /slots
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime'   => 'required|date|after:start_datetime',
            'slot_type_id'   => 'nullable|integer',
        ]);

        $slot = Slot::create($validated);

        return response()->json($slot, 201);
    }

    // GET /slots/{id}
    public function show($id)
    {
        return response()->json(Slot::findOrFail($id));
    }

    // PUT /slots/{id}
    public function update(Request $request, $id)
    {
        $slot = Slot::findOrFail($id);

        $validated = $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime'   => 'required|date|after:start_datetime',
            'slot_type_id'   => 'nullable|integer',
        ]);

        $slot->update($validated);

        return response()->json($slot);
    }

    // DELETE /slots/{id}
    public function destroy($id)
    {
        Slot::findOrFail($id)->delete();
        return response()->json(['message' => 'Slot deleted successfully']);
    }

    /**
 * POST /api/slots/bulk
 * Create multiple slots at once
 */
public function storeBulk(Request $request)
{
    $validated = $request->validate([
        '*.startDateTime' => 'required|date',
        '*.endDateTime' => 'required|date|after:*.startDateTime',
        '*.slotTypeId' => 'nullable|integer',
    ]);

    $slots = [];
    foreach ($request->all() as $item) {
        $slots[] = Slot::create([
            'start_datetime' => $item['startDateTime'],
            'end_datetime' => $item['endDateTime'],
            'slot_type_id' => $item['slotTypeId'] ?? null,
        ]);
    }

    return response()->json($slots, 201);
}

}
