<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * GET /api/cars
     * List ONLY cars of the connected user
     */
    public function index(Request $request)
    {
        $cars = Car::where('user_id', $request->user()->id)->get();

        return response()->json([
            'data' => $cars
        ]);
    }

    /**
     * GET /api/cars/all
     * (Optional) List ALL cars – useful for admin
     */
    public function all()
    {
        return response()->json([
            'data' => Car::all()
        ]);
    }

    /**
     * GET /api/cars/user/{userId}
     * List cars by user_id (admin / reporting)
     */
    public function listByUser($userId)
    {
        return response()->json([
            'data' => Car::where('user_id', $userId)->get()
        ]);
    }

    /**
     * GET /api/cars/{id}
     * Show one car (ownership enforced)
     */
    public function show(Request $request, $id)
    {
        $car = Car::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        return response()->json(['data' => $car]);
    }
    

    /**
     * POST /api/cars
     * Create a car for the connected user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'model'    => 'required|string|max:255',
            'car_type' => 'required|string|max:255',
        ]);

        $car = Car::create([
            ...$validated,
            'user_id' => $request->user()->id, // 🔒 enforced
        ]);

        return response()->json([
            'message' => 'Car created successfully',
            'data' => $car
        ], 201);
    }

    /**
     * PUT /api/cars/{id}
     * Update a car (ownership enforced)
     */
    public function update(Request $request, $id)
    {
        $car = Car::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'model'    => 'sometimes|string|max:255',
            'car_type' => 'sometimes|string|max:255',
        ]);

        $car->update($validated);

        return response()->json([
            'message' => 'Car updated successfully',
            'data' => $car
        ]);
    }

    /**
     * DELETE /api/cars/{id}
     * Delete a car (ownership + safety check)
     */
    public function destroy(Request $request, $id)
    {
        $car = Car::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        // Prevent deleting car used in bookings
        if ($car->bookings()->exists()) {
            return response()->json([
                'message' => 'Cannot delete a car used in bookings'
            ], 409);
        }

        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully'
        ]);
    }
}
