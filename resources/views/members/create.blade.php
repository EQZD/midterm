@extends('layouts.dashboard')

@section('title', 'Register Member')
@section('role-label', Auth::user()->isSuperAdmin() ? 'Super Admin' : (Auth::user()->isManager() ? 'Manager' : 'Staff'))

@section('nav')
    <span class="nav-section">Overview</span>
    @if(Auth::user()->isSuperAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-link"><span class="nav-icon">◈</span> Dashboard</a>
    @elseif(Auth::user()->isManager())
        <a href="{{ route('manager.dashboard') }}" class="nav-link"><span class="nav-icon">◈</span> Dashboard</a>
    @else
        <a href="{{ route('staff.dashboard') }}" class="nav-link"><span class="nav-icon">◈</span> Dashboard</a>
    @endif

    <span class="nav-section">Members</span>
    <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">◉</span> All Members</a>
    <a href="{{ route('members.create') }}" class="nav-link active"><span class="nav-icon">+</span> Add Member</a>

    @if(Auth::user()->isSuperAdmin())
        <span class="nav-section">System</span>
        <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">⚥</span> Users</a>
        <a href="{{ route('admin.roles.index') }}" class="nav-link"><span class="nav-icon">◐</span> Roles</a>
    @endif
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
        <a href="{{ route('manager.reports') }}" class="nav-link"><span class="nav-icon">▤</span> Reports</a>
    @endif
@endsection

@push('styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 8px; }
    .form-control { width: 100%; max-width: 400px; padding: 10px 12px; font-size: 14px; border: 1px solid var(--border); border-radius: 6px; font-family: inherit; }
    .form-control:focus { outline: none; border-color: var(--text); }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Register Member</h1>
    <p>Add a new physical fitness club member.</p>
</div>

<div class="card" style="padding: 30px;">
    @if($errors->any())
        <div class="alert" style="background:#fcebeb;border-color:#e24b4a;color:#501313;margin-bottom:20px;">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('members.store') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label class="form-label">Membership Type</label>
            <select name="membership_type" class="form-control" required>
                <option value="Bronze" {{ old('membership_type') == 'Bronze' ? 'selected' : '' }}>Bronze</option>
                <option value="Silver" {{ old('membership_type') == 'Silver' ? 'selected' : '' }}>Silver</option>
                <option value="Gold" {{ old('membership_type') == 'Gold' ? 'selected' : '' }}>Gold</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Join Date</label>
            <input type="date" name="join_date" class="form-control" value="{{ old('join_date', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', date('Y-m-d', strtotime('+1 month'))) }}">
        </div>

        <div style="margin-top:30px;">
            <button type="submit" class="btn btn-primary">Register Member</button>
            <a href="{{ route('members.index') }}" class="btn" style="margin-left:10px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
