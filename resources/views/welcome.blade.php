<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best AC Mechanic in Chennai - Professional Service</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #0ea5e9;
            --dark-color: #1e293b;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Header Styles */
        .main-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-brand i {
            font-size: 2rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .logo-text h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo-text p {
            margin: 0;
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link i {
            margin-right: 5px;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Full-Screen Hero Slider */
        .hero-slider {
            margin: 0;
            padding: 0;
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }

        .carousel-item {
            height: 600px;
        }

        .carousel-item img {
            height: 100%;
            object-fit: cover;
            width: 100%;
        }

        .carousel-item video {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            bottom: 10%;
        }

        .carousel-caption h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .carousel-caption p {
            font-size: 1.3rem;
        }

        /* Main Content */
        .header-section {
            text-align: center;
            padding: 40px 0;
            background: linear-gradient(135deg, var(--light-bg) 0%, white 100%);
            border-radius: 15px;
            margin-bottom: 30px;
            margin-top: 40px;
        }

        .header-section h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 15px;
        }

        /* Services Grid Section */
        .services-section {
            padding: 40px 0;
        }

        .services-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .services-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .services-container {
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }

        .services-scroll-wrapper {
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 20px;
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        .services-scroll-wrapper::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 0 10px;
        }

        .service-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .service-media-container {
            position: relative;
            height: 180px;
            width: 100%;
            overflow: hidden;
        }

        .service-image {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .service-video {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .video-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(37, 99, 235, 0.8);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .video-play-btn:hover {
            background: var(--primary-color);
            transform: translate(-50%, -50%) scale(1.1);
        }

        .media-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .service-content {
            padding: 20px;
        }

        .service-content h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .service-content p {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .service-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .price {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .view-details-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-details-btn:hover {
            background: var(--secondary-color);
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(37, 99, 235, 0.8);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .scroll-btn:hover {
            background: var(--primary-color);
        }

        .scroll-left {
            left: 10px;
        }

        .scroll-right {
            right: 10px;
        }

        /* Service Detail Page */
        .service-detail-page {
            display: none;
            padding: 40px 0;
        }

        .service-detail-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .service-detail-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .back-to-services {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-to-services:hover {
            color: var(--secondary-color);
            transform: translateX(-5px);
        }

        .service-detail-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .service-detail-media {
            width: 100%;
            height: 400px;
            border-radius: 10px;
            margin-bottom: 25px;
            overflow: hidden;
            position: relative;
        }

        .service-detail-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-detail-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-features {
            margin: 30px 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            padding: 10px;
            background: var(--light-bg);
            border-radius: 8px;
        }

        .feature-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Mechanic Details Page */
        .mechanic-details-page {
            display: none;
            padding: 40px 0;
        }

        .mechanic-info {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .mechanic-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 20px;
            border: 5px solid var(--primary-color);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
        }

        .experience-badge {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-weight: 700;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }

        /* Booking Form */
        .booking-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .form-control, .form-select {
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px 30px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        .get-location-btn {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .get-location-btn:hover {
            background: #0284c7;
            transform: translateY(-2px);
        }

        /* Footer Styles */
        .main-footer {
            background: linear-gradient(135deg, var(--dark-color) 0%, #0f172a 100%);
            color: white;
            padding: 60px 0 0;
            margin-top: 60px;
        }

        .footer-section h3 {
            color: white;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }

        .footer-links i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        .contact-info-footer {
            list-style: none;
            padding: 0;
        }

        .contact-info-footer li {
            margin-bottom: 15px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .contact-info-footer i {
            color: var(--accent-color);
            margin-top: 3px;
        }

        .copyright {
            background: rgba(0, 0, 0, 0.3);
            text-align: center;
            padding: 25px 0;
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-link {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.5rem;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .admin-link:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
        }

        .success-message {
            background: #10b981;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .loading {
            text-align: center;
            color: var(--primary-color);
            margin: 20px 0;
        }

        .view-mechanic-btn {
            display: block;
            margin: 30px auto;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-mechanic-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* Mobile Responsive Styles */
        @media (max-width: 992px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .carousel-item {
                height: 400px;
            }
            
            .carousel-caption {
                padding: 20px;
                bottom: 5%;
            }
            
            .carousel-caption h3 {
                font-size: 1.3rem;
                margin-bottom: 10px;
            }
            
            .carousel-caption p {
                font-size: 0.9rem;
            }

            .mechanic-photo {
                width: 150px;
                height: 150px;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .scroll-btn {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .carousel-item {
                height: 300px;
            }
            
            .carousel-caption {
                padding: 15px;
                bottom: 2%;
            }
            
            .carousel-caption h3 {
                font-size: 1.1rem;
                margin-bottom: 5px;
            }
            
            .carousel-caption p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Bootstrap Header/Navigation -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-snowflake"></i>
                    <div class="logo-text">
                        <h1>AC Repair Chennai</h1>
                        <p>24/7 Professional Service</p>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services"><i class="fas fa-wrench"></i> Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#booking"><i class="fas fa-calendar-check"></i> Book Now</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact"><i class="fas fa-phone"></i> Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Full-Screen Bootstrap Slider/Carousel -->
    <div class="hero-slider">
        <div id="acServiceCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#acServiceCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#acServiceCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#acServiceCarousel" data-bs-slide-to="2"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1920&h=600&fit=crop" class="d-block w-100" alt="AC Service">
                    <div class="carousel-caption">
                        <h3><i class="fas fa-snowflake"></i> Professional AC Services</h3>
                        <p>Expert installation, repair, and maintenance for all AC types</p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1920&h=600&fit=crop" class="d-block w-100" alt="AC Repair">
                    <div class="carousel-caption">
                        <h3><i class="fas fa-tools"></i> 24/7 Emergency Service</h3>
                        <p>Quick response for all your AC repair needs</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1920&h=600&fit=crop" class="d-block w-100" alt="AC Maintenance">
                    <div class="carousel-caption">
                        <h3><i class="fas fa-certificate"></i> Certified Technicians</h3>
                        <p>5+ years of experience in AC servicing</p>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#acServiceCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#acServiceCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="header-section">
            <h1><i class="fas fa-snowflake"></i> Professional AC Repair Service</h1>
            <p class="lead">Your trusted air conditioning expert in Chennai</p>
            
            <button class="view-mechanic-btn" id="viewMechanicBtn">
                <i class="fas fa-user-tie"></i> View Mechanic Details
            </button>
        </div>
    </div>

    <!-- Services Section -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="services-header">
                <h2>Our AC Services</h2>
                <p>Professional solutions for all your air conditioning needs</p>
            </div>

            <div class="services-container">
                <div class="services-scroll-wrapper" id="servicesScroll">
                    <div class="services-grid" id="servicesGrid">
                        <!-- Services will be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Detail Page -->
    <section class="service-detail-page" id="serviceDetailPage">
        <div class="container">
            <a href="#" class="back-to-services" id="backToServices">
                <i class="fas fa-arrow-left"></i> Back to Services
            </a>
            
            <div class="service-detail-header">
                <h1 id="serviceDetailTitle">Service Details</h1>
            </div>
            
            <div class="service-detail-content">
                <div class="service-detail-media" id="serviceDetailMedia">
                    <!-- Service media will be dynamically added here -->
                </div>
                
                <div class="service-description" id="serviceDetailDescription">
                    <!-- Service description will be dynamically added here -->
                </div>
                
                <div class="service-features" id="serviceDetailFeatures">
                    <!-- Service features will be dynamically added here -->
                </div>
                
                <div class="service-price-detail text-center">
                    <h3 class="price" id="serviceDetailPrice">Starting from ₹499</h3>
                </div>
            </div>
            
            <!-- Booking Form -->
            <div class="booking-form" id="booking">
                <div class="success-message" id="successMessage" style="display: none;">
                    <i class="fas fa-check-circle"></i> Booking submitted successfully! We'll contact you soon.
                </div>

                <h2 class="form-title">
                    <i class="fas fa-calendar-check"></i> Book Your Appointment Here
                </h2>

                <form id="bookingForm">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Full Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope"></i> Email Address *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-phone"></i> Phone Number *</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-map-marker-alt"></i> Address *</label>
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-location-arrow"></i> Location Details</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="Auto-filled when you get location" readonly>
                        <button type="button" class="get-location-btn" onclick="getLocation()">
                            <i class="fas fa-crosshairs"></i> Get Location
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-wrench"></i> Service Required</label>
                        <select class="form-select" name="service" id="serviceSelect">
                            <option value="">Select Service Type</option>
                            <!-- Service options will be dynamically added -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-calendar"></i> Preferred Date</label>
                        <input type="date" class="form-control" name="preferred_date">
                    </div>

                    <div class="loading" id="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Submitting your booking...
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> Submit Booking Request
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Mechanic Details Page -->
    <section class="mechanic-details-page" id="mechanicDetailsPage">
        <div class="container">
            <a href="#" class="back-to-services" id="backToHome">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
            
            <div class="service-detail-header">
                <h1>Our Expert Mechanic</h1>
            </div>
            
            <div class="mechanic-info">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop" alt="AC Mechanic" class="mechanic-photo">
                
                <div class="experience-badge">
                    <i class="fas fa-star"></i> Best Experience Mechanic in Chennai <i class="fas fa-star"></i>
                </div>

                <div class="text-center mb-4">
                    <h2>Selva James K</h2>
                    <p class="text-muted">
                        <i class="fas fa-medal"></i> 5+ Years Experience | 
                        <i class="fas fa-tools"></i> Certified Technician | 
                        <i class="fas fa-clock"></i> 24/7 Service
                    </p>
                </div>

                <div class="service-features">
                    <h3 class="mb-3"><i class="fas fa-cogs"></i> Our Services</h3>
                    <div class="feature-item">
                        <i class="fas fa-snowflake"></i>
                        <span>AC Installation & Repair</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-fan"></i>
                        <span>Split & Window AC Service</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-tools"></i>
                        <span>Maintenance & Cleaning</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-thermometer-half"></i>
                        <span>Gas Refilling & Leak Detection</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Warranty Service</span>
                    </div>
                </div>

                <div class="mt-4" id="contact">
                    <div class="d-flex align-items-center mb-3 justify-content-center">
                        <i class="fas fa-phone me-3 text-primary fs-5"></i>
                        <span>+91 98765 43210</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-envelope me-3 text-primary fs-5"></i>
                        <span>info@acrepairchennai.com</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-section">
                        <h3>About Us</h3>
                        <p>We provide professional AC repair and maintenance services in Chennai with over 5 years of experience.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-section">
                        <h3>Quick Links</h3>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Home</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Services</a></li>
                            <li><a href="#booking"><i class="fas fa-chevron-right"></i> Book Appointment</a></li>
                            <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-section">
                        <h3>Services</h3>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-chevron-right"></i> AC Installation</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> AC Repair</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Gas Refilling</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Maintenance</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-section">
                        <h3>Contact Us</h3>
                        <ul class="contact-info-footer">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>123 Service Road, Chennai, Tamil Nadu 600001</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>+91 98765 43210</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>info@acrepairchennai.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p class="mb-0">&copy; 2023 AC Repair Chennai. All Rights Reserved. | Designed with <i class="fas fa-heart text-danger"></i></p>
        </div>
    </footer>

    <!-- Admin WhatsApp Link -->
    <a href="https://wa.me/918428399365" class="admin-link" title="Chat on WhatsApp" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Services Data
        const services = [
            {
                id: 1,
                title: "AC Installation",
                description: "Professional installation of all types of air conditioners including split AC, window AC, and central AC systems.",
                media: {
                    type: "video",
                    src: "https://assets.mixkit.co/videos/preview/mixkit-close-up-of-a-technician-working-on-an-air-conditioner-43951-large.mp4",
                    poster: "https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=600&h=400&fit=crop"
                },
                price: "Starting from ₹1,999",
                features: [
                    "Professional installation by certified technicians",
                    "Proper placement for optimal cooling",
                    "Electrical connection and testing",
                    "Demonstration of AC functions",
                    "Warranty on installation work"
                ],
                longDescription: "Our professional AC installation service ensures your new air conditioner is set up correctly for optimal performance and longevity. We handle all types of AC units including split, window, and central systems. Our certified technicians will assess your space, recommend the best placement, and install your unit with precision, ensuring proper electrical connections and testing all functions before completion."
            },
            {
                id: 2,
                title: "AC Repair",
                description: "Expert repair services for all AC problems including cooling issues, strange noises, and electrical problems.",
                media: {
                    type: "image",
                    src: "https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&h=400&fit=crop"
                },
                price: "Starting from ₹499",
                features: [
                    "Diagnosis of AC problems",
                    "Repair of cooling issues",
                    "Noise troubleshooting",
                    "Electrical component repair",
                    "Same-day service available"
                ],
                longDescription: "When your AC isn't working properly, our expert repair service can diagnose and fix the issue quickly. We handle all types of AC problems including poor cooling, strange noises, water leakage, electrical issues, and more. Our technicians use advanced diagnostic tools to identify problems accurately and provide effective solutions to get your AC running smoothly again."
            },
            {
                id: 3,
                title: "AC Service & Cleaning",
                description: "Comprehensive AC servicing including cleaning, filter replacement, and performance optimization.",
                media: {
                    type: "video",
                    src: "https://www.youtube.com/embed/Zllqm2zHmpA?si=x3L0KETweLIKRtT9",
                    poster: "https://images.unsplash.com/photo-1635274531661-1c6b827e9e92?w=600&h=400&fit=crop"
                },
                price: "Starting from ₹699",
                features: [
                    "Thorough cleaning of AC unit",
                    "Filter replacement",
                    "Cooling coil cleaning",
                    "Drainage system check",
                    "Performance optimization"
                ],
                longDescription: "Regular AC servicing is essential for maintaining optimal performance and extending the lifespan of your unit. Our comprehensive service includes thorough cleaning of all components, filter replacement, cooling coil cleaning, drainage system check, and performance optimization. Regular servicing not only improves cooling efficiency but also reduces electricity consumption and prevents costly repairs."
            },
          
        ];

        // Initialize Services
        function initializeServices() {
            const servicesGrid = document.getElementById('servicesGrid');
            const serviceSelect = document.getElementById('serviceSelect');
            
            // Clear existing content
            servicesGrid.innerHTML = '';
            serviceSelect.innerHTML = '<option value="">Select Service Type</option>';
            
            // Add services to grid
            services.forEach(service => {
                // Create service card
                const serviceCard = document.createElement('div');
                serviceCard.className = 'service-card';
                
                let mediaHTML = '';
                if (service.media.type === 'video') {
                    mediaHTML = `
                        <div class="service-media-container">
                            <video class="service-video" poster="${service.media.poster}" muted>
                                <source src="${service.media.src}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button class="video-play-btn" data-service-id="${service.id}">
                                <i class="fas fa-play"></i>
                            </button>
                            <div class="media-indicator">
                                <i class="fas fa-video"></i> Video
                            </div>
                        </div>
                    `;
                } else {
                    mediaHTML = `
                        <div class="service-media-container">
                            <img src="${service.media.src}" alt="${service.title}" class="service-image">
                            <div class="media-indicator">
                                <i class="fas fa-image"></i> Image
                            </div>
                        </div>
                    `;
                }
                
                serviceCard.innerHTML = `
                    ${mediaHTML}
                    <div class="service-content">
                        <h3>${service.title}</h3>
                        <p>${service.description}</p>
                        <div class="service-price">
                            <span class="price">${service.price}</span>
                            <button class="view-details-btn" data-service-id="${service.id}">View Details</button>
                        </div>
                    </div>
                `;
                servicesGrid.appendChild(serviceCard);
                
                // Add service to select dropdown
                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = service.title;
                serviceSelect.appendChild(option);
            });
            
            // Add event listeners to view details buttons
            document.querySelectorAll('.view-details-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const serviceId = parseInt(this.getAttribute('data-service-id'));
                    showServiceDetails(serviceId);
                });
            });
            
            // Add event listeners to video play buttons
            document.querySelectorAll('.video-play-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const serviceId = parseInt(this.getAttribute('data-service-id'));
                    const serviceCard = this.closest('.service-card');
                    const video = serviceCard.querySelector('video');
                    
                    if (video.paused) {
                        video.play();
                        this.innerHTML = '<i class="fas fa-pause"></i>';
                    } else {
                        video.pause();
                        this.innerHTML = '<i class="fas fa-play"></i>';
                    }
                });
            });
            
            // Pause videos when they end
            document.querySelectorAll('.service-video').forEach(video => {
                video.addEventListener('ended', function() {
                    const playBtn = this.closest('.service-media-container').querySelector('.video-play-btn');
                    playBtn.innerHTML = '<i class="fas fa-play"></i>';
                });
            });
        }

        // Show Service Details
        function showServiceDetails(serviceId) {
            const service = services.find(s => s.id === serviceId);
            if (!service) return;
            
            // Update service detail page
            document.getElementById('serviceDetailTitle').textContent = service.title;
            document.getElementById('serviceDetailPrice').textContent = service.price;
            
            // Update service media
            const mediaElement = document.getElementById('serviceDetailMedia');
            if (service.media.type === 'video') {
                mediaElement.innerHTML = `
                    <video class="service-detail-video" controls poster="${service.media.poster}">
                        <source src="${service.media.src}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                `;
            } else {
                mediaElement.innerHTML = `
                    <img src="${service.media.src}" alt="${service.title}" class="service-detail-image">
                `;
            }
            
            // Update service description
            const descriptionElement = document.getElementById('serviceDetailDescription');
            descriptionElement.innerHTML = `
                <h3>About This Service</h3>
                <p>${service.longDescription}</p>
            `;
            
            // Update service features
            const featuresElement = document.getElementById('serviceDetailFeatures');
            featuresElement.innerHTML = `
                <h3>Service Includes</h3>
                ${service.features.map(feature => `
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>${feature}</span>
                    </div>
                `).join('')}
            `;
            
            // Set the selected service in the form
            document.getElementById('serviceSelect').value = serviceId;
            
            // Show service detail page and hide services section
            document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
            document.querySelector('.services-section').style.display = 'none';
            document.getElementById('serviceDetailPage').style.display = 'block';
        }

        // Back to Services
        document.getElementById('backToServices').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('serviceDetailPage').style.display = 'none';
            document.querySelector('.services-section').style.display = 'block';
            document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
        });

        // Back to Home
        document.getElementById('backToHome').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('mechanicDetailsPage').style.display = 'none';
            document.querySelector('.services-section').style.display = 'block';
            document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
        });

        // View Mechanic Details
        document.getElementById('viewMechanicBtn').addEventListener('click', function() {
            document.querySelector('.services-section').style.display = 'none';
            document.getElementById('mechanicDetailsPage').style.display = 'block';
            document.getElementById('mechanicDetailsPage').scrollIntoView({ behavior: 'smooth' });
        });

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="preferred_date"]').setAttribute('min', today);

        // Get Location Function
        function getLocation() {
            const locationInput = document.getElementById('location');
            
            if (navigator.geolocation) {
                locationInput.value = 'Getting location...';
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        locationInput.value = `Lat: ${lat.toFixed(6)}, Long: ${lon.toFixed(6)}`;
                    },
                    (error) => {
                        locationInput.value = '';
                        alert('Unable to get location. Please enter manually.');
                    }
                );
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        }

        // Form Submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const loading = document.getElementById('loading');
            const successMessage = document.getElementById('successMessage');
            
            loading.style.display = 'block';
            
            setTimeout(() => {
                loading.style.display = 'none';
                successMessage.style.display = 'block';
                this.reset();
                
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            }, 1500);
        });

        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            initializeServices();
        });
    </script>
</body>
</html>