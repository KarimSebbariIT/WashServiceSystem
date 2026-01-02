<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #121417; color: #E5E7EB; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #1E2227; border-radius: 12px; padding: 20px;">
        <!-- Header -->
        <h2 style="color: #84cc16; text-align: center; margin-bottom: 20px;">Booking Confirmation</h2>

        <!-- Greeting -->
        <p>Hi <strong>{{ $booking['user_name'] ?? 'Customer' }}</strong>,</p>
        <p>Thank you for booking with <strong>WashService</strong>. Your appointment has been successfully created. Here are your booking details:</p>

        <!-- Booking Details -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tbody>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">Service:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">{{ $booking['service'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">Date:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">{{ $booking['date'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">Time:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">{{ $booking['time_start'] }} → {{ $booking['time_end'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">Car:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">{{ $booking['car_name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">Location:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">{{ $booking['location'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">Payment:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #333;">{{ $booking['payment_method'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;">Notes:</td>
                    <td style="padding: 8px;">{{ $booking['note'] ?? 'None' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <p style="margin-top: 20px;">We look forward to serving you!</p>
        <p style="color: #6B7280; font-size: 0.8em;">Please do not reply to this email. This is an automated message from WashService.</p>
    </div>
</body>
</html>
