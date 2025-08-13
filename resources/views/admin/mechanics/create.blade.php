@extends('layouts.admin')

@section('title', 'Add New Mechanic')

@section('content')
<div class="header">
    <h1><i class="fas fa-user-plus"></i> Add New Mechanic</h1>
    <a href="{{ route('admin.mechanics.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Mechanics
    </a>
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-user-cog"></i> Mechanic Details</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.mechanics.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Mechanic
            </button>
        </form>
    </div>
</div>
@endsection