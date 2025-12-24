<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount; // <-- use your model
use App\Mail\BookingCreated;
use Illuminate\Support\Facades\Mail;

class BookingNotificationController extends Controller
{
    public function sendBookingEmail(Request $request)
    {
        $data = $request->all();

        // Validate booking object exists
        if (!isset($data['booking']) || !is_array($data['booking'])) {
            return response()->json(['error' => 'Booking object missing'], 400);
        }

        $booking = $data['booking'];

        // Validate user_id exists
        if (!isset($booking['user_id'])) {
            return response()->json(['error' => 'Booking must contain user_id'], 400);
        }

        // Retrieve user from UserAccount
        $user = UserAccount::find($booking['user_id']);
        if (!$user || !$user->email) {
            return response()->json(['error' => 'User not found or email missing'], 400);
        }

        // Send email
        Mail::to($user->email)->send(new BookingCreated($booking));


        return response()->json([
            'message' => 'Booking email sent successfully',
            'booking' => $booking
        ]);
    }
}
