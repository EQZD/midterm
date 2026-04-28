@extends('layouts.dashboard')

@section('title', __('messages.edit_user'))
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

@push('styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 8px; }
    .form-control { width: 100%; max-width: 400px; padding: 10px 12px; font-size: 14px; border: 1px solid var(--border); border-radius: 6px; font-family: inherit; }
    .form-control:focus { outline: none; border-color: var(--text); }
    .checkbox-group { display: flex; flex-direction: column; gap: 8px; }
    .checkbox-item label { font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>{{ __('messages.edit_user') }}</h1>
    <p>{{ __('messages.edit_user_subtitle', ['name' => $user->name]) }}</p>
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

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">{{ __('messages.full_name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.email_address') }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.password') }}</label>
            <input type="password" name="password" class="form-control" minlength="6">
            <div style="font-size:11px;color:var(--muted);margin-top:4px;">{{ __('messages.password_keep_current') }}</div>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.roles') }}</label>
            <div class="checkbox-group">
                @foreach($roles as $role)
                    <div class="checkbox-item">
                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div style="margin-top:30px;">
            <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
            <a href="{{ route('members.index') }}" class="btn" style="margin-left:10px;">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
