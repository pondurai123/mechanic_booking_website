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
                                    
                                    <form method="POST" action="{{ route('admin.booking.approve', $booking->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Approve this booking?')" title="Approve Booking">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    
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

<!-- Quick Stats Card -->
@if($bookings->count() > 0)
<div class="content-card" style="margin-top: 30px;">
    <div class="card-header">
        <h3><i class="fas fa-chart-bar"></i> Quick Actions</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #ffc107; margin-bottom: 10px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">{{ $bookings->total() }}</div>
                <div style="color: #666; font-size: 0.9rem;">Total Pending</div>
            </div>
            
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #17a2b8; margin-bottom: 10px;">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">
                    {{ $bookings->whereNotNull('location')->count() }}
                </div>
                <div style="color: #666; font-size: 0.9rem;">With GPS Location</div>
            </div>
            
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #28a745; margin-bottom: 10px;">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">
                 {{ $bookings->filter(fn($booking) => $booking->created_at->isToday())->count() }}
                </div>
                <div style="color: #666; font-size: 0.9rem;">Today's Bookings</div>
            </div>
            
            <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <div style="font-size: 2rem; color: #667eea; margin-bottom: 10px;">
                    <i class="fas fa-tools"></i>
                </div>
                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">
                    {{ $bookings->whereNotNull('service')->count() }}
                </div>
                <div style="color: #666; font-size: 0.9rem;">Service Specified</div>
            </div>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <button class="btn btn-success" onclick="approveAllVisible()" style="margin-right: 10px;">
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
// Function to approve all visible bookings
function approveAllVisible() {
    if (confirm('Are you sure you want to approve all visible pending orders? This action cannot be undone.')) {
        const forms = document.querySelectorAll('form[action*="/approve"]');
        let count = 0;
        
        forms.forEach(form => {
            setTimeout(() => {
                form.submit();
            }, count * 500); // Stagger submissions by 500ms
            count++;
        });
    }
}

// Function to refresh page
function refreshPage() {
    window.location.reload();
}

// Auto-refresh functionality
let autoRefreshInterval;
let autoRefreshEnabled = false;

function toggleAutoRefresh() {
    if (autoRefreshEnabled) {
        clearInterval(autoRefreshInterval);
        autoRefreshEnabled = false;
        document.getElementById('autoRefreshBtn').innerHTML = '<i class="fas fa-play"></i> Enable Auto-Refresh';
    } else {
        autoRefreshInterval = setInterval(() => {
            window.location.reload();
        }, 30000); // Refresh every 30 seconds
        autoRefreshEnabled = true;
        document.getElementById('autoRefreshBtn').innerHTML = '<i class="fas fa-pause"></i> Disable Auto-Refresh';
    }
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(event) {
    // Ctrl + R for refresh
    if (event.ctrlKey && event.key === 'r') {
        event.preventDefault();
        refreshPage();
    }
    
    // Ctrl + A for approve all (with additional confirmation)
    if (event.ctrlKey && event.key === 'a' && event.shiftKey) {
        event.preventDefault();
        approveAllVisible();
    }
});

// Add tooltips for better UX
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to buttons when clicked
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
            this.style.backgroundColor = '#f0f8ff';
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection
