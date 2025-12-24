<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // GET /api/bookings
    public function index()
    {
        return response()->json([
            'data' => Booking::all()
        ]);
    }

    // POST /api/bookings
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'washer_id'      => 'required|exists:washers,id',
            'region_id'      => 'required|exists:regions,id',
            'date'           => 'required|date',
            'time_start'     => 'required|date_format:H:i:s',
            'time_end'       => 'required|date_format:H:i:s|after:time_start',
            'type'           => 'required|string|max:255',
            'status'         => 'nullable|string|in:pending,confirmed,in_progress,done,cancelled',
            'note'           => 'nullable|string|max:500',
            'comment'        => 'nullable|string|max:500',
            'payment_method' => 'required|string|max:255',
        ]);

        $validated['user_id'] = $request->user()->id;

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking created',
            'data' => $booking
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}




    // GET /api/bookings/{id}
    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json(['data' => $booking]);
    }

    // PUT /api/bookings/{id}
public function update(Request $request, $id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    // Validate only the columns that exist in the table
    $validated = $request->validate([
        'user_id'     => 'sometimes|integer|exists:user_accounts,id',
        'washer_id'   => 'sometimes|integer|exists:washers,id',
        'date'        => 'sometimes|date',
        'time_start'  => 'sometimes|string',
        'time_end'    => 'sometimes|string',
        'type'        => 'sometimes|string|max:255',
        'status'      => 'sometimes|string|max:255',
        'note'        => 'sometimes|string|max:500',
        'comment'     => 'sometimes|string|max:500',
    ]);

    $booking->update($validated);

    return response()->json([
        'message' => 'Booking updated successfully',
        'data' => $booking
    ]);
}


    // DELETE /api/bookings/{id}
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
