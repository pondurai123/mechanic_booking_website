<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Best AC Mechanic in Chennai - Professional Service</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
@include('layouts.header');


    <div class="container">
        <div class="header">
            <h1><i class="fas fa-snowflake"></i> Professional AC Repair Service</h1>
            <p>Your trusted air conditioning expert in Chennai</p>
        </div>

        <div class="main-content">
            <div class="mechanic-info">
                <img src="./images/mechanic.jpg" alt="AC Mechanic" class="mechanic-photo">
                
                <div class="experience-badge">
                    <i class="fas fa-star"></i> Best Experience Mechanic in Chennai <i class="fas fa-star"></i>
                </div>

                <div class="mechanic-details">
                    <h2 style="text-align: center; color: #333; margin-bottom: 15px;">Selva James K</h2>
                    <p style="text-align: center; color: #666; margin-bottom: 20px;">
                        <i class="fas fa-medal"></i> 5+ Years Experience | 
                        <i class="fas fa-tools"></i> Certified Technician | 
                        <i class="fas fa-clock"></i> 24/7 Service
                    </p>
                </div>

                <div class="services">
                    <h3><i class="fas fa-cogs"></i> Our Services</h3>
                    <div class="service-item">
                        <i class="fas fa-snowflake"></i>
                        <span>AC Installation & Repair</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-fan"></i>
                        <span>Split & Window AC Service</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-tools"></i>
                        <span>Maintenance & Cleaning</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-thermometer-half"></i>
                        <span>Gas Refilling & Leak Detection</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Warranty Service</span>
                    </div>
                </div>

                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+91 98765 43210</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@acrepairchennai.com</span>
                    </div>
                </div>
            </div>

            <div class="booking-form">
                <div class="success-message" id="successMessage" style="display: none;">
                    <i class="fas fa-check-circle"></i> Booking submitted successfully! We'll contact you soon.
                </div>

                <h2 class="form-title">
                    <i class="fas fa-calendar-check"></i> Book Your Appointment Here
                </h2>

                <form id="bookingForm">
                    <div class="form-group">
                        <label for="name"><i class="fas fa-user"></i> Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone"><i class="fas fa-phone"></i> Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="address"><i class="fas fa-map-marker-alt"></i> Address *</label>
                        <textarea id="address" name="address" rows="3" required></textarea>
                    </div>

                    <div class="form-group location-group">
                        <label for="location"><i class="fas fa-location-arrow"></i> Location Details</label>
                        <input type="text" id="location" name="location" placeholder="Auto-filled when you get location" readonly>
                        <button type="button" class="get-location-btn" onclick="getLocation()">
                            <i class="fas fa-crosshairs"></i> Get Location
                        </button>
                    </div>

                    <div class="form-group">
                        <label for="service"><i class="fas fa-wrench"></i> Service Required</label>
                        <select id="service" name="service" style="width: 100%; padding: 12px 15px; border: 2px solid #e1e5e9; border-radius: 10px; font-size: 1rem; background: rgba(255, 255, 255, 0.9);">
                            <option value="">Select Service Type</option>
                            <option value="ac-installation">AC Installation</option>
                            <option value="ac-repair">AC Repair</option>
                            <option value="ac-service">AC Service & Cleaning</option>
                            <option value="gas-refill">Gas Refilling</option>
                            <option value="maintenance">Regular Maintenance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="preferred-date"><i class="fas fa-calendar"></i> Preferred Date</label>
                        <input type="date" id="preferred-date" name="preferred_date" min="">
                    </div>

                    <div class="loading" id="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Submitting your booking...
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Submit Booking Request
                    </button>
                </form>
            </div>
        </div>

    </div>
    @include('layouts.footer');

    <a href="https://wa.me/918428399365" class="admin-link" title="Admin Panel" target="_blank">
        <i class="fas fa-user-shield"></i>
    </a>
      <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>