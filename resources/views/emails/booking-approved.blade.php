<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .booking-details { background: white; padding: 15px; border-left: 4px solid #28a745; margin: 15px 0; }
        .contact-info { background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>✅ Booking Approved!</h2>
            <p>AC Repair Service</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $booking->name }},</p>
            <p>Great news! Your AC repair service booking has been approved.</p>
            
            <div class="booking-details">
                <h3>Your Booking Details</h3>
                <p><strong>Service:</strong> {{ $booking->service ? ucfirst(str_replace('-', ' ', $booking->service)) : 'AC Repair Service' }}</p>
                <p><strong>Address:</strong> {{ $booking->address }}</p>
                @if($booking->preferred_date)
                    <p><strong>Preferred Date:</strong> {{ $booking->preferred_date->format('M d, Y') }}</p>
                @endif
                <p><strong>Booking Reference:</strong> #{{ $booking->id }}</p>
            </div>
            
            <div class="contact-info">
                <h3>🔧 Your assigned technician:</h3>
                <p><strong>Name:</strong> {{ $mechanic->name }}</p>
                <p><strong>Phone:</strong> {{ $mechanic->phone }}</p>
                <p>They will contact you shortly to confirm the appointment.</p>
            </div>
            
            <p>Thank you for choosing our AC repair service. We look forward to serving you!</p>
            
            <p>Best regards,<br>
            <strong>AC Repair Service Team</strong></p>
        </div>
    </div>
</body>
</html>