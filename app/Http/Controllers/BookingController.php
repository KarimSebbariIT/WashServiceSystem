<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingCreated;

class BookingController extends Controller
{
    // GET /api/bookings
    public function index()
    {
        // Eager load car and washer relations
        $bookings = Booking::with(['car', 'washer'])->get();

        // Transform response to include car name and washer name
        $data = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'washer_id' => $booking->washer_id,
                'washer_name' => $booking->washer ? $booking->washer->name : null, // added
                'region_id' => $booking->region_id,
                'car_id' => $booking->car_id,
                'car_name' => $booking->car ? $booking->car->name : null,
                'date' => $booking->date,
                'time_start' => $booking->time_start,
                'time_end' => $booking->time_end,
                'type' => $booking->type,
                'status' => $booking->status,
                'note' => $booking->note,
                'comment' => $booking->comment,
                'payment_method' => $booking->payment_method,
                'location' => $booking->location,
            ];
        });

        return response()->json(['data' => $data]);
    }


    // POST /api/bookings
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => 'required|integer|exists:user_accounts,id',
            'washer_id'      => 'required|integer|exists:washers,id',
            'region_id'      => 'required|integer|exists:regions,id',
            'car_id'         => 'required|integer|exists:cars,id',
            'date'           => 'required|date',
            'time_start'     => 'required|string|max:10',
            'time_end'       => 'required|string|max:10',
            'type'           => 'required|string|max:255',
            'status'         => 'required|string|max:255',
            'note'           => 'nullable|string|max:500',
            'comment'        => 'nullable|string|max:500',
            'payment_method' => 'required|string|max:255',
            'location'       => 'required|string|max:255',
        ]);

        Log::info('Booking payload received:', $validated);

        $user = UserAccount::find($validated['user_id']);
        if (!$user || !$user->email) {
            Log::error('User not found or email missing');
            return response()->json(['error' => 'User not found or email missing'], 400);
        }

        // Create booking
        $booking = Booking::create($validated);

        // Load the car relationship
        $booking->load('car');

        $emailData = [
            'user_name'      => $user->name,
            'service'        => $booking->type,
            'date'           => $booking->date,
            'time_start'     => $booking->time_start,
            'time_end'       => $booking->time_end,
            'car_name'       => $booking->car ? $booking->car->name : 'N/A', // ← fixed
            'location'       => $booking->location,
            'payment_method' => $booking->payment_method,
            'note'           => $booking->note,
        ];

        try {
            Mail::to($user->email)->send(new BookingCreated($emailData));
            Log::info('Booking email sent to: ' . $user->email);
        } catch (\Exception $e) {
            Log::error("Booking email failed: " . $e->getMessage());
        }

        return response()->json([
            'message' => 'Booking created successfully, email sent if configured',
            'booking' => $booking
        ], 201);
    }


    // GET /api/bookings/{id}
    public function show($id)
    {
        $booking = Booking::with('car')->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Include car name in response
        $data = $booking->toArray();
        $data['car_name'] = $booking->car ? $booking->car->name : null;

        return response()->json(['data' => $data]);
    }

    // PUT /api/bookings/{id}
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $validated = $request->validate([
            'user_id'     => 'sometimes|integer|exists:user_accounts,id',
            'washer_id'   => 'sometimes|integer|exists:washers,id',
            'region_id'   => 'sometimes|integer|exists:regions,id',
            'car_id'      => 'sometimes|nullable|exists:cars,id', // added car_id
            'date'        => 'sometimes|date',
            'time_start'  => 'sometimes|string',
            'time_end'    => 'sometimes|string',
            'type'        => 'sometimes|string|max:255',
            'status'      => 'sometimes|string|max:255',
            'note'        => 'sometimes|string|max:500',
            'comment'     => 'sometimes|string|max:500',
            'payment_method' => 'sometimes|string|max:255',
            'location'       => 'nullable|string|max:255',
        ]);

        $booking->update($validated);

        return response()->json([
            'message' => 'Booking updated successfully',
            'data' => $booking->load('car') // include car relation
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

    // GET /api/bookings/user/{userId}
    public function getByUser($userId)
    {
        $bookings = Booking::with(['car', 'washer'])
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();

        $data = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'washer_id' => $booking->washer_id,
                'washer_name' => $booking->washer ? $booking->washer->name : null,
                'region_id' => $booking->region_id,
                'car_id' => $booking->car_id,
                'car_name' => $booking->car ? $booking->car->name : null,
                'date' => $booking->date,
                'time_start' => $booking->time_start,
                'time_end' => $booking->time_end,
                'type' => $booking->type,
                'status' => $booking->status,
                'note' => $booking->note,
                'comment' => $booking->comment,
                'payment_method' => $booking->payment_method,
                'location' => $booking->location,
            ];
        });

        return response()->json(['data' => $data]);
    }
}
