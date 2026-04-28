@extends('layouts.dashboard')

@section('title', __('messages.roles'))
@section('role-label', 'Super Admin')
@php $badgeBg = '#1a1917'; $badgeColor = '#f5f4f0'; @endphp

@section('nav')
    <span class="nav-section">{{ __('messages.overview') }}</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
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
    <a href="{{ route('admin.roles.index') }}" class="nav-link active">
        <span class="nav-icon">◐</span> {{ __('messages.roles') }}
    </a>
    <a href="{{ route('manager.reports') }}" class="nav-link">
        <span class="nav-icon">▤</span> {{ __('messages.reports') }}
    </a>
@endsection

@section('content')
<div class="page-header">
    <h1>{{ __('messages.role_management') }}</h1>
    <p>{{ __('messages.manage_roles') }}</p>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.role') }}</th>
                <th>{{ __('messages.description') }}</th>
                <th>{{ __('messages.users') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @forelse($roles as $role)
            <tr>
                <td>
                    <div style="font-weight:500">{{ $role->display_name }}</div>
                    <div style="font-size:11px;color:var(--muted);font-family:'DM Mono',monospace">{{ $role->name }}</div>
                </td>
                <td style="color:var(--muted)">{{ $role->description }}</td>
                <td>{{ $role->users_count ?? 0 }}</td>
                <td>
                    <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm">{{ __('messages.view') }}</a>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm">{{ __('messages.edit') }}</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="color:var(--muted);text-align:center;padding:24px">{{ __('messages.no_roles_found') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
