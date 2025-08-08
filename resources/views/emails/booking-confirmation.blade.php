<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Booking Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .booking-details { background: white; padding: 15px; border-left: 4px solid #667eea; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Booking Request</h2>
            <p>AC Repair Service</p>
        </div>
        
        <div class="content">
            <p>Hello Admin,</p>
            <p>You have received a new booking request with the following details:</p>
            
            <div class="booking-details">
                <h3>Customer Information</h3>
                <p><strong>Name:</strong> {{ $booking->name }}</p>
                <p><strong>Email:</strong> {{ $booking->email }}</p>
                <p><strong>Phone:</strong> {{ $booking->phone }}</p>
                <p><strong>Address:</strong> {{ $booking->address }}</p>
                @if($booking->location)
                    <p><strong>Location:</strong> {{ $booking->location }}</p>
                @endif
                @if($booking->service)
                    <p><strong>Service:</strong> {{ ucfirst(str_replace('-', ' ', $booking->service)) }}</p>
                @endif
                @if($booking->preferred_date)
                    <p><strong>Preferred Date:</strong> {{ $booking->preferred_date->format('M d, Y') }}</p>
                @endif
                <p><strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y H:i A') }}</p>
            </div>
            
            <p>Please log in to the admin panel to approve or manage this booking.</p>
            
            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ url('/admin') }}" style="background: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">
                    View in Admin Panel
                </a>
            </div>
        </div>
    </div>
</body>
</html>