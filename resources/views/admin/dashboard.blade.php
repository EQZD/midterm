@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('role-label', 'Super Admin')
@php $badgeBg = '#1a1917'; $badgeColor = '#f5f4f0'; @endphp

@section('nav')
    <span class="nav-section">Overview</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
        <span class="nav-icon">◈</span> Dashboard
    </a>

    <span class="nav-section">Members</span>
    <a href="{{ route('members.index') }}" class="nav-link">
        <span class="nav-icon">◉</span> All Members
    </a>
    <a href="{{ route('members.create') }}" class="nav-link">
        <span class="nav-icon">+</span> Add Member
    </a>

    <span class="nav-section">System</span>
    <a href="{{ route('admin.roles.index') }}" class="nav-link">
        <span class="nav-icon">◐</span> Roles
    </a>
    <a href="{{ route('manager.reports') }}" class="nav-link">
        <span class="nav-icon">▤</span> Reports
    </a>
@endsection

@section('content')
<div class="page-header">
    <h1>Good morning, {{ Auth::user()->name }}.</h1>
    <p>Here's what's happening across the club today.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Members</div>
        <div class="value">{{ $totalMembers ?? 0 }}</div>
        <div class="delta up">↑ 4 this week</div>
    </div>
    <div class="stat-card">
        <div class="label">Active</div>
        <div class="value">{{ $activeMembers ?? 0 }}</div>
        <div class="delta">of {{ $totalMembers ?? 0 }} total</div>
    </div>
    <div class="stat-card">
        <div class="label">Expiring Soon</div>
        <div class="value">{{ $expiringSoon ?? 0 }}</div>
        <div class="delta down">↓ needs attention</div>
    </div>
    <div class="stat-card">
        <div class="label">Staff Users</div>
        <div class="value">{{ $staffCount ?? 0 }}</div>
        <div class="delta">active accounts</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Recent Members</h2>
        <a href="{{ route('members.index') }}" class="btn btn-sm">View all →</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($recentMembers ?? [] as $member)
            <tr>
                <td style="font-weight:500">{{ $member->name }}</td>
                <td style="color:var(--muted)">{{ $member->email }}</td>
                <td>
                    <span class="badge {{ $member->membership_type === 'Gold' ? 'badge-gold' : ($member->membership_type === 'Silver' ? 'badge-silver' : 'badge-bronze') }}">
                        {{ $member->membership_type }}
                    </span>
                </td>
                <td style="color:var(--muted);font-family:'DM Mono',monospace;font-size:12px">
                    {{ \Carbon\Carbon::parse($member->join_date)->format('d M Y') }}
                </td>
                <td>
                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm">Edit</a>
                    <form method="POST" action="{{ route('members.destroy', $member) }}" style="display:inline" onsubmit="return confirm('Delete this member?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="color:#a32d2d;border-color:#f7c1c1">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--muted);text-align:center;padding:24px">No members yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h2>Role Management</h2>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-primary">Manage Roles →</a>
    </div>
    <table>
        <thead>
            <tr><th>Role</th><th>Description</th><th>Users</th></tr>
        </thead>
        <tbody>
        @forelse($roles ?? [] as $role)
            <tr>
                <td style="font-weight:500;font-family:'DM Mono',monospace;font-size:12px">{{ $role->name }}</td>
                <td style="color:var(--muted)">{{ $role->description }}</td>
                <td>{{ $role->users_count ?? 0 }}</td>
            </tr>
        @empty
            <tr><td colspan="3" style="color:var(--muted);text-align:center;padding:24px">No roles found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
