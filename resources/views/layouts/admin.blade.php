<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - AC Repair Service</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-link {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            padding-left: 30px;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            font-size: 1.8rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .content-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin: 2px;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        /* Location Link Styling */
        .location-link {
            color: #667eea;
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .location-link:hover {
            color: #5a6fd8;
            text-decoration: underline;
        }

        .location-link i {
            margin-right: 5px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            animation: modalFadeIn 0.3s ease-out;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 2% auto;
            padding: 0;
            border: none;
            border-radius: 15px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: modalSlideIn 0.3s ease-out;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 25px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }

        .close {
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.1);
        }

        .modal-body {
            padding: 25px;
        }

        .order-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .detail-section h4 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }

        .detail-section h4 i {
            margin-right: 10px;
            color: #667eea;
        }

        .detail-item {
            margin-bottom: 10px;
            display: flex;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
            min-width: 120px;
        }

        .detail-value {
            color: #333;
            flex: 1;
        }

        /* Action buttons in modal */
        .modal-actions {
            padding: 20px 25px;
            background: #f8f9fa;
            border-radius: 0 0 15px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideIn {
            from { 
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to { 
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .order-detail-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
                margin: 5% auto;
            }

            .table {
                font-size: 0.9rem;
            }
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-snowflake"></i> AC Repair Admin</h3>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.pending') }}" class="nav-link {{ request()->routeIs('admin.pending') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Pending Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.completed') }}" class="nav-link {{ request()->routeIs('admin.completed') ? 'active' : '' }}">
                    <i class="fas fa-check-circle"></i> Completed Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.cancelled') }}" class="nav-link {{ request()->routeIs('admin.cancelled') ? 'active' : '' }}">
                    <i class="fas fa-times-circle"></i> Cancelled Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Order Details Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-file-alt"></i> Order Details</h3>
                <button class="close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="loading-spinner" style="margin: 20px auto; display: block;"></div>
                <p style="text-align: center; margin-top: 10px;">Loading order details...</p>
            </div>
        </div>
    </div>

    <script>
        // Function to open location in Google Maps
        function openLocation(location) {
            if (!location || location.trim() === '') {
                alert('Location information not available');
                return;
            }
            
            // Extract coordinates if available (format: "Address (lat, lng)")
            const coordMatch = location.match(/\(([^,]+),\s*([^)]+)\)/);
            let mapsUrl;
            
            if (coordMatch && coordMatch.length >= 3) {
                // Use coordinates for more accurate location
                const lat = coordMatch[1].trim();
                const lng = coordMatch[2].trim();
                mapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;
            } else {
                // Use address search
                const encodedLocation = encodeURIComponent(location);
                mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodedLocation}`;
            }
            
            // Open in new tab
            window.open(mapsUrl, '_blank');
        }

        // Function to view order details
        function viewOrderDetails(bookingId) {
            const modal = document.getElementById('orderModal');
            const modalBody = document.getElementById('modalBody');
            
            // Show modal with loading state
            modal.style.display = 'block';
            modalBody.innerHTML = `
                <div class="loading-spinner" style="margin: 20px auto; display: block;"></div>
                <p style="text-align: center; margin-top: 10px;">Loading order details...</p>
            `;
            
            // Fetch order details
            fetch(`/admin/booking/${bookingId}/details`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayOrderDetails(data.booking);
                } else {
                    modalBody.innerHTML = `
                        <div style="text-align: center; padding: 20px; color: #dc3545;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 15px;"></i>
                            <h4>Error Loading Details</h4>
                            <p>Unable to load order details. Please try again.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                modalBody.innerHTML = `
                    <div style="text-align: center; padding: 20px; color: #dc3545;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <h4>Connection Error</h4>
                        <p>Failed to fetch order details. Please check your connection and try again.</p>
                    </div>
                `;
            });
        }

        // Function to display order details in modal
        function displayOrderDetails(booking) {
            const modalBody = document.getElementById('modalBody');
            const statusClass = `status-${booking.status}`;
            const statusIcon = getStatusIcon(booking.status);
            
            modalBody.innerHTML = `
                <div class="order-detail-grid">
                    <div class="detail-section">
                        <h4><i class="fas fa-user"></i> Customer Information</h4>
                        <div class="detail-item">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value"><strong>${booking.name}</strong></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">${booking.email}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Phone:</span>
                            <span class="detail-value">${booking.phone}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="status-badge ${statusClass}">
                                    ${statusIcon} ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}
                                </span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h4><i class="fas fa-calendar-alt"></i> Booking Information</h4>
                        <div class="detail-item">
                            <span class="detail-label">Booking ID:</span>
                            <span class="detail-value"><strong>#${booking.id}</strong></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Service:</span>
                            <span class="detail-value">${booking.service ? booking.service.replace('-', ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : 'Not specified'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Preferred Date:</span>
                            <span class="detail-value">${booking.preferred_date || 'Not specified'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Booking Date:</span>
                            <span class="detail-value">${formatDate(booking.created_at)}</span>
                        </div>
                    </div>
                </div>
                
                <div class="detail-section" style="grid-column: 1 / -1;">
                    <h4><i class="fas fa-map-marker-alt"></i> Address & Location</h4>
                    <div class="detail-item">
                        <span class="detail-label">Address:</span>
                        <span class="detail-value">${booking.address}</span>
                    </div>
                    ${booking.location ? `
                        <div class="detail-item">
                            <span class="detail-label">Location:</span>
                            <span class="detail-value">
                                <a href="javascript:void(0)" onclick="openLocation('${booking.location}')" class="location-link">
                                    <i class="fas fa-external-link-alt"></i> ${booking.location}
                                </a>
                            </span>
                        </div>
                    ` : ''}
                </div>
            `;
            
            // Add action buttons
            const modalContent = document.querySelector('.modal-content');
            const existingActions = modalContent.querySelector('.modal-actions');
            if (existingActions) existingActions.remove();
            
            const actionsHtml = `
                <div class="modal-actions">
                    <div>
                        <span style="color: #666; font-size: 0.9rem;">
                            <i class="fas fa-info-circle"></i> Last updated: ${formatDate(booking.updated_at)}
                        </span>
                    </div>
                    <div>
                        ${booking.location ? `
                            <button class="btn btn-info" onclick="openLocation('${booking.location}')">
                                <i class="fas fa-map-marker-alt"></i> View on Map
                            </button>
                        ` : ''}
                        ${booking.status === 'pending' ? `
                            <button class="btn btn-success" onclick="approveBooking(${booking.id})">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button class="btn btn-danger" onclick="cancelBooking(${booking.id})">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        ` : ''}
                        ${booking.status === 'approved' ? `
                            <button class="btn btn-success" onclick="completeBooking(${booking.id})">
                                <i class="fas fa-check-circle"></i> Mark Complete
                            </button>
                        ` : ''}
                        <button class="btn btn-primary" onclick="closeModal()">
                            <i class="fas fa-times"></i> Close
                        </button>
                    </div>
                </div>
            `;
            
            modalContent.insertAdjacentHTML('beforeend', actionsHtml);
        }

        // Helper function to get status icon
        function getStatusIcon(status) {
            const icons = {
                'pending': '<i class="fas fa-clock"></i>',
                'approved': '<i class="fas fa-check"></i>',
                'completed': '<i class="fas fa-check-circle"></i>',
                'cancelled': '<i class="fas fa-times"></i>'
            };
            return icons[status] || '<i class="fas fa-question"></i>';
        }

        // Helper function to format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Function to close modal
        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        // Function to approve booking from modal
        function approveBooking(bookingId) {
            if (confirm('Are you sure you want to approve this booking?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/bookings/${bookingId}/approve`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Function to cancel booking from modal
        function cancelBooking(bookingId) {
            if (confirm('Are you sure you want to cancel this booking?')) {
                updateBookingStatus(bookingId, 'cancelled');
            }
        }

        // Function to complete booking from modal
        function completeBooking(bookingId) {
            if (confirm('Mark this booking as completed?')) {
                updateBookingStatus(bookingId, 'completed');
            }
        }

        // Function to update booking status
        function updateBookingStatus(bookingId, status) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/bookings/${bookingId}/status`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = status;
            
            form.appendChild(csrfToken);
            form.appendChild(statusInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
