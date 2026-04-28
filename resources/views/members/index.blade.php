@extends('layouts.dashboard')

@section('title', __('messages.members'))
@section('role-label', Auth::user()->isSuperAdmin() ? 'Super Admin' : (Auth::user()->isManager() ? 'Manager' : 'Staff'))

@section('nav')
    <span class="nav-section">{{ __('messages.overview') }}</span>
    @if(Auth::user()->isSuperAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-link"><span class="nav-icon">◈</span> {{ __('messages.dashboard') }}</a>
    @elseif(Auth::user()->isManager())
        <a href="{{ route('manager.dashboard') }}" class="nav-link"><span class="nav-icon">◈</span> {{ __('messages.dashboard') }}</a>
    @else
        <a href="{{ route('staff.dashboard') }}" class="nav-link"><span class="nav-icon">◈</span> {{ __('messages.dashboard') }}</a>
    @endif

    <span class="nav-section">{{ __('messages.members') }}</span>
    <a href="{{ route('members.index') }}" class="nav-link active"><span class="nav-icon">◉</span> {{ __('messages.all_members') }}</a>
    <a href="{{ route('members.create') }}" class="nav-link"><span class="nav-icon">+</span> {{ __('messages.add_member') }}</a>

    @if(Auth::user()->isSuperAdmin())
        <span class="nav-section">{{ __('messages.system') }}</span>
        <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">⚥</span> {{ __('messages.users') }}</a>
        <a href="{{ route('admin.roles.index') }}" class="nav-link"><span class="nav-icon">◐</span> {{ __('messages.roles') }}</a>
    @endif
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
        <a href="{{ route('manager.reports') }}" class="nav-link"><span class="nav-icon">▤</span> {{ __('messages.reports') }}</a>
    @endif
@endsection

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-end;">
    <div>
        <h1>{{ __('messages.members_directory') }}</h1>
        <p>{{ __('messages.members_directory_subtitle') }}</p>
    </div>
    <a href="{{ route('members.create') }}" class="btn btn-primary">+ {{ __('messages.register_member') }}</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.membership') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.expiry_date') }}</th>
                <th>{{ __('messages.actions') }}</th>
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
                        <span class="badge badge-active">{{ __('messages.active') }}</span>
                    @elseif($member->status === 'expired')
                        <span class="badge badge-expired">{{ __('messages.expired') }}</span>
                    @else
                        <span class="badge" style="background:#e2e0d8;color:#7a7870">{{ __('messages.cancelled') }}</span>
                    @endif
                </td>
                <td style="color:var(--muted);font-family:'DM Mono',monospace;font-size:12px">
                    {{ $member->expiry_date ? \Carbon\Carbon::parse($member->expiry_date)->format('d M Y') : __('messages.n_a') }}
                </td>
                <td>
                    <a href="{{ route('members.show', $member) }}" class="btn btn-sm">{{ __('messages.view') }}</a>
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
                        <a href="{{ route('members.edit', $member) }}" class="btn btn-sm">{{ __('messages.edit') }}</a>
                    @endif
                    @if(Auth::user()->isSuperAdmin())
                        <form method="POST" action="{{ route('members.destroy', $member) }}" style="display:inline" onsubmit="return confirm('{{ __('messages.confirm_delete_member') }}')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm" style="color:#a32d2d;border-color:#f7c1c1">{{ __('messages.delete') }}</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--muted);text-align:center;padding:24px">{{ __('messages.no_members_found') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $members->links() }}
</div>
@endsection
