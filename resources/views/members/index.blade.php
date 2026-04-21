@extends('layouts.dashboard')

@section('title', 'Members')
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
    <a href="{{ route('members.index') }}" class="nav-link active"><span class="nav-icon">◉</span> All Members</a>
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
        <h1>Members Directory</h1>
        <p>Manage physical fitness club members.</p>
    </div>
    <a href="{{ route('members.create') }}" class="btn btn-primary">+ Register Member</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Membership</th>
                <th>Status</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($members as $member)
            <tr>
                <td style="font-weight:500">
                    <a href="{{ route('members.show', $member) }}" style="color:var(--text);text-decoration:none;">{{ $member->name }}</a>
                    <div style="font-size:11px;color:var(--muted)">{{ $member->email }}</div>
                </td>
                <td>
                    <span class="badge {{ $member->membership_type === 'Gold' ? 'badge-gold' : ($member->membership_type === 'Silver' ? 'badge-silver' : 'badge-bronze') }}">
                        {{ $member->membership_type }}
                    </span>
                </td>
                <td>
                    @if($member->status === 'active')
                        <span class="badge badge-active">Active</span>
                    @elseif($member->status === 'expired')
                        <span class="badge badge-expired">Expired</span>
                    @else
                        <span class="badge" style="background:#e2e0d8;color:#7a7870">Cancelled</span>
                    @endif
                </td>
                <td style="color:var(--muted);font-family:'DM Mono',monospace;font-size:12px">
                    {{ $member->expiry_date ? \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') : 'N/A' }}
                </td>
                <td>
                    <a href="{{ route('members.show', $member) }}" class="btn btn-sm">View</a>
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
                        <a href="{{ route('members.edit', $member) }}" class="btn btn-sm">Edit</a>
                    @endif
                    @if(Auth::user()->isSuperAdmin())
                        <form method="POST" action="{{ route('members.destroy', $member) }}" style="display:inline" onsubmit="return confirm('Delete this member completely?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm" style="color:#a32d2d;border-color:#f7c1c1">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--muted);text-align:center;padding:24px">No members found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $members->links() }}
</div>
@endsection
