@extends('layouts.admin')

@section('title', 'Pending Orders')

@section('content')
<div class="header">
    <h1><i class="fas fa-clock"></i> Pending Orders</h1>
    <p>Orders waiting for your approval</p>
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Pending Bookings ({{ $bookings->total() }})</h3>
    </div>
    <div class="card-body">
        @if($bookings->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Preferred Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                            <td>
                                <strong>{{ $booking->name }}</strong><br>
                                <small style="color: #666;">{{ $booking->email }}</small>
                            </td>
                            <td>
                                <strong>{{ $booking->phone }}</strong>
                            </td>
                            <td>
                                <span style="background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">
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
                                    <span style="color: #28a745; font-weight: 600;">
                                        <i class="fas fa-calendar-check"></i>
                                        {{ $booking->preferred_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span style="color: #999; font-style: italic;">
                                        <i class="fas fa-calendar"></i> Flexible
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $booking->status }}">
                                    <i class="fas fa-clock"></i> {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                    <button class="btn btn-info" onclick="viewOrderDetails({{ $booking->id }})" title="View Details">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    
                                    <button class="btn btn-success" onclick="showApproveModal({{ $booking->id }})" title="Approve Booking">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    
                                    <form method="POST" action="{{ route('admin.booking.status', $booking->id) }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this booking?')" title="Cancel Booking">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr style="background: #f8f9fa;">
                            <td colspan="8" style="font-size: 0.9rem; padding: 15px;">
                                <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
                                    <div>
                                        <strong style="color: #333;">
                                            <i class="fas fa-home" style="color: #667eea;"></i> Address:
                                        </strong>
                                        <span style="margin-left: 10px;">{{ $booking->address }}</span>
                                        
                                        @if($booking->location)
                                            <br><br>
                                            <strong style="color: #333;">
                                                <i class="fas fa-location-arrow" style="color: #667eea;"></i> GPS Location:
                                            </strong>
                                            <span style="margin-left: 10px;">{{ $booking->location }}</span>
                                        @endif
                                    </div>
                                    
                                    <div style="text-align: right; color: #666; font-size: 0.8rem;">
                                        <div>
                                            <i class="fas fa-clock"></i> 
                                            Booked: {{ $booking->created_at->format('M d, Y \a\t H:i A') }}
                                        </div>
                                        @if($booking->created_at != $booking->updated_at)
                                            <div style="margin-top: 5px;">
                                                <i class="fas fa-edit"></i> 
                                                Updated: {{ $booking->updated_at->format('M d, Y \a\t H:i A') }}
                                            </div>
                                        @endif
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
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
                <h3>No Pending Orders</h3>
                <p>All caught up! No pending orders at the moment.</p>
                <div style="margin-top: 20px;">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@if($bookings->count() > 0)
<!-- Approve Booking Modal -->
<div id="approveModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-check-circle"></i> Approve Booking</h3>
            <span class="close" onclick="closeApproveModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="approveForm" method="POST" action="">
                @csrf
                <input type="hidden" name="status" value="approved">
                <div class="form-group">
                    <label for="mechanic_id">Assign Mechanic</label>
                    <select name="mechanic_id" id="mechanic_id" class="form-control" required>
                        <option value="">Select Mechanic</option>
                        @foreach(App\Models\Mechanic::active()->get() as $mechanic)
                            <option value="{{ $mechanic->id }}">{{ $mechanic->name }} ({{ $mechanic->phone }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Stats Card -->
<div class="content-card" style="margin-top: 30px;">
    <div class="card-header">
        <h3><i class="fas fa-chart-bar"></i> Quick Actions</h3>
    </div>
    <div class="card-body">
        <div class="stats-grid">
            <!-- Your existing stats cards here -->
        </div>
        <div class="action-buttons">
            <button class="btn btn-success" onclick="approveAllVisible()">
                <i class="fas fa-check-double"></i> Approve All Visible
            </button>
            <button class="btn btn-primary" onclick="refreshPage()">
                <i class="fas fa-sync-alt"></i> Refresh Page
            </button>
        </div>
    </div>
</div>
@endif

<script>
// Modal Functions
let currentBookingId = null;

function showApproveModal(bookingId) {
    currentBookingId = bookingId;
    const form = document.getElementById('approveForm');
    form.action = `/admin/bookings/${bookingId}/approve`;
    
    // Reset form and modal state
    form.reset();
    document.getElementById('mechanic_id').selectedIndex = 0;
    
    document.getElementById('approveModal').style.display = 'block';
}

function closeApproveModal() {
    document.getElementById('approveModal').style.display = 'none';
    currentBookingId = null;
}

// Form Submission Handler
document.getElementById('approveForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    submitBtn.disabled = true;
    
    // Optional: You can add AJAX submission here if you want to handle the response differently
});

// Other existing functions
function approveAllVisible() {
    if (confirm('Are you sure you want to approve all visible pending orders?')) {
        const approveButtons = document.querySelectorAll('.btn-success[onclick^="showApproveModal"]');
        approveButtons.forEach(btn => {
            const bookingId = btn.getAttribute('onclick').match(/\d+/)[0];
            showApproveModal(bookingId);
        });
    }
}

function refreshPage() {
    window.location.reload();
}

function openLocation(location) {
    const encodedLocation = encodeURIComponent(location);
    window.open(`https://www.google.com/maps/search/?api=1&query=${encodedLocation}`, '_blank');
}
</script>

<style>
/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #333;
}

.close {
    font-size: 24px;
    cursor: pointer;
}

.modal-body {
    padding: 20px;
}

.form-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

/* Existing table styles remain the same */
</style>
@endsection