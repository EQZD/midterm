<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ __('public.common.club') }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }
        body { margin: 0; font-family: Arial, sans-serif; color: #171717; background: #f7f7f4; line-height: 1.5; }
        img, svg, video, canvas { max-width: 100%; height: auto; }
        a { color: inherit; }
        .site-header { position: sticky; top: 0; z-index: 20; background: rgba(255,255,255,0.96); border-bottom: 1px solid #e3e1d8; }
        .nav { width: 92%; max-width: 1180px; margin: 0 auto; padding: 14px 0; display: flex; align-items: center; gap: 24px; }
        .brand { font-weight: 700; letter-spacing: 0.2px; text-decoration: none; white-space: nowrap; }
        .nav-links { display: flex; align-items: center; gap: 16px; flex: 1; flex-wrap: wrap; }
        .nav-links a { font-size: 14px; color: #55534e; text-decoration: none; }
        .nav-links a.active, .nav-links a:hover { color: #171717; }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .language-switcher { display: flex; gap: 5px; }
        .language-switcher a { padding: 4px 7px; border: 1px solid #d7d4c9; border-radius: 5px; font-size: 12px; color: #55534e; text-decoration: none; }
        .language-switcher a.active { background: #171717; border-color: #171717; color: #fff; }
        .link-button { border: 0; background: transparent; font: inherit; color: #55534e; cursor: pointer; padding: 0; }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 38px; padding: 8px 14px; border: 1px solid #171717; border-radius: 6px; background: #171717; color: #fff; text-decoration: none; font-size: 14px; cursor: pointer; }
        .btn-secondary { background: transparent; color: #171717; border-color: #c9c5b8; }
        .hero { min-height: 520px; display: flex; align-items: center; background: linear-gradient(rgba(0,0,0,0.48), rgba(0,0,0,0.48)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1800&q=80') center/cover; color: #fff; }
        .hero-inner, .page, .section-inner { width: 92%; max-width: 1180px; margin: 0 auto; padding: clamp(36px, 5vw, 64px) 0; }
        .hero h1 { max-width: 780px; margin: 0; font-size: clamp(38px, 7vw, 76px); line-height: 0.98; letter-spacing: 0; }
        .hero p { max-width: 620px; margin: 20px 0 0; font-size: 18px; color: #f1eee8; }
        .eyebrow { display: inline-block; margin-bottom: 18px; padding: 5px 10px; border: 1px solid rgba(255,255,255,0.45); border-radius: 999px; font-size: 13px; color: #fff; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 28px; }
        .page-header { padding-bottom: 18px; border-bottom: 1px solid #e3e1d8; margin-bottom: 28px; }
        .page-header h1 { margin: 0; font-size: clamp(32px, 5vw, 54px); letter-spacing: 0; }
        .page-header p { max-width: 760px; margin: 12px 0 0; color: #636059; font-size: 17px; }
        .grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .grid.two { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .card { background: #fff; border: 1px solid #e3e1d8; border-radius: 8px; padding: 22px; }
        .card h2, .card h3 { margin: 0 0 10px; font-size: 20px; }
        .card p { margin: 0; color: #636059; }
        .list { margin: 12px 0 0; padding-left: 18px; color: #504d47; }
        .schedule-day { margin-bottom: 18px; }
        table { display: block; width: 100%; min-width: 0; overflow-x: auto; border-collapse: collapse; background: #fff; border: 1px solid #e3e1d8; border-radius: 8px; }
        thead, tbody, tr { width: 100%; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #e3e1d8; text-align: left; font-size: 14px; }
        th { color: #636059; background: #f0eee8; font-weight: 600; }
        tr:last-child td { border-bottom: 0; }
        .price { font-size: 24px; font-weight: 700; margin: 8px 0 12px; }
        .promo-banner { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 20px; align-items: center; background: #171717; color: #fff; border-radius: 8px; padding: 28px; overflow: hidden; }
        .promo-banner h2 { margin: 0; font-size: clamp(28px, 4vw, 44px); line-height: 1.05; }
        .promo-banner p { margin: 12px 0 0; color: #ddd8cf; max-width: 620px; }
        .promo-badge { display: inline-block; margin-bottom: 14px; padding: 5px 10px; border: 1px solid rgba(255,255,255,0.35); border-radius: 999px; color: #fff; font-size: 13px; }
        .promo-stat { background: #f0eee8; color: #171717; border-radius: 8px; padding: 22px; }
        .promo-stat strong { display: block; font-size: 42px; line-height: 1; }
        .charts-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .chart-box { height: 320px; }
        .contact-layout { display: grid; grid-template-columns: 0.8fr 1.2fr; gap: 20px; }
        .form-group { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; }
        input, textarea { width: 100%; padding: 11px 12px; border: 1px solid #cfcbbf; border-radius: 6px; font: inherit; background: #fff; }
        textarea { min-height: 150px; resize: vertical; }
        .alert { padding: 12px 14px; border-radius: 7px; margin-bottom: 16px; border-left: 3px solid #578d25; background: #edf7e5; color: #24480c; }
        .footer { margin-top: 40px; border-top: 1px solid #e3e1d8; color: #636059; }
        .footer .section-inner { padding-top: 24px; padding-bottom: 24px; display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; font-size: 14px; }
        @media (min-width: 1400px) {
            .nav, .hero-inner, .page, .section-inner { max-width: 1600px; }
            .grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .grid.two { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 820px) {
            .nav { align-items: flex-start; flex-direction: column; gap: 14px; }
            .nav-links { width: 100%; gap: 10px 14px; }
            .nav-actions { width: 100%; justify-content: space-between; flex-wrap: wrap; }
            .grid, .grid.two, .contact-layout, .promo-banner, .charts-grid { grid-template-columns: 1fr; }
            .hero { min-height: 460px; }
        }
        @media (max-width: 520px) {
            .nav, .hero-inner, .page, .section-inner { width: 90%; }
            .hero { min-height: 420px; }
            .hero p, .page-header p { font-size: 16px; }
            .btn { width: 100%; }
            .hero-actions, .nav-actions { align-items: stretch; flex-direction: column; }
            .promo-banner { padding: 20px; }
            th, td { padding: 10px; }
        }
    </style>
    @stack('styles')
</head>
<body>
<header class="site-header">
    <nav class="nav">
        <a class="brand" href="{{ route('main') }}">{{ __('public.common.club') }}</a>
        <div class="nav-links">
            <a class="{{ request()->routeIs('main') ? 'active' : '' }}" href="{{ route('main') }}">{{ __('public.nav.home') }}</a>
            <a class="{{ request()->routeIs('public.about') ? 'active' : '' }}" href="{{ route('public.about') }}">{{ __('public.nav.about') }}</a>
            <a class="{{ request()->routeIs('public.services') ? 'active' : '' }}" href="{{ route('public.services') }}">{{ __('public.nav.services') }}</a>
            <a class="{{ request()->routeIs('public.schedule') ? 'active' : '' }}" href="{{ route('public.schedule') }}">{{ __('public.nav.schedule') }}</a>
            <a class="{{ request()->routeIs('public.pricing') ? 'active' : '' }}" href="{{ route('public.pricing') }}">{{ __('public.nav.pricing') }}</a>
            <a class="{{ request()->routeIs('public.contact') ? 'active' : '' }}" href="{{ route('public.contact') }}">{{ __('public.nav.contact') }}</a>
        </div>
        <div class="nav-actions">
            <div class="language-switcher" aria-label="{{ __('messages.choose_language') }}">
                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('lang.switch', 'ru') }}" class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}">RU</a>
                <a href="{{ route('lang.switch', 'kz') }}" class="{{ app()->getLocale() === 'kz' ? 'active' : '' }}">KZ</a>
            </div>
            @auth
                <a class="btn btn-secondary" href="{{ url('/') }}">{{ __('public.nav.dashboard') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link-button">{{ __('public.nav.logout') }}</button>
                </form>
            @else
                <a class="btn btn-secondary" href="{{ route('login') }}">{{ __('public.nav.login') }}</a>
            @endauth
        </div>
    </nav>
</header>

@yield('content')

<footer class="footer">
    <div class="section-inner">
        <span>{{ __('public.common.club') }}</span>
        <span>{{ __('public.contact.hours') }}</span>
    </div>
</footer>
@stack('scripts')
</body>
</html>
