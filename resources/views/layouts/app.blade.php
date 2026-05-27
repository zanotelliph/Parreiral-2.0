<!DOCTYPE html>
<html lang="pt-BR" x-data="{ sidebarOpen: true, darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Sistema de Cadastro e Controle')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg:        #F5F3EE;
            --surface:   #FFFFFF;
            --border:    #E2DDD5;
            --text:      #1A1714;
            --muted:     #7A7469;
            --accent:    #C84B2F;
            --accent2:   #2F6FC8;
            --success:   #2A7D4F;
            --warning:   #B87A1A;
            --sidebar-w: 260px;
            --radius:    10px;
            --font-head: 'DM Serif Display', Georgia, serif;
            --font-body: 'DM Sans', sans-serif;
            --shadow:    0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
        }
        .dark {
            --bg:      #111010;
            --surface: #1C1B1A;
            --border:  #2E2C2A;
            --text:    #F0EDE8;
            --muted:   #8A857C;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            transition: background .3s, color .3s;
        }

        /* ── Sidebar ─────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
        }
        .sidebar.closed { transform: translateX(calc(-1 * var(--sidebar-w))); }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo h1 {
            font-family: var(--font-head);
            font-size: 1.25rem;
            line-height: 1.2;
            color: var(--text);
        }
        .sidebar-logo span { color: var(--accent); }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }

        .nav-group-label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 16px 12px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius);
            color: var(--muted);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: background .15s, color .15s;
        }
        .nav-link:hover { background: var(--bg); color: var(--text); }
        .nav-link.active { background: var(--accent); color: #fff; }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border);
            font-size: .8rem;
            color: var(--muted);
        }

        /* ── Main ────────────────────────────── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: margin-left .3s cubic-bezier(.4,0,.2,1);
        }
        .main-wrap.expanded { margin-left: 0; }

        /* ── Topbar ──────────────────────────── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }

        .btn-icon {
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            background: var(--bg);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--muted);
            transition: background .15s, color .15s;
        }
        .btn-icon:hover { background: var(--border); color: var(--text); }
        .btn-icon svg { width: 15px; height: 15px; }

        .breadcrumb { font-size: .85rem; color: var(--muted); }
        .breadcrumb strong { color: var(--text); font-weight: 600; }

        .avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            font-size: .8rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }

        /* ── Page content ────────────────────── */
        .page-content { padding: 32px 28px; flex: 1; }

        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
        }
        .page-header h2 {
            font-family: var(--font-head);
            font-size: 1.75rem;
            font-weight: 400;
            line-height: 1;
        }
        .page-header p { color: var(--muted); font-size: .875rem; margin-top: 4px; }

        /* ── Cards ───────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .card-header {
            padding: 20px 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-title { font-family: var(--font-head); font-size: 1.1rem; font-weight: 400; }
        .card-body { padding: 20px 24px 24px; }

        /* ── Stat cards ──────────────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--accent);
        }
        .stat-card.blue::before  { background: var(--accent2); }
        .stat-card.green::before { background: var(--success); }
        .stat-card.gold::before  { background: var(--warning); }
        .stat-label { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
        .stat-value { font-family: var(--font-head); font-size: 2rem; margin-top: 6px; line-height: 1; }
        .stat-delta { font-size: .75rem; color: var(--success); margin-top: 6px; }
        .stat-delta.down { color: var(--accent); }

        /* ── Buttons ─────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius);
            font-family: var(--font-body);
            font-size: .875rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity .15s, transform .1s;
        }
        .btn:active { transform: scale(.98); }
        .btn-primary   { background: var(--accent);  color: #fff; }
        .btn-secondary { background: var(--surface); color: var(--text); border: 1px solid var(--border); }
        .btn-ghost     { background: transparent;    color: var(--muted); }
        .btn-success   { background: var(--success); color: #fff; }
        .btn-danger    { background: #dc2626; color: #fff; }
        .btn:hover     { opacity: .88; }
        .btn svg       { width: 15px; height: 15px; }

        /* ── Table ───────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        thead tr { border-bottom: 2px solid var(--border); }
        th {
            text-align: left;
            padding: 10px 16px;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--muted);
            white-space: nowrap;
        }
        td { padding: 13px 16px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: var(--bg); }

        /* ── Forms ───────────────────────────── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label {
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--muted);
        }
        input, select, textarea {
            width: 100%;
            padding: 10px 14px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: var(--font-body);
            font-size: .875rem;
            color: var(--text);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(200,75,47,.12);
        }
        textarea { resize: vertical; min-height: 100px; }
        .field-error { font-size: .78rem; color: var(--accent); margin-top: 2px; }

        /* ── Badges ──────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 99px;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .04em;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }
        .badge-info    { background: #dbeafe; color: #1e40af; }

        /* ── Alerts / Flash ──────────────────── */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius);
            font-size: .875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* ── Pagination ──────────────────────── */
        .pagination { display: flex; align-items: center; gap: 4px; margin-top: 20px; justify-content: flex-end; }
        .page-btn {
            min-width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 500;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
            text-decoration: none;
            transition: background .15s;
        }
        .page-btn:hover, .page-btn.active { background: var(--accent); color: #fff; border-color: var(--accent); }
        .page-btn.disabled { opacity: .4; pointer-events: none; }

        /* ── Responsive ──────────────────────── */
        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .form-grid  { grid-template-columns: 1fr; }
            .form-grid.cols-3 { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
            .page-content { padding: 20px 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ── Sidebar ───────────────────────────────── --}}
    <aside class="sidebar" :class="{ 'closed': !sidebarOpen }">
        <div class="sidebar-logo">
            <h1>Cadastro<br><span>&amp;</span> Controle</h1>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-group-label">Principal</div>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7m-9 5v6h4v-6m5 6h2a2 2 0 002-2v-7"/>
                </svg>
                Dashboard
            </a>

            <div class="nav-group-label">Cadastros</div>

            <a href="{{ route('cadastros.index') }}"
               class="nav-link {{ request()->routeIs('cadastros.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
                Clientes
            </a>

            <a href="{{ route('produtos.index') }}"
               class="nav-link {{ request()->routeIs('produtos.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Produtos
            </a>

            <div class="nav-group-label">Controle</div>

            <a href="{{ route('controles.index') }}"
               class="nav-link {{ request()->routeIs('controles.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Movimentações
            </a>

            <a href="{{ route('relatorios.index') }}"
               class="nav-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0120 9.414V19a2 2 0 01-2 2z"/>
                </svg>
                Relatórios
            </a>
        </nav>

        <div class="sidebar-footer">
            v1.0.0 &mdash; Sistema Interno
        </div>
    </aside>

    {{-- ── Main wrapper ───────────────────────────── --}}
    <div class="main-wrap" :class="{ 'expanded': !sidebarOpen }">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn-icon" @click="sidebarOpen = !sidebarOpen">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="breadcrumb">
                    {{ $breadcrumb ?? 'Dashboard' }} /
                    <strong>{{ $pageTitle ?? 'Início' }}</strong>
                </div>
            </div>
            <div class="topbar-right">
                <button class="btn-icon" @click="darkMode = !darkMode" title="Alternar tema">
                    <svg x-show="!darkMode" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="darkMode" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/>
                    </svg>
                </button>
                <div class="avatar" title="Usuário">AD</div>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
            <div style="padding: 0 28px; padding-top: 20px;">
                <div class="alert alert-success">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div style="padding: 0 28px; padding-top: 20px;">
                <div class="alert alert-error">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <main class="page-content">
            @yield('content')
        </main>
    </div>

</body>
</html>
