<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <style>
        /* ── Variables del sistema UAEMex ── */
        :root {
            --verde:        #1a5c2a;
            --verde-oscuro: #12411d;
            --verde-claro:  #2a7b3d;
            --verde-menta:  #d4ead4;
            --oro:          #c9a227;
            --oro-claro:    #e4c56a;
            --crema:        #F9F6EF;
            --blanco:       #ffffff;
            --gris-texto:   #2a2a2a;
            --gris-suave:   #6b6b6b;
            --borde:        rgba(45,106,45,0.15);
            --sidebar-bg:   #0f1e10;
            --sidebar-w:    280px;
        }

        .bg-uaemex {
            background-color: var(--verde);
        }

        .text-uaemex {
            color: var(--verde);
        }

        .border-uaemex {
            border-color: var(--verde);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
            background-color: var(--crema);
            color: var(--gris-texto);
        }

        /* ── Fondo principal con patrón sutil ── */
        .main-bg {
            background-color: var(--crema);
            background-image:
                linear-gradient(rgba(45,106,45,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(45,106,45,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* ── Barra dorada superior ── */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--oro), var(--oro-claro), transparent);
            z-index: 999;
            pointer-events: none;
        }

        /* ══════════════════════════════
           SIDEBAR
        ══════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 30px rgba(0,0,0,0.25);
            z-index: 20;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        /* Textura de patrón del sidebar */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Brillo radial en el sidebar */
        .sidebar::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 200px;
            background: radial-gradient(ellipse at 50% 0%, rgba(45,106,45,0.3) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Logo del sidebar ── */
        .sidebar-logo {
            padding: 28px 24px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .logo-mark {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-claro));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 18px;
            color: var(--oro-claro);
            letter-spacing: -1px;
            box-shadow: 0 4px 16px rgba(45,106,45,0.5), 0 0 0 1px rgba(255,255,255,0.1);
            flex-shrink: 0;
        }

        .logo-text-wrap { line-height: 1; }
        .logo-siei {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--oro-claro);
            margin-bottom: 3px;
            opacity: 0.85;
        }
        .logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.2px;
        }

        /* ── Nav del sidebar ── */
        .sidebar-nav {
            flex: 1;
            padding: 20px 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
            position: relative;
            z-index: 1;
        }

        /* Scrollbar del sidebar */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

        /* ── Grupos de navegación ── */
        .nav-group {}

        .nav-group-toggle {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 4px 10px 10px;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
        }
        .nav-group-toggle .group-icon {
            font-size: 8px;
            transition: transform 0.2s;
            color: rgba(255,255,255,0.2);
        }
        .nav-group-toggle .group-icon.rotate-180 { transform: rotate(180deg); }

        .nav-items { display: flex; flex-direction: column; gap: 2px; }

        /* ── Nav item ── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.22s ease;
            border-left: 3px solid transparent;
            color: rgba(255,255,255,0.45);
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.9);
            border-left-color: rgba(255,255,255,0.1);
        }

        .nav-item.active {
            background: rgba(45,106,45,0.25);
            color: #fff;
            border-left-color: var(--oro);
            box-shadow: inset 0 0 0 1px rgba(45,106,45,0.2);
        }

        .nav-icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            transition: background 0.2s;
        }
        .nav-item.active .nav-icon-wrap {
            background: rgba(45,106,45,0.4);
            color: var(--oro-claro);
        }
        .nav-item:hover .nav-icon-wrap { background: rgba(255,255,255,0.1); }

        .nav-label-wrap { display: flex; flex-direction: column; }
        .nav-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            line-height: 1.2;
        }
        .nav-sublabel {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.3);
            margin-top: 2px;
        }
        .nav-item.active .nav-sublabel { color: rgba(255,255,255,0.45); }

        /* ── Sidebar footer (usuario) ── */
        .sidebar-footer {
            padding: 16px 20px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            position: relative;
            z-index: 1;
        }
        .sidebar-footer-inner {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-claro));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 13px;
            color: var(--oro-claro);
            flex-shrink: 0;
        }
        .sidebar-user-name {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }
        .sidebar-user-role {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--oro-claro);
            opacity: 0.7;
        }

        /* ══════════════════════════════
           MAIN AREA
        ══════════════════════════════ */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
        }

        /* ── Top header ── */
        .top-header {
            background: rgba(249,246,239,0.85);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--borde);
            padding: 14px 36px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        /* Línea dorada bajo el header */
        .top-header::after {
            content: '';
            position: absolute;
            bottom: 0; right: 0;
            width: 200px; height: 2px;
            background: linear-gradient(270deg, var(--oro), transparent);
        }

        /* ── Botones del header ── */
        .header-icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: var(--blanco);
            border: 1.5px solid var(--borde);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gris-suave);
            cursor: pointer;
            transition: all 0.22s ease;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            font-size: 15px;
        }
        .header-icon-btn:hover {
            border-color: var(--oro);
            color: var(--oro);
            box-shadow: 0 4px 14px rgba(201,168,76,0.2);
            transform: translateY(-1px);
        }
        .header-icon-btn:active { transform: scale(0.96); }

        /* Badge de notificaciones */
        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #ef4444;
            font-family: 'DM Mono', monospace;
            font-size: 8px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid var(--crema);
        }

        /* ── Dropdowns del header ── */
        .header-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            width: 300px;
            background: var(--sidebar-bg);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.08);
            overflow: hidden;
            z-index: 50;
            transform-origin: top right;
        }

        .dropdown-header {
            padding: 16px 20px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .dropdown-header-title {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
        }
        .dropdown-mark-all {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--verde-claro);
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.2s;
        }
        .dropdown-mark-all:hover { color: var(--verde-menta); }

        .dropdown-body {
            padding: 12px 16px;
            max-height: 260px;
            overflow-y: auto;
        }
        .dropdown-empty {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.25);
            text-align: center;
            padding: 16px 0;
        }

        .notif-item {
            width: 100%;
            text-align: left;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 10px;
            padding: 10px 12px;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 6px;
        }
        .notif-item:hover { background: rgba(255,255,255,0.08); }
        .notif-item-title {
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 2px;
        }
        .notif-item-msg {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
        }
        .notif-item-time {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            color: rgba(255,255,255,0.25);
            margin-top: 4px;
        }

        /* ── User dropdown ── */
        .user-dropdown-body {
            padding: 20px;
        }
        .user-info-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .user-avatar-lg {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-claro));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--oro-claro);
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(45,106,45,0.4);
        }
        .user-info-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.02em;
            margin-bottom: 4px;
        }
        .role-pill {
            display: inline-block;
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 100px;
            font-weight: 500;
        }
        .role-admin  { background: rgba(167,139,250,0.15); color: #c4b5fd; border: 1px solid rgba(167,139,250,0.2); }
        .role-editor { background: rgba(96,165,250,0.15);  color: #93c5fd; border: 1px solid rgba(96,165,250,0.2); }
        .role-user   { background: rgba(156,163,175,0.15); color: #d1d5db; border: 1px solid rgba(156,163,175,0.2); }

        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: rgba(239,68,68,0.08);
            color: #fca5a5;
            border: 1px solid rgba(239,68,68,0.15);
            border-radius: 10px;
            padding: 12px;
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.22s ease;
            font-weight: 500;
        }
        .btn-logout:hover {
            background: rgba(239,68,68,0.15);
            color: #fecaca;
            border-color: rgba(239,68,68,0.3);
            transform: translateY(-1px);
        }
        .btn-logout i { transition: transform 0.2s; }
        .btn-logout:hover i { transform: translateX(-3px); }

        /* ── Contenido principal ── */
        .page-content {
            padding: 32px 36px;
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
        }

        .dashboard-wrap {
            font-family: 'DM Sans', sans-serif;
            color: var(--gris-texto);
        }

        .dash-header {
            background: var(--blanco);
            border-radius: 20px;
            border: 1px solid var(--borde);
            padding: 28px 32px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: 0 2px 16px rgba(45,106,45,0.06);
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .dash-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .dash-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 180px;
            height: 3px;
            background: linear-gradient(90deg, var(--oro), var(--oro-claro), transparent);
            border-radius: 0 2px 2px 0;
        }

        .dash-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--verde-claro);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dash-eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--oro);
            border-radius: 1px;
        }

        .dash-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 900;
            color: var(--verde-oscuro);
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .dash-subtitle {
            font-size: 13px;
            color: var(--gris-suave);
            font-weight: 300;
        }

        .dash-subtitle strong {
            font-weight: 600;
            color: var(--gris-texto);
        }

        .btn-nueva-encuesta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 26px;
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde) 100%);
            color: var(--blanco);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 6px 22px rgba(45,106,45,0.38);
            transition: all 0.25s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-nueva-encuesta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(45,106,45,0.5);
        }

        /* ── Dark mode ── */
        .dark-mode {
            background-color: #060d07;
            color: #e5e7eb;
        }
        .dark-mode .main-bg {
            background-color: #060d07;
            background-image:
                linear-gradient(rgba(45,106,45,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(45,106,45,0.05) 1px, transparent 1px);
        }
        .dark-mode .top-header {
            background: rgba(6,13,7,0.85);
            border-color: rgba(45,106,45,0.2);
        }
        .dark-mode .header-icon-btn {
            background: rgba(255,255,255,0.05);
            border-color: rgba(45,106,45,0.2);
            color: rgba(255,255,255,0.5);
        }

        /* Scrollbar global */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(45,106,45,0.25); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(45,106,45,0.4); }
    </style>
    @stack('styles')
</head>

@php
    $systemConfig = \App\Models\SystemConfig::first();
    $darkModeEnabled = $systemConfig && !empty($systemConfig->general['dark_mode']);
@endphp

<body class="{{ $darkModeEnabled ? 'dark-mode' : '' }}">

    <!-- ════════════════════════════
         SIDEBAR
    ════════════════════════════ -->
    <aside class="sidebar">

        <!-- Logo -->
        <div class="sidebar-logo">
            <div class="logo-mark">
                <div style="background:#fff;border-radius:10px;margin:4px;width:calc(100% - 8px);height:calc(100% - 8px);display:flex;align-items:center;justify-content:center;box-shadow:inset 0 0 0 1px rgba(0,0,0,0.04);">
                    <img src="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y" alt="UAEMex Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius:8px;">
                </div>
            </div>
            <div class="logo-text-wrap">
                <div class="logo-siei">SIEI</div>
                <div class="logo-name">UAEMex</div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="sidebar-nav">

            <!-- Principal -->
            <div class="nav-group">
                <button type="button" class="nav-group-toggle group-toggle" data-target="group-principal">
                    <span>Principal</span>
                    <i class="fas fa-chevron-down group-icon"></i>
                </button>
                <div id="group-principal" class="nav-items">
                    <a href="{{ route('dashboard') }}"
                       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <div class="nav-icon-wrap">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Dashboard</span>
                            <span class="nav-sublabel">Resumen general</span>
                        </div>
                    </a>
                    <a href="{{ route('surveys.index') }}"
                       class="nav-item {{ request()->routeIs('surveys.*') ? 'active' : '' }}">
                        <div class="nav-icon-wrap">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Encuestas</span>
                            <span class="nav-sublabel">Crear y gestionar</span>
                        </div>
                    </a>
                    <a href="{{ route('statistics.index') }}"
                       class="nav-item {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
                        <div class="nav-icon-wrap">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Estadísticas</span>
                            <span class="nav-sublabel">Resultados agregados</span>
                        </div>
                    </a>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
            <!-- Administración -->
            <div class="nav-group">
                <button type="button" class="nav-group-toggle group-toggle" data-target="group-admin">
                    <span>Administración</span>
                    <i class="fas fa-chevron-down group-icon"></i>
                </button>
                <div id="group-admin" class="nav-items">
                    <a href="{{ route('users.index') }}"
                       class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <div class="nav-icon-wrap"><i class="fas fa-users"></i></div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Usuarios</span>
                            <span class="nav-sublabel">Control de accesos</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.aprobaciones') }}"
                       class="nav-item {{ request()->routeIs('admin.aprobaciones') ? 'active' : '' }}">
                        <div class="nav-icon-wrap"><i class="fas fa-check-square"></i></div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Aprobaciones</span>
                            <span class="nav-sublabel">Revisión de encuestas</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.reportes') }}"
                       class="nav-item {{ request()->routeIs('admin.reportes') ? 'active' : '' }}">
                        <div class="nav-icon-wrap"><i class="fas fa-file-alt"></i></div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Reportes</span>
                            <span class="nav-sublabel">Informes globales</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.monitor') }}"
                       class="nav-item {{ request()->routeIs('admin.monitor') ? 'active' : '' }}">
                        <div class="nav-icon-wrap"><i class="fas fa-heartbeat"></i></div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Monitor</span>
                            <span class="nav-sublabel">Actividad en tiempo real</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Configuración -->
            <div class="nav-group">
                <button type="button" class="nav-group-toggle group-toggle" data-target="group-settings">
                    <span>Configuración</span>
                    <i class="fas fa-chevron-down group-icon"></i>
                </button>
                <div id="group-settings" class="nav-items">
                    <a href="{{ route('admin.configuracion') }}"
                       class="nav-item {{ request()->routeIs('admin.configuracion') ? 'active' : '' }}">
                        <div class="nav-icon-wrap"><i class="fas fa-cog"></i></div>
                        <div class="nav-label-wrap">
                            <span class="nav-label">Sistema</span>
                            <span class="nav-sublabel">Preferencias globales</span>
                        </div>
                    </a>
                </div>
            </div>
            @endif

        </nav>

        <!-- Sidebar footer con usuario -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-inner">
                <div class="sidebar-avatar">
                    @php $avatarUrl = Auth::user()->avatar_url ?? null; @endphp
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="Foto de perfil" style="width:100%;height:100%;border-radius:999px;object-fit:cover;">
                    @else
                        {{ substr(Auth::user()->name, 0, 2) }}
                    @endif
                </div>
                <div style="min-width:0;">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">
                        @switch(Auth::user()->role)
                            @case('admin') Administrador @break
                            @case('editor') Editor @break
                            @default Usuario
                        @endswitch
                    </div>
                </div>
            </div>
        </div>

    </aside>

    <!-- ════════════════════════════
         ÁREA PRINCIPAL
    ════════════════════════════ -->
    <main class="main-area main-bg">

        <!-- Top Header -->
        <header class="top-header">

            <!-- Notificaciones -->
            <div style="position:relative;">
                <button id="notificationsBtn" class="header-icon-btn">
                    <i class="fas fa-bell"></i>
                    <span id="notificationsBadge" class="notif-badge hidden"></span>
                </button>

                <div id="notificationsDropdown" class="header-dropdown hidden">
                    <div class="dropdown-header">
                        <span class="dropdown-header-title">Notificaciones</span>
                        <button id="notificationsMarkAll" class="dropdown-mark-all">Marcar todas</button>
                    </div>
                    <div class="dropdown-body">
                        <div id="notificationsList">
                            <div class="dropdown-empty">No tienes notificaciones nuevas.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuario -->
            <div style="position:relative;">
                <button id="userMenuBtn" class="header-icon-btn">
                    <i class="fas fa-user"></i>
                </button>

                <div id="userMenuDropdown" class="header-dropdown hidden">
                    <div class="user-dropdown-body">
                        <div class="user-info-row">
                            <div class="user-avatar-lg">
                                @php $avatarUrl = Auth::user()->avatar_url ?? null; @endphp
                                @if($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="Foto de perfil" style="width:100%;height:100%;border-radius:999px;object-fit:cover;">
                                @else
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                @endif
                            </div>
                            <div style="min-width:0;">
                                <div class="user-info-name">{{ Auth::user()->name }}</div>
                                <span class="role-pill
                                    @if(Auth::user()->role === 'admin') role-admin
                                    @elseif(Auth::user()->role === 'editor') role-editor
                                    @else role-user @endif">
                                    @switch(Auth::user()->role)
                                        @case('admin') Administrador @break
                                        @case('editor') Editor @break
                                        @default Usuario
                                    @endswitch
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('profile.show') }}" class="btn-logout" style="justify-content:flex-start;margin-bottom:0.5rem;">
                            <i class="fas fa-user-cog"></i>
                            Mi perfil
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </header>

        <!-- Contenido de la página -->
        <div class="page-content">
            @yield('content')
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Toggle grupos del sidebar ──
            document.querySelectorAll('.group-toggle').forEach(function (btn) {
                const targetId = btn.getAttribute('data-target');
                const target   = document.getElementById(targetId);
                const icon     = btn.querySelector('.group-icon');
                if (target && icon) {
                    btn.addEventListener('click', function () {
                        target.classList.toggle('hidden');
                        icon.classList.toggle('rotate-180');
                    });
                }
            });

            // ── User menu dropdown ──
            const userMenuBtn      = document.getElementById('userMenuBtn');
            const userMenuDropdown = document.getElementById('userMenuDropdown');
            if (userMenuBtn && userMenuDropdown) {
                userMenuBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    userMenuDropdown.classList.toggle('hidden');
                    notificationsDropdown.classList.add('hidden');
                });
                document.addEventListener('click', function (e) {
                    if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                        userMenuDropdown.classList.add('hidden');
                    }
                });
            }

            // ── Notifications dropdown ──
            const notificationsBtn      = document.getElementById('notificationsBtn');
            const notificationsDropdown = document.getElementById('notificationsDropdown');
            const notificationsBadge    = document.getElementById('notificationsBadge');
            const notificationsList     = document.getElementById('notificationsList');
            const notificationsMarkAll  = document.getElementById('notificationsMarkAll');

            if (notificationsBtn && notificationsDropdown) {
                notificationsBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    notificationsDropdown.classList.toggle('hidden');
                    userMenuDropdown.classList.add('hidden');
                });
                document.addEventListener('click', function (e) {
                    if (!notificationsBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                        notificationsDropdown.classList.add('hidden');
                    }
                });
            }

            function renderNotifications(data) {
                if (!notificationsList || !notificationsBadge) return;
                notificationsList.innerHTML = '';

                if (!data.items || data.items.length === 0) {
                    notificationsList.innerHTML = '<div class="dropdown-empty">No tienes notificaciones nuevas.</div>';
                } else {
                    data.items.forEach(function (item) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'notif-item';
                        btn.innerHTML = `
                            <div class="notif-item-title">${item.title}</div>
                            <div class="notif-item-msg">${item.message}</div>
                            <div class="notif-item-time">${item.created_at}</div>
                        `;
                        if (item.url) btn.addEventListener('click', () => window.location.href = item.url);
                        notificationsList.appendChild(btn);
                    });
                }

                if (data.count && data.count > 0) {
                    notificationsBadge.classList.remove('hidden');
                    notificationsBadge.textContent = data.count > 9 ? '9+' : data.count;
                } else {
                    notificationsBadge.classList.add('hidden');
                }
            }

            function fetchNotifications() {
                if (!notificationsList) return;
                fetch("{{ route('notifications.unread') }}", {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(data => renderNotifications(data))
                .catch(() => {});
            }

            if (notificationsMarkAll) {
                notificationsMarkAll.addEventListener('click', function (e) {
                    e.preventDefault();
                    fetch("{{ route('notifications.markAllRead') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(r => r.json())
                    .then(() => fetchNotifications())
                    .catch(() => {});
                });
            }

            fetchNotifications();
            setInterval(fetchNotifications, 15000);
        });
    </script>

    @stack('scripts')
</body>
</html>
