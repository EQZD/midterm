@extends('layouts.dashboard')

@section('title', $role->display_name)
@section('role-label', 'Super Admin')
@php $badgeBg = '#1a1917'; $badgeColor = '#f5f4f0'; @endphp

@section('nav')
    <span class="nav-section">{{ __('messages.overview') }}</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <span class="nav-icon">◈</span> {{ __('messages.dashboard') }}
    </a>

    <span class="nav-section">{{ __('messages.system') }}</span>
    <a href="{{ route('admin.roles.index') }}" class="nav-link active">
        <span class="nav-icon">◐</span> {{ __('messages.roles') }}
    </a>
@endsection

@section('content')
<div class="page-header" style="display:flex;justify-content:space-between;align-items:flex-end">
    <div>
        <h1>{{ $role->display_name }}</h1>
        <p>{{ $role->description }}</p>
    </div>
    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>
</div>

<div class="card">
    <div class="card-header">
        <h2>{{ __('messages.users') }}</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
            </tr>
        </thead>
        <tbody>
        @forelse($role->users as $user)
            <tr>
                <td style="font-weight:500">{{ $user->name }}</td>
                <td style="color:var(--muted)">{{ $user->email }}</td>
            </tr>
        @empty
            <tr><td colspan="2" style="color:var(--muted);text-align:center;padding:24px">{{ __('messages.no_users_found') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
