@extends('layouts.dashboard')

@section('title', 'Member Profile')
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
    <a href="{{ route('members.create') }}" class="nav-link"><span class="nav-icon">+</span> Add Member</a>

    @if(Auth::user()->isSuperAdmin())
        <span class="nav-section">System</span>
        <a href="{{ route('admin.users.index') }}" class="nav-link"><span class="nav-icon">⚥</span> Users</a>
        <a href="{{ route('admin.roles.index') }}" class="nav-link"><span class="nav-icon">◐</span> Roles</a>
    @endif
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
        <a href="{{ route('manager.reports') }}" class="nav-link"><span class="nav-icon">▤</span> Reports</a>
    @endif
@endsection

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-end;">
    <div>
        <h1>Member Profile</h1>
        <p>Details for {{ $member->name }}.</p>
    </div>
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
        <a href="{{ route('members.edit', $member) }}" class="btn btn-primary">Edit Profile</a>
    @endif
</div>

<div class="card" style="padding: 30px;">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        <div>
            <h3 style="font-size:14px; color:var(--muted); text-transform:uppercase; margin-bottom:10px;">Personal Infomation</h3>
            <p><strong>Name:</strong> {{ $member->name }}</p>
            <p><strong>Email:</strong> {{ $member->email }}</p>
            <p><strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}</p>
        </div>
        <div>
            <h3 style="font-size:14px; color:var(--muted); text-transform:uppercase; margin-bottom:10px;">Membership Info</h3>
            <p><strong>Type:</strong> 
                <span class="badge {{ $member->membership_type === 'Gold' ? 'badge-gold' : ($member->membership_type === 'Silver' ? 'badge-silver' : 'badge-bronze') }}">
                    {{ $member->membership_type }}
                </span>
            </p>
            <p><strong>Status:</strong> 
                @if($member->status === 'active')
                    <span class="badge badge-active">Active</span>
                @elseif($member->status === 'expired')
                    <span class="badge badge-expired">Expired</span>
                @else
                    <span class="badge" style="background:#e2e0d8;color:#7a7870">Cancelled</span>
                @endif
            </p>
            <p><strong>Join Date:</strong> {{ \Carbon\Carbon::parse($member->join_date)->format('d M Y') }}</p>
            <p><strong>Expiry Date:</strong> {{ $member->expiry_date ? \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') : 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection
