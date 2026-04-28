@extends('layouts.dashboard')

@section('title', __('messages.register_member'))
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
    <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">◉</span> {{ __('messages.all_members') }}</a>
    <a href="{{ route('members.create') }}" class="nav-link active"><span class="nav-icon">+</span> {{ __('messages.add_member') }}</a>

    @if(Auth::user()->isSuperAdmin())
        <span class="nav-section">{{ __('messages.system') }}</span>
        <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">⚥</span> {{ __('messages.users') }}</a>
        <a href="{{ route('admin.roles.index') }}" class="nav-link"><span class="nav-icon">◐</span> {{ __('messages.roles') }}</a>
    @endif
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
        <a href="{{ route('manager.reports') }}" class="nav-link"><span class="nav-icon">▤</span> {{ __('messages.reports') }}</a>
    @endif
@endsection

@push('styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 8px; }
    .form-control { width: 100%; max-width: 400px; padding: 10px 12px; font-size: 14px; border: 1px solid var(--border); border-radius: 6px; font-family: inherit; }
    .form-control:focus { outline: none; border-color: var(--text); }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>{{ __('messages.register_member') }}</h1>
    <p>{{ __('messages.add_member_subtitle') }}</p>
</div>

<div class="card" style="padding: 30px;">
    @if($errors->any())
        <div class="alert" style="background:#fcebeb;border-color:#e24b4a;color:#501313;margin-bottom:20px;">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('members.store') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">{{ __('messages.full_name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.email_address') }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.phone_number') }}</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.membership_type') }}</label>
            <select name="membership_type" class="form-control" required>
                <option value="Bronze" {{ old('membership_type') == 'Bronze' ? 'selected' : '' }}>{{ __('messages.bronze') }}</option>
                <option value="Silver" {{ old('membership_type') == 'Silver' ? 'selected' : '' }}>{{ __('messages.silver') }}</option>
                <option value="Gold" {{ old('membership_type') == 'Gold' ? 'selected' : '' }}>{{ __('messages.gold') }}</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.status') }}</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>{{ __('messages.expired') }}</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.join_date') }}</label>
            <input type="date" name="join_date" class="form-control" value="{{ old('join_date', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.expiry_date') }}</label>
            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', date('Y-m-d', strtotime('+1 month'))) }}">
        </div>

        <div style="margin-top:30px;">
            <button type="submit" class="btn btn-primary">{{ __('messages.register_member') }}</button>
            <a href="{{ route('members.index') }}" class="btn" style="margin-left:10px;">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
