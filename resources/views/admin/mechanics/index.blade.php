@extends('layouts.admin')

@section('title', 'Manage Mechanics')

@section('content')
<div class="header">
    <h1><i class="fas fa-user-cog"></i> Manage Mechanics</h1>
    <a href="{{ route('admin.mechanics.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Mechanic
    </a>
</div>

<div class="content-card">
    <div class="card-header">
        <h3><i class="fas fa-users"></i> Active Mechanics</h3>
    </div>
    <div class="card-body">
        @if($mechanics->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mechanics as $mechanic)
                    <tr>
                        <td>{{ $mechanic->name }}</td>
                        <td>{{ $mechanic->phone }}</td>
                        <td>
                            <a href="{{ route('admin.mechanics.edit', $mechanic->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.mechanics.destroy', $mechanic->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deactivate this mechanic?')">
                                    <i class="fas fa-trash"></i> Deactivate
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No active mechanics found.</p>
        @endif
    </div>
</div>
@endsection