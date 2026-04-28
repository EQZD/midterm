@extends('layouts.dashboard')

@section('title', __('messages.reports'))
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
    <a href="{{ route('members.create') }}" class="nav-link"><span class="nav-icon">+</span> {{ __('messages.add_member') }}</a>

    @if(Auth::user()->isSuperAdmin())
        <span class="nav-section">{{ __('messages.system') }}</span>
        <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">⚥</span> {{ __('messages.users') }}</a>
        <a href="{{ route('admin.roles.index') }}" class="nav-link"><span class="nav-icon">◐</span> {{ __('messages.roles') }}</a>
    @endif
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
        <span class="nav-section">{{ __('messages.reports') }}</span>
        <a href="{{ route('manager.reports') }}" class="nav-link active"><span class="nav-icon">▤</span> {{ __('messages.reports') }}</a>
    @endif
@endsection

@push('styles')
<style>
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        padding: 20px;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>{{ __('messages.reports_insights') }}</h1>
    <p>{{ __('messages.reports_subtitle') }}</p>
</div>

<div class="charts-grid">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('messages.membership_types') }}</h2>
        </div>
        <div class="chart-container">
            <canvas id="typeChart"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>{{ __('messages.member_status') }}</h2>
        </div>
        <div class="chart-container">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>{{ __('messages.recent_join_activity') }}</h2>
    </div>
    <div class="chart-container" style="height: 350px;">
        <canvas id="joinsChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: ['{{ __('messages.gold') }}', '{{ __('messages.silver') }}', '{{ __('messages.bronze') }}'],
            datasets: [{
                data: [
                    {{ $membershipData['Gold'] ?? 0 }},
                    {{ $membershipData['Silver'] ?? 0 }},
                    {{ $membershipData['Bronze'] ?? 0 }}
                ],
                backgroundColor: ['#eeb557', '#aeb2ba', '#cd7f32'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ['{{ __('messages.active') }}', '{{ __('messages.expired') }}', '{{ __('messages.cancelled') }}'],
            datasets: [{
                data: [
                    {{ $statusData['Active'] ?? 0 }},
                    {{ $statusData['Expired'] ?? 0 }},
                    {{ $statusData['Cancelled'] ?? 0 }}
                ],
                backgroundColor: ['#639922', '#a32d2d', '#7a7870'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const joinsCtx = document.getElementById('joinsChart').getContext('2d');
    
    const joinDates = {!! json_encode($recentJoins->pluck('date')) !!};
    const joinCounts = {!! json_encode($recentJoins->pluck('count')) !!};

    new Chart(joinsCtx, {
        type: 'bar',
        data: {
            labels: joinDates.length ? joinDates : ['{{ __('messages.no_data') }}'],
            datasets: [{
                label: '{{ __('messages.new_members') }}',
                data: joinCounts.length ? joinCounts : [0],
                backgroundColor: '#1a1917',
                borderRadius: 4
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endpush
