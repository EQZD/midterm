@extends('layouts.dashboard')

@section('title', 'Manager Dashboard')
@section('role-label', 'Manager')
@php $badgeBg = '#e6f1fb'; $badgeColor = '#042c53'; @endphp

@section('nav')
    <span class="nav-section">Overview</span>
    <a href="{{ route('manager.dashboard') }}" class="nav-link active">
        <span class="nav-icon">◈</span> Dashboard
    </a>

    <span class="nav-section">Members</span>
    <a href="{{ route('members.index') }}" class="nav-link">
        <span class="nav-icon">◉</span> All Members
    </a>
    <a href="{{ route('members.create') }}" class="nav-link">
        <span class="nav-icon">+</span> Add Member
    </a>

    <span class="nav-section">Reports</span>
    <a href="{{ route('manager.reports') }}" class="nav-link">
        <span class="nav-icon">▤</span> Reports
    </a>
@endsection

@section('content')
<div class="page-header">
    <h1>Manager Dashboard</h1>
    <p>Membership overview and analytics.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Members</div>
        <div class="value">{{ $totalMembers ?? 0 }}</div>
        <div class="delta">registered</div>
    </div>
    <div class="stat-card">
        <div class="label">Gold</div>
        <div class="value">{{ $goldCount ?? 0 }}</div>
        <div class="delta">premium tier</div>
    </div>
    <div class="stat-card">
        <div class="label">Silver</div>
        <div class="value">{{ $silverCount ?? 0 }}</div>
        <div class="delta">standard tier</div>
    </div>
    <div class="stat-card">
        <div class="label">Bronze</div>
        <div class="value">{{ $bronzeCount ?? 0 }}</div>
        <div class="delta">basic tier</div>
    </div>
</div>

{{-- Membership type breakdown bar --}}
@if(($totalMembers ?? 0) > 0)
<div class="card" style="margin-bottom:24px">
    <div class="card-header"><h2>Membership breakdown</h2></div>
    <div class="card-body">
        <div style="display:flex;gap:4px;border-radius:6px;overflow:hidden;height:12px">
            @php
                $gold   = $goldCount ?? 0;
                $silver = $silverCount ?? 0;
                $bronze = $bronzeCount ?? 0;
                $total  = max($totalMembers ?? 1, 1);
            @endphp
            <div style="flex:{{ $gold }};background:#ba7517;min-width:{{ $gold ? '4px' : '0' }}"></div>
            <div style="flex:{{ $silver }};background:#888780;min-width:{{ $silver ? '4px' : '0' }}"></div>
            <div style="flex:{{ $bronze }};background:#d85a30;min-width:{{ $bronze ? '4px' : '0' }}"></div>
        </div>
        <div style="display:flex;gap:20px;margin-top:10px;font-size:12px;color:var(--muted)">
            <span><span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#ba7517;margin-right:5px"></span>Gold {{ round($gold/$total*100) }}%</span>
            <span><span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#888780;margin-right:5px"></span>Silver {{ round($silver/$total*100) }}%</span>
            <span><span style="display:inline-block;width:8px;height:8px;border-radius:2px;background:#d85a30;margin-right:5px"></span>Bronze {{ round($bronze/$total*100) }}%</span>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>Members</h2>
        <a href="{{ route('members.create') }}" class="btn btn-sm btn-primary">+ Add Member</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Phone</th>
                <th>Joined</th>
                <th></th>
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
                <td><a href="{{ route('members.edit', $member) }}" class="btn btn-sm">Edit</a></td>
            </tr>
        @empty
            <tr><td colspan="6" style="color:var(--muted);text-align:center;padding:24px">No members found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
