<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — MemberHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-text-size-adjust: 100%; }

        :root {
            --bg:       #f5f4f0;
            --surface:  #ffffff;
            --border:   #e2e0d8;
            --text:     #1a1917;
            --muted:    #7a7870;
            --accent:   #1a1917;
            --sidebar-w: 220px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        img, svg, video, canvas {
            max-width: 100%;
            height: auto;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 10;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand .logo {
            font-family: 'DM Mono', monospace;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: -0.5px;
        }
        .sidebar-brand .role-badge {
            display: inline-block;
            margin-top: 6px;
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 2px 8px;
            border-radius: 20px;
            background: var(--badge-bg, #f0ede6);
            color: var(--badge-color, #7a7870);
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 0;
            overflow-y: auto;
        }
        .nav-section {
            padding: 8px 20px 4px;
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 20px;
            font-size: 14px;
            color: var(--muted);
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: all 0.15s;
        }
        .nav-link:hover { color: var(--text); background: var(--bg); }
        .nav-link.active { color: var(--text); border-left-color: var(--text); background: var(--bg); font-weight: 500; }
        .nav-icon { font-size: 14px; width: 16px; text-align: center; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }
        .sidebar-footer .user-name { font-size: 13px; font-weight: 500; }
        .sidebar-footer .user-email { font-size: 11px; color: var(--muted); margin-top: 2px; }
        .logout-btn {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            color: var(--muted);
            text-decoration: none;
        }
        .logout-btn:hover { color: var(--text); }
        .language-switcher {
            display: flex;
            gap: 6px;
            margin-top: 12px;
        }
        .language-switcher a {
            padding: 3px 7px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 11px;
            color: var(--muted);
            text-decoration: none;
        }
        .language-switcher a.active {
            background: var(--text);
            border-color: var(--text);
            color: #fff;
        }

        /* ── Main ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            width: calc(100% - var(--sidebar-w));
            max-width: 1200px;
            padding: clamp(20px, 3vw, 40px);
        }

        .page-header {
            margin-bottom: 32px;
        }
        .page-header h1 {
            font-size: clamp(22px, 3vw, 32px);
            font-weight: 400;
            letter-spacing: -0.5px;
        }
        .page-header p {
            font-size: 14px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── Stat cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 18px 20px;
        }
        .stat-card .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--muted);
            font-weight: 500;
        }
        .stat-card .value {
            font-size: 28px;
            font-weight: 300;
            letter-spacing: -1px;
            margin-top: 6px;
            font-family: 'DM Mono', monospace;
        }
        .stat-card .delta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
        }
        .stat-card .delta.up { color: #3b6d11; }
        .stat-card .delta.down { color: #a32d2d; }

        /* ── Table ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow-x: auto;
            margin-bottom: 24px;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header h2 { font-size: 14px; font-weight: 500; }
        .card-body { padding: 20px; }
        .card-body table { min-width: 0; }

        table { width: 100%; min-width: 620px; border-collapse: collapse; font-size: 13px; }
        th {
            text-align: left;
            padding: 8px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--muted);
            font-weight: 500;
            border-bottom: 1px solid var(--border);
        }
        td { padding: 10px 12px; border-bottom: 1px solid var(--border); }
        td { overflow-wrap: anywhere; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--bg); }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        .badge-gold    { background: #faeeda; color: #633806; }
        .badge-silver  { background: #f1efe8; color: #444441; }
        .badge-bronze  { background: #faece7; color: #4a1b0c; }
        .badge-active  { background: #eaf3de; color: #27500a; }
        .badge-expired { background: #fcebeb; color: #501313; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
        }
        .btn:hover { background: var(--bg); }
        .btn-primary {
            background: var(--text);
            color: #fff;
            border-color: var(--text);
        }
        .btn-primary:hover { opacity: 0.85; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }

        /* ── Alert ── */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border-left: 3px solid;
        }
        .alert-info    { background: #e6f1fb; border-color: #378add; color: #042c53; }
        .alert-success { background: #eaf3de; border-color: #639922; color: #173404; }
        .alert-warning { background: #faeeda; border-color: #ba7517; color: #412402; }

        @media (min-width: 1400px) {
            :root { --sidebar-w: 260px; }
            .main { max-width: 1600px; }
            .stats-grid { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            :root { --sidebar-w: 190px; }
            .main { padding: 28px; }
            .nav-link { padding-inline: 16px; }
        }

        @media (max-width: 768px) {
            body {
                display: block;
                overflow-x: hidden;
            }

            .sidebar {
                position: static;
                width: 100%;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }

            .sidebar-brand,
            .sidebar-footer {
                padding: 16px;
            }

            .sidebar-nav {
                display: flex;
                gap: 6px;
                padding: 10px 12px;
                overflow-x: auto;
            }

            .nav-section {
                display: none;
            }

            .nav-link {
                flex: 0 0 auto;
                border-left: 0;
                border-bottom: 2px solid transparent;
                border-radius: 6px;
                padding: 9px 12px;
                white-space: nowrap;
            }

            .nav-link.active {
                border-left-color: transparent;
                border-bottom-color: var(--text);
            }

            .main {
                width: 100%;
                max-width: none;
                margin-left: 0;
                padding: 20px 16px 28px;
            }

            .page-header {
                margin-bottom: 22px;
            }

            .card-header,
            .page-header[style],
            div[style*="display:flex"],
            div[style*="justify-content:space-between"],
            div[style*="justify-content: space-between"] {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px;
            }

            div[style*="grid-template-columns:1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .card-body {
                padding: 16px;
            }

            .btn {
                min-height: 40px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .sidebar-footer .user-email {
                overflow-wrap: anywhere;
            }

            table {
                min-width: 560px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">MemberHub</div>
        <span class="role-badge" style="--badge-bg: {{ $badgeBg ?? '#f0ede6' }}; --badge-color: {{ $badgeColor ?? '#7a7870' }}">
            @yield('role-label')
        </span>
    </div>

    <nav class="sidebar-nav">
        @yield('nav')
    </nav>

    <div class="sidebar-footer">
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div class="user-email">{{ Auth::user()->email }}</div>
        <div class="language-switcher" aria-label="{{ __('messages.choose_language') }}">
            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ route('lang.switch', 'ru') }}" class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}">RU</a>
            <a href="{{ route('lang.switch', 'kz') }}" class="{{ app()->getLocale() === 'kz' ? 'active' : '' }}">KZ</a>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="logout-btn">{{ __('messages.sign_out') }} -></button>
        </form>
    </div>
</aside>

<main class="main">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert" style="background:#fcebeb;border-color:#e24b4a;color:#501313">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>
