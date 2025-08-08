{{-- resources/views/admin/cancelled-orders.blade.php --}}
@extends('layouts.admin')

@section('title', 'Cancelled Orders')

@section('content')
<div class="header">
    <h1><i class="fas fa-times-circle"></i> Cancelled Orders</h1>
    <p>Orders that were cancelled or rejected</p>
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-ban"></i> Cancelled Bookings ({{ $bookings->total() }})</h3>
    </div>
    <div class="card-body">
        @if($bookings->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cancelled Date</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->updated_at->format('M d, Y') }}</td>
                            <td>
                                <strong>{{ $booking->name }}</strong><br>
                                <small style="color: #666;">{{ $booking->email }}</small>
                            </td>
                            <td>
                                <strong>{{ $booking->phone }}</strong>
                            </td>
                            <td>
                                <span style="background: #ffeaea; color: #c62828; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">
                                    {{ $booking->service ? ucfirst(str_replace('-', ' ', $booking->service)) : 'AC Service' }}
                                </span>
                            </td>
                            <td>
                                @if($booking->location)
                                    <a href="javascript:void(0)" 
                                       onclick="openLocation('{{ addslashes($booking->location) }}')" 
                                       class="location-link" 
                                       title="Click to open in Google Maps">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ Str::limit($booking->location, 25) }}
                                    </a>
                                @else
                                    <span style="color: #999; font-style: italic;">
                                        <i class="fas fa-map-marker"></i> Not provided
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($booking->preferred_date)
                                    <span style="color: #666; font-weight: 500;">
                                        <i class="fas fa-calendar"></i>
                                        {{ $booking->preferred_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span style="color: #666;">
                                        <i class="fas fa-calendar"></i>
                                        {{ $booking->created_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $booking->status }}">
                                    <i class="fas fa-times-circle"></i> {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                    <button class="btn btn-info" onclick="viewOrderDetails({{ $booking->id }})" title="View Details">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    
                                    <button class="btn btn-secondary" onclick="viewCancellationReason({{ $booking->id }})" title="View Reason">
                                        <i class="fas fa-question-circle"></i> Reason
                                    </button>
                                    
                                    <form method="POST" action="{{ route('admin.booking.status', $booking->id) }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="pending">
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Restore this order to pending status?')" title="Restore to Pending">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr style="background: #fef7f7;">
                            <td colspan="8" style="font-size: 0.9rem; padding: 15px;">
                                <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
                                    <div>
                                        <strong style="color: #333;">
                                            <i class="fas fa-home" style="color: #dc3545;"></i> Address:
                                        </strong>
                                        <span style="margin-left: 10px;">{{ $booking->address }}</span>
                                        
                                        @if($booking->location)
                                            <br><br>
                                            <strong style="color: #333;">
                                                <i class="fas fa-location-arrow" style="color: #dc3545;"></i> GPS Location:
                                            </strong>
                                            <span style="margin-left: 10px;">{{ $booking->location }}</span>
                                        @endif
                                        
                                        @if($booking->notes)
                                            <br><br>
                                            <strong style="color: #333;">
                                                <i class="fas fa-sticky-note" style="color: #dc3545;"></i> Service Notes:
                                            </strong>
                                            <span style="margin-left: 10px;">{{ $booking->notes }}</span>
                                        @endif

                                        @if($booking->cancellation_reason)
                                            <br><br>
                                            <strong style="color: #333;">
                                                <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> Cancellation Reason:
                                            </strong>
                                            <span style="margin-left: 10px; color: #dc3545; font-weight: 500;">{{ $booking->cancellation_reason }}</span>
                                        @endif
                                    </div>
                                    
                                    <div style="text-align: right; color: #666; font-size: 0.8rem;">
                                        <div>
                                            <i class="fas fa-clock"></i> 
                                            Booked: {{ $booking->created_at->format('M d, Y \a\t H:i A') }}
                                        </div>
                                        <div style="margin-top: 5px;">
                                            <i class="fas fa-times-circle" style="color: #dc3545;"></i> 
                                            Cancelled: {{ $booking->updated_at->format('M d, Y \a\t H:i A') }}
                                        </div>
                                        <div style="margin-top: 5px; font-weight: 600; color: #dc3545;">
                                            <i class="fas fa-clock"></i>
                                            Duration: {{ $booking->created_at->diffForHumans($booking->updated_at, true) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 20px;">
                {{ $bookings->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-smile" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
                <h3>No Cancelled Orders</h3>
                <p>Great! No cancelled orders found.</p>
                <div style="margin-top: 20px;">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Quick Stats Card -->
@if($bookings->count() > 0)
<div class="content-card" style="margin-top: 30px;">
    <div class="card-header">
        <h3><i class="fas fa-chart-bar"></i> Cancellation Statistics</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #dc3545; margin-bottom: 10px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">{{ $bookings->total() }}</div>
                <div style="color: #666; font-size: 0.9rem;">Total Cancelled</div>
            </div>
            
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #fd7e14; margin-bottom: 10px;">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">
                    {{ $bookings->filter(fn($booking) => $booking->updated_at->isToday())->count() }}
                </div>
                <div style="color: #666; font-size: 0.9rem;">Cancelled Today</div>
            </div>
            
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #6c757d; margin-bottom: 10px;">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">
                    {{ $bookings->filter(fn($booking) => $booking->updated_at->isCurrentWeek())->count() }}
                </div>
                <div style="color: #666; font-size: 0.9rem;">This Week</div>
            </div>
            
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #6f42c1; margin-bottom: 10px;">
                    <i class="fas fa-percentage"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">
                    {{ number_format($bookings->avg(fn($booking) => $booking->created_at->diffInHours($booking->updated_at)), 1) }}h
                </div>
                <div style="color: #666; font-size: 0.9rem;">Avg. Time to Cancel</div>
            </div>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <button class="btn btn-danger" onclick="exportCancelled()" style="margin-right: 10px;">
                <i class="fas fa-download"></i> Export Report
            </button>
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt"></i> Refresh Page
            </button>
            <button class="btn btn-warning" onclick="analyzeCancellations()">
                <i class="fas fa-chart-line"></i> Analyze Trends
            </button>
        </div>
    </div>
</div>
@endif

<!-- Order Details Modal -->
<div id="orderModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 15px; width: 90%; max-width: 600px; max-height: 90%; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #eee;">
            <h3 style="margin: 0; color: #333;">
                <i class="fas fa-file-alt"></i> Order Details
            </h3>
            <button onclick="closeModal()" style="position: absolute; right: 15px; top: 15px; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <div id="modalContent" style="padding: 20px;">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Cancellation Reason Modal -->
<div id="reasonModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 15px; width: 90%; max-width: 500px; max-height: 90%; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #eee;">
            <h3 style="margin: 0; color: #333;">
                <i class="fas fa-question-circle"></i> Cancellation Reason
            </h3>
            <button onclick="closeReasonModal()" style="position: absolute; right: 15px; top: 15px; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <div id="reasonModalContent" style="padding: 20px;">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script>
// Function to view order details
function viewOrderDetails(bookingId) {
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div style="text-align: center; padding: 20px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #dc3545;"></i>
            <p>Loading order details...</p>
        </div>
    `;
    document.getElementById('orderModal').style.display = 'block';
    
    // Simulate loading (replace with actual AJAX call)
    setTimeout(() => {
        modalContent.innerHTML = `
            <div style="display: grid; gap: 15px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <h4 style="color: #333; margin-bottom: 10px;">Customer Information</h4>
                        <p><strong>Order ID:</strong> #${bookingId}</p>
                        <p><strong>Status:</strong> <span style="color: #dc3545;">Cancelled</span></p>
                        <p><strong>Service:</strong> AC Maintenance</p>
                    </div>
                    <div>
                        <h4 style="color: #333; margin-bottom: 10px;">Timeline</h4>
                        <p><strong>Booked:</strong> Jan 15, 2024</p>
                        <p><strong>Cancelled:</strong> Jan 16, 2024</p>
                        <p><strong>Duration:</strong> 1 day</p>
                    </div>
                </div>
                <div>
                    <h4 style="color: #333; margin-bottom: 10px;">Cancellation Details</h4>
                    <p style="color: #dc3545; background: #ffeaea; padding: 10px; border-radius: 8px;">
                        <i class="fas fa-exclamation-triangle"></i>
                        This order was cancelled due to customer request.
                    </p>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn btn-success" onclick="restoreOrder(${bookingId})">
                        <i class="fas fa-undo"></i> Restore Order
                    </button>
                    <button class="btn btn-secondary" onclick="closeModal()" style="margin-left: 10px;">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        `;
    }, 1000);
}

// Function to view cancellation reason
function viewCancellationReason(bookingId) {
    const reasonModalContent = document.getElementById('reasonModalContent');
    reasonModalContent.innerHTML = `
        <div style="text-align: center; padding: 20px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #dc3545;"></i>
            <p>Loading cancellation reason...</p>
        </div>
    `;
    document.getElementById('reasonModal').style.display = 'block';
    
    // Simulate loading (replace with actual AJAX call)
    setTimeout(() => {
        reasonModalContent.innerHTML = `
            <div style="display: grid; gap: 15px;">
                <div style="background: #ffeaea; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545;">
                    <h4 style="color: #dc3545; margin-bottom: 10px;">
                        <i class="fas fa-exclamation-triangle"></i> Cancellation Reason
                    </h4>
                    <p style="margin-bottom: 10px; color: #333;">
                        Customer requested cancellation due to change in schedule.
                    </p>
                    <small style="color: #666;">
                        <i class="fas fa-clock"></i> Cancelled on: Jan 16, 2024 at 2:30 PM
                    </small>
                </div>
                <div style="text-align: center; margin-top: 15px;">
                    <button class="btn btn-secondary" onclick="closeReasonModal()">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        `;
    }, 1000);
}

// Function to close modals
function closeModal() {
    document.getElementById('orderModal').style.display = 'none';
}

function closeReasonModal() {
    document.getElementById('reasonModal').style.display = 'none';
}

// Function to restore order
function restoreOrder(bookingId) {
    if (confirm(`Restore order #${bookingId} to pending status?`)) {
        // In a real application, this would submit a form or make an AJAX call
        alert(`Order #${bookingId} restored to pending status.`);
        closeModal();
        window.location.reload();
    }
}

// Function to export cancelled orders
function exportCancelled() {
    alert('Exporting cancelled orders report...');
    // In a real application, this would generate a CSV/PDF export
}

// Function to analyze cancellations
function analyzeCancellations() {
    alert('Opening cancellation trend analysis...');
    // In a real application, this would open analytics dashboard
}

// Function to refresh page
function refreshPage() {
    window.location.reload();
}

// Function to open location in Google Maps
function openLocation(location) {
    const encodedLocation = encodeURIComponent(location);
    window.open(`https://www.google.com/maps/search/?api=1&query=${encodedLocation}`, '_blank');
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(event) {
    // Ctrl + R for refresh
    if (event.ctrlKey && event.key === 'r') {
        event.preventDefault();
        refreshPage();
    }
    
    // Escape to close modals
    if (event.key === 'Escape') {
        closeModal();
        closeReasonModal();
    }
});

// Add loading state to buttons when clicked
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.type === 'submit') {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                this.disabled = true;
                
                // Re-enable after 3 seconds (in case of error)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 3000);
            }
        });
    });
});

// Highlight rows on hover for better visibility
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#fff5f5';
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'scale(1)';
        });
    });
});

// Close modals when clicking outside
document.getElementById('orderModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeModal();
    }
});

document.getElementById('reasonModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeReasonModal();
    }
});
</script>

<style>
.location-link {
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
}

.location-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #fff5f5;
}
</style>
@endsection