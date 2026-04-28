@extends('layouts.dashboard')

@section('title', 'Reports')
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
    <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">◉</span> All Members</a>
    <a href="{{ route('members.create') }}" class="nav-link"><span class="nav-icon">+</span> Add Member</a>

    @if(Auth::user()->isSuperAdmin())
        <span class="nav-section">System</span>
        <a href="{{ route('members.index') }}" class="nav-link"><span class="nav-icon">⚥</span> Users</a>
        <a href="{{ route('admin.roles.index') }}" class="nav-link"><span class="nav-icon">◐</span> Roles</a>
    @endif
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isManager())
        <span class="nav-section">Insights</span>
        <a href="{{ route('manager.reports') }}" class="nav-link active"><span class="nav-icon">▤</span> Reports</a>
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
    <h1>Reports & Insights</h1>
    <p>Analyze membership distribution and joining trends.</p>
</div>

<div class="charts-grid">
    <div class="card">
        <div class="card-header">
            <h2>Membership Types</h2>
        </div>
        <div class="chart-container">
            <canvas id="typeChart"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Member Status</h2>
        </div>
        <div class="chart-container">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Recent Join Activity (Last 7 Days)</h2>
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
            labels: ['Gold', 'Silver', 'Bronze'],
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
            labels: ['Active', 'Expired', 'Cancelled'],
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
            labels: joinDates.length ? joinDates : ['No Data'],
            datasets: [{
                label: 'New Members',
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
