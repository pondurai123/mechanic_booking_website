@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="header">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    <p>Welcome to AC Repair Service Admin Panel</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="color: #667eea;">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-number" style="color: #667eea;">{{ $todayOrders }}</div>
        <div class="stat-label">Orders Today</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="color: #764ba2;">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="stat-number" style="color: #764ba2;">{{ $monthOrders }}</div>
        <div class="stat-label">Orders This Month</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="color: #ffc107;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-number" style="color: #ffc107;">{{ $pendingOrders }}</div>
        <div class="stat-label">Pending Orders</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="color: #28a745;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-number" style="color: #28a745;">{{ $completedOrders }}</div>
        <div class="stat-label">Completed Orders</div>
    </div>
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-chart-line"></i> Quick Overview</h3>
    </div>
    <div class="card-body">
        <p>Your AC repair service is running smoothly! Here's what's happening:</p>
        <ul style="margin: 20px 0; padding-left: 20px;">
            <li>You have <strong>{{ $pendingOrders }}</strong> orders waiting for approval</li>
            <li><strong>{{ $completedOrders }}</strong> orders have been successfully completed</li>
            <li>Total of <strong>{{ $todayOrders }}</strong> new orders received today</li>
        </ul>
        <div style="margin-top: 20px;">
            <a href="{{ route('admin.pending') }}" class="btn btn-primary">
                <i class="fas fa-eye"></i> View Pending Orders
            </a>
        </div>
    </div>
</div>
@endsection