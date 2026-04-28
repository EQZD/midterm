@extends('layouts.dashboard')

@section('title', __('messages.staff_dashboard'))
@section('role-label', 'Staff')
@php $badgeBg = '#e1f5ee'; $badgeColor = '#04342c'; @endphp

@section('nav')
    <span class="nav-section">{{ __('messages.overview') }}</span>
    <a href="{{ route('staff.dashboard') }}" class="nav-link active">
        <span class="nav-icon">◈</span> {{ __('messages.dashboard') }}
    </a>

    <span class="nav-section">{{ __('messages.members') }}</span>
    <a href="{{ route('members.index') }}" class="nav-link">
        <span class="nav-icon">◉</span> {{ __('messages.all_members') }}
    </a>
    <a href="{{ route('members.create') }}" class="nav-link">
        <span class="nav-icon">+</span> {{ __('messages.register_member') }}
    </a>
@endsection

@section('content')
<div class="page-header">
    <h1>{{ __('messages.staff_dashboard') }}</h1>
    <p>{{ __('messages.staff_dashboard_subtitle') }}</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">{{ __('messages.total_members') }}</div>
        <div class="value">{{ $totalMembers ?? 0 }}</div>
        <div class="delta">{{ __('messages.in_system') }}</div>
    </div>
    <div class="stat-card">
        <div class="label">{{ __('messages.registered_today') }}</div>
        <div class="value">{{ $todayCount ?? 0 }}</div>
        <div class="delta">{{ __('messages.new_signups') }}</div>
    </div>
</div>

<div class="alert alert-info">
    {{ __('messages.staff_can_register') }}
</div>

<div class="card">
    <div class="card-header">
        <h2>{{ __('messages.quick_register') }}</h2>
        <a href="{{ route('members.create') }}" class="btn btn-sm btn-primary">+ {{ __('messages.new_member') }}</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.membership') }}</th>
                <th>{{ __('messages.phone') }}</th>
                <th>{{ __('messages.joined') }}</th>
                <th>{{ __('messages.profile') }}</th>
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
                <td><a href="{{ route('members.show', $member) }}" class="btn btn-sm">{{ __('messages.view') }}</a></td>
            </tr>
        @empty
            <tr><td colspan="6" style="color:var(--muted);text-align:center;padding:24px">{{ __('messages.no_members_register_first') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
