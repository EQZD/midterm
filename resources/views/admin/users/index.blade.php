@extends('layouts.dashboard')

@section('title', 'Manage Users')
@section('role-label', 'Super Admin')
@php $badgeBg = '#1a1917'; $badgeColor = '#f5f4f0'; @endphp

@section('nav')
    <span class="nav-section">Overview</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <span class="nav-icon">◈</span> Dashboard
    </a>

    <span class="nav-section">System</span>
    <a href="{{ route('admin.users.index') }}" class="nav-link active">
        <span class="nav-icon">⚥</span> Users
    </a>
    <a href="{{ route('admin.roles.index') }}" class="nav-link">
        <span class="nav-icon">◐</span> Roles
    </a>
@endsection

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-end;">
    <div>
        <h1>Users</h1>
        <p>Manage staff, managers, and other system users.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Create User</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
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
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" style="display:inline" onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="color:#a32d2d;border-color:#f7c1c1">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="color:var(--muted);text-align:center;padding:24px">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $users->links() }}
</div>
@endsection
