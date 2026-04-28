@extends('layouts.public')

@section('title', __('public.nav.home'))

@section('content')
@if(($auth ?? null) === 'success')
    <script>alert('{{ __('messages.authorization_success') }}');</script>
@endif

<section class="hero">
    <div class="hero-inner">
        <span class="eyebrow">{{ __('public.home.hero_badge') }}</span>
        <h1>{{ __('public.home.title') }}</h1>
        <p>{{ __('public.home.intro') }}</p>
        <div class="hero-actions">
            <a class="btn" href="{{ route('public.pricing') }}">{{ __('public.common.cta_join') }}</a>
            <a class="btn btn-secondary" style="background:rgba(255,255,255,0.9)" href="{{ route('public.contact') }}">{{ __('public.common.cta_contact') }}</a>
        </div>
    </div>
</section>

<section class="section-inner">
    <div class="promo-banner">
        <div>
            <span class="promo-badge">{{ __('public.home.promo.badge') }}</span>
            <h2>{{ __('public.home.promo.title') }}</h2>
            <p>{{ __('public.home.promo.text') }}</p>
            <div class="hero-actions">
                <a class="btn" style="background:#fff;color:#171717;border-color:#fff" href="{{ route('public.pricing') }}">{{ __('public.common.cta_join') }}</a>
                <a class="btn btn-secondary" style="color:#fff;border-color:rgba(255,255,255,0.45)" href="{{ route('public.schedule') }}">{{ __('public.nav.schedule') }}</a>
            </div>
        </div>
        <div class="promo-stat">
            <strong>{{ __('public.home.promo.discount') }}</strong>
            <span>{{ __('public.home.promo.discount_text') }}</span>
        </div>
    </div>
</section>

<section class="section-inner">
    <div class="page-header">
        <h1>{{ __('public.home.highlights_title') }}</h1>
    </div>
    <div class="grid">
        @foreach(__('public.home.highlights') as $item)
            <article class="card">
                <h2>{{ $item['title'] }}</h2>
                <p>{{ $item['text'] }}</p>
            </article>
        @endforeach
    </div>
</section>

<section class="section-inner">
    <div class="page-header">
        <h1>{{ __('public.home.charts_title') }}</h1>
        <p>{{ __('public.home.charts_intro') }}</p>
    </div>
    <div class="charts-grid">
        <div class="card chart-box">
            <h2>{{ __('public.home.visitors_chart') }}</h2>
            <canvas id="visitorsChart"></canvas>
        </div>
        <div class="card chart-box">
            <h2>{{ __('public.home.programs_chart') }}</h2>
            <canvas id="programsChart"></canvas>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartTextColor = '#636059';
    const visitorsCanvas = document.getElementById('visitorsChart');
    const programsCanvas = document.getElementById('programsChart');

    if (visitorsCanvas) {
        new Chart(visitorsCanvas, {
            type: 'line',
            data: {
                labels: @json(__('public.home.chart_days')),
                datasets: [{
                    label: @json(__('public.home.visitors_label')),
                    data: [84, 96, 112, 105, 128, 148, 137],
                    borderColor: '#171717',
                    backgroundColor: 'rgba(23, 23, 23, 0.12)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: chartTextColor } } },
                scales: {
                    x: { ticks: { color: chartTextColor }, grid: { display: false } },
                    y: { beginAtZero: true, ticks: { color: chartTextColor } }
                }
            }
        });
    }

    if (programsCanvas) {
        new Chart(programsCanvas, {
            type: 'doughnut',
            data: {
                labels: @json(__('public.home.chart_programs')),
                datasets: [{
                    data: [42, 28, 20, 10],
                    backgroundColor: ['#171717', '#ba7517', '#6f7d47', '#aeb2ba'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { color: chartTextColor } } }
            }
        });
    }
</script>
@endpush
