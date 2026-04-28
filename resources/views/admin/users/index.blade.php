@extends('layouts.dashboard')

@section('title', __('messages.manage_users'))
@section('role-label', 'Super Admin')
@php $badgeBg = '#1a1917'; $badgeColor = '#f5f4f0'; @endphp

@section('nav')
    <span class="nav-section">{{ __('messages.overview') }}</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <span class="nav-icon">◈</span> {{ __('messages.dashboard') }}
    </a>

    <span class="nav-section">{{ __('messages.system') }}</span>
    <a href="{{ route('members.index') }}" class="nav-link active">
        <span class="nav-icon">⚥</span> {{ __('messages.users') }}
    </a>
    <a href="{{ route('admin.roles.index') }}" class="nav-link">
        <span class="nav-icon">◐</span> {{ __('messages.roles') }}
    </a>
@endsection

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-end;">
    <div>
        <h1>{{ __('messages.users') }}</h1>
        <p>{{ __('messages.manage_users_subtitle') }}</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ {{ __('messages.create_user') }}</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.roles') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            <tr>
                <td style="font-weight:500">{{ $u->name }}</td>
                <td style="color:var(--muted)">{{ $u->email }}</td>
                <td>
                    @foreach($u->roles as $r)
                        <span class="badge" style="background:#eaf3de;color:#27500a;margin-right:4px;">{{ $r->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm">{{ __('messages.edit') }}</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" style="display:inline" onsubmit="return confirm('{{ __('messages.confirm_delete_user') }}')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="color:#a32d2d;border-color:#f7c1c1">{{ __('messages.delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="color:var(--muted);text-align:center;padding:24px">{{ __('messages.no_users_found') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $users->links() }}
</div>
@endsection
