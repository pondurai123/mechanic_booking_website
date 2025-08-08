<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Best AC Mechanic in Chennai - Professional Service</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            animation: fadeInDown 1s ease-out;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
            min-height: 600px;
        }

        .mechanic-info {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            animation: slideInLeft 1s ease-out;
        }

        .mechanic-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            border: 5px solid #667eea;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .experience-badge {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(255,107,107,0.3);
            animation: pulse 2s infinite;
        }

        .services {
            margin-top: 20px;
        }

        .services h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .service-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 8px;
        }

        .service-item i {
            color: #667eea;
            margin-right: 10px;
            width: 20px;
        }

        .booking-form {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            animation: slideInRight 1s ease-out;
        }

        .form-title {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-size: 1.8rem;
            position: relative;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .location-group {
            position: relative;
        }

        .get-location-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .get-location-btn:hover {
            background: #5a6fd8;
            transform: translateY(-50%) scale(1.05);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .contact-info {
            margin-top: 20px;
            text-align: center;
        }

        .contact-item {
            display: inline-flex;
            align-items: center;
            margin: 0 15px;
            color: #666;
        }

        .contact-item i {
            margin-right: 8px;
            color: #667eea;
        }

        .admin-link {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #ff6b6b;
            color: white;
            padding: 15px;
            border-radius: 50%;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .admin-link:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .loading {
            display: none;
            text-align: center;
            color: #667eea;
        }

        .success-message {
            display: none;
            background: linear-gradient(45deg, #00b894, #55efc4);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .mechanic-info,
            .booking-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
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

    <a href="https://wa.me/918428399365" class="admin-link" title="Admin Panel" target="_blank">
        <i class="fas fa-user-shield"></i>
    </a>

    <script>
        // Set minimum date to today
        document.getElementById('preferred-date').min = new Date().toISOString().split('T')[0];

        // Get user location
        function getLocation() {
            const locationInput = document.getElementById('location');
            const button = document.querySelector('.get-location-btn');
            
            if (navigator.geolocation) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Using reverse geocoding service (in real app, you'd use Google Maps API)
                        fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=en`)
                            .then(response => response.json())
                            .then(data => {
                                locationInput.value = `${data.locality}, ${data.city}, ${data.principalSubdivision} (${lat.toFixed(6)}, ${lng.toFixed(6)})`;
                                button.innerHTML = '<i class="fas fa-check"></i>';
                                button.style.background = '#00b894';
                                setTimeout(() => {
                                    button.innerHTML = '<i class="fas fa-crosshairs"></i> Get Location';
                                    button.style.background = '#667eea';
                                    button.disabled = false;
                                }, 2000);
                            })
                            .catch(error => {
                                locationInput.value = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
                                button.innerHTML = '<i class="fas fa-crosshairs"></i> Get Location';
                                button.disabled = false;
                            });
                    },
                    function(error) {
                        alert('Error getting location: ' + error.message);
                        button.innerHTML = '<i class="fas fa-crosshairs"></i> Get Location';
                        button.disabled = false;
                    }
                );
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const loading = document.getElementById('loading');
            const successMessage = document.getElementById('successMessage');
            const submitBtn = document.querySelector('.submit-btn');
            
            // Show loading
            loading.style.display = 'block';
            submitBtn.style.display = 'none';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page.');
                loading.style.display = 'none';
                submitBtn.style.display = 'block';
                return;
            }
            
            // Prepare form data
            const formData = new FormData(this);
            
            // Send to Laravel backend
            fetch('/api/bookings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                loading.style.display = 'none';
                submitBtn.style.display = 'block';
                
                if (data.success) {
                    successMessage.style.display = 'block';
                    this.reset();
                    
                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 5000);
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loading.style.display = 'none';
                submitBtn.style.display = 'block';
                alert('Error submitting booking: ' + error.message + '. Please try again.');
            });
        });

        // Add some interactive animations
        document.querySelectorAll('.form-group input, .form-group textarea, .form-group select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>