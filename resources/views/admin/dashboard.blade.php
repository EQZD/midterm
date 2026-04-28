@extends('layouts.dashboard')

@section('title', __('messages.admin_dashboard'))
@section('role-label', 'Super Admin')
@php $badgeBg = '#1a1917'; $badgeColor = '#f5f4f0'; @endphp

@section('nav')
    <span class="nav-section">{{ __('messages.overview') }}</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
        <span class="nav-icon">◈</span> {{ __('messages.dashboard') }}
    </a>

    <span class="nav-section">{{ __('messages.members') }}</span>
    <a href="{{ route('members.index') }}" class="nav-link">
        <span class="nav-icon">◉</span> {{ __('messages.all_members') }}
    </a>
    <a href="{{ route('members.create') }}" class="nav-link">
        <span class="nav-icon">+</span> {{ __('messages.add_member') }}
    </a>

    <span class="nav-section">{{ __('messages.system') }}</span>
    <a href="{{ route('admin.roles.index') }}" class="nav-link">
        <span class="nav-icon">◐</span> {{ __('messages.roles') }}
    </a>
    <a href="{{ route('manager.reports') }}" class="nav-link">
        <span class="nav-icon">▤</span> {{ __('messages.reports') }}
    </a>
@endsection

@section('content')
<div class="page-header">
    <h1>{{ __('messages.good_morning', ['name' => Auth::user()->name]) }}</h1>
    <p>{{ __('messages.today_club_summary') }}</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">{{ __('messages.total_members') }}</div>
        <div class="value">{{ $totalMembers ?? 0 }}</div>
        <div class="delta up">↑ {{ __('messages.this_week', ['count' => 4]) }}</div>
    </div>
    <div class="stat-card">
        <div class="label">{{ __('messages.active') }}</div>
        <div class="value">{{ $activeMembers ?? 0 }}</div>
        <div class="delta">{{ __('messages.of_total', ['count' => $totalMembers ?? 0]) }}</div>
    </div>
    <div class="stat-card">
        <div class="label">{{ __('messages.expiring_soon') }}</div>
        <div class="value">{{ $expiringSoon ?? 0 }}</div>
        <div class="delta down">↓ {{ __('messages.needs_attention') }}</div>
    </div>
    <div class="stat-card">
        <div class="label">{{ __('messages.staff_users') }}</div>
        <div class="value">{{ $staffCount ?? 0 }}</div>
        <div class="delta">{{ __('messages.active_accounts') }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>{{ __('messages.recent_members') }}</h2>
        <a href="{{ route('members.index') }}" class="btn btn-sm">{{ __('messages.view_all') }} -></a>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.type') }}</th>
                <th>{{ __('messages.joined') }}</th>
                <th>{{ __('messages.actions') }}</th>
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
                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm">{{ __('messages.edit') }}</a>
                    <form method="POST" action="{{ route('members.destroy', $member) }}" style="display:inline" onsubmit="return confirm('Delete this member?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="color:#a32d2d;border-color:#f7c1c1">{{ __('messages.delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--muted);text-align:center;padding:24px">{{ __('messages.no_members_yet') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h2>{{ __('messages.role_management') }}</h2>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-primary">{{ __('messages.manage_roles') }} -></a>
    </div>
    <table>
        <thead>
            <tr><th>{{ __('messages.role') }}</th><th>{{ __('messages.description') }}</th><th>{{ __('messages.users') }}</th></tr>
        </thead>
        <tbody>
        @forelse($roles ?? [] as $role)
            <tr>
                <td style="font-weight:500;font-family:'DM Mono',monospace;font-size:12px">{{ $role->name }}</td>
                <td style="color:var(--muted)">{{ $role->description }}</td>
                <td>{{ $role->users_count ?? 0 }}</td>
            </tr>
        @empty
            <tr><td colspan="3" style="color:var(--muted);text-align:center;padding:24px">{{ __('messages.no_roles_found') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
