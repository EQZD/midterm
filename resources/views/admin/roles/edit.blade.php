@extends('layouts.dashboard')

@section('title', __('messages.edit') . ' ' . $role->display_name)
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

@push('styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 8px; }
    .form-control { width: 100%; max-width: 520px; padding: 10px 12px; font-size: 14px; border: 1px solid var(--border); border-radius: 6px; font-family: inherit; }
    .form-control:focus { outline: none; border-color: var(--text); }
    .checkbox-group { display: grid; gap: 8px; }
    .checkbox-item label { display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer; }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>{{ __('messages.edit') }} {{ $role->display_name }}</h1>
    <p>{{ $role->name }}</p>
</div>

<div class="card" style="padding:30px">
    @if($errors->any())
        <div class="alert" style="background:#fcebeb;border-color:#e24b4a;color:#501313;margin-bottom:20px;">
            <ul style="margin-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.roles.update', $role) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input type="text" name="display_name" class="form-control" value="{{ old('display_name', $role->display_name) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.description') }}</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $role->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('messages.users') }}</label>
            <div class="checkbox-group">
                @foreach($users as $user)
                    <div class="checkbox-item">
                        <label>
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" {{ in_array($user->id, old('user_ids', $assigned)) ? 'checked' : '' }}>
                            {{ $user->name }} <span style="color:var(--muted)">({{ $user->email }})</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
        <a href="{{ route('admin.roles.index') }}" class="btn" style="margin-left:10px">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
