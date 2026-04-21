@extends('layouts.dashboard')

@section('title', 'Staff Dashboard')
@section('role-label', 'Staff')
@php $badgeBg = '#e1f5ee'; $badgeColor = '#04342c'; @endphp

@section('nav')
    <span class="nav-section">Overview</span>
    <a href="{{ route('staff.dashboard') }}" class="nav-link active">
        <span class="nav-icon">◈</span> Dashboard
    </a>

    <span class="nav-section">Members</span>
    <a href="{{ route('members.index') }}" class="nav-link">
        <span class="nav-icon">◉</span> All Members
    </a>
    <a href="{{ route('members.create') }}" class="nav-link">
        <span class="nav-icon">+</span> Register Member
    </a>
@endsection

@section('content')
<div class="page-header">
    <h1>Staff Dashboard</h1>
    <p>Register new members and look up existing ones.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Members</div>
        <div class="value">{{ $totalMembers ?? 0 }}</div>
        <div class="delta">in the system</div>
    </div>
    <div class="stat-card">
        <div class="label">Registered Today</div>
        <div class="value">{{ $todayCount ?? 0 }}</div>
        <div class="delta">new sign-ups</div>
    </div>
</div>

<div class="alert alert-info">
    As staff, you can <strong>view and register</strong> members. To edit or delete, contact a manager.
</div>

<div class="card">
    <div class="card-header">
        <h2>Quick Register</h2>
        <a href="{{ route('members.create') }}" class="btn btn-sm btn-primary">+ New Member</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Membership</th>
                <th>Phone</th>
                <th>Joined</th>
                <th>Profile</th>
            </tr>
        </thead>
        <tbody>
        @forelse($members ?? [] as $member)
            <tr>
                <td style="font-weight:500">{{ $member->name }}</td>
                <td style="color:var(--muted)">{{ $member->email }}</td>
                <td>
                    <span class="badge {{ $member->membership_type === 'Gold' ? 'badge-gold' : ($member->membership_type === 'Silver' ? 'badge-silver' : 'badge-bronze') }}">
                        {{ $member->membership_type }}
                    </span>
                </td>
                <td style="color:var(--muted)">{{ $member->phone ?? '—' }}</td>
                <td style="color:var(--muted);font-family:'DM Mono',monospace;font-size:12px">
                    {{ \Carbon\Carbon::parse($member->join_date)->format('d M Y') }}
                </td>
                <td><a href="{{ route('members.show', $member) }}" class="btn btn-sm">View</a></td>
            </tr>
        @empty
            <tr><td colspan="6" style="color:var(--muted);text-align:center;padding:24px">No members yet. Register the first one!</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
