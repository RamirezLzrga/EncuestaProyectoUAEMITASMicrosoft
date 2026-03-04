<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIEI UAEMex - @yield('title', 'Panel Administrativo')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Nunito:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* ══════════════════════════════════════════
       VARS & RESET
    ══════════════════════════════════════════ */
    :root {
      --bg: #eef2ed;
      --bg-dark: #e4e9e2;
      --text: #3c4a3e;
      --text-dark: #1a261c;
      --text-muted: #6e7a70;
      --text-light: #9aa59c;

      --verde: #2d5016;
      --verde-pale: #7a8f6a;
      --oro: #9c8412;
      --oro-bright: #d4b733;
      --red: #c94c4c;
      --blue: #4c7cc9;

      /* Neumorphism Shadows */
      --neu-shadow-light: #ffffff;
      --neu-shadow-dark: #d1d9ce;

      --neu-out: 6px 6px 14px var(--neu-shadow-dark), -6px -6px 14px var(--neu-shadow-light);
      --neu-out-lg: 10px 10px 20px var(--neu-shadow-dark), -10px -10px 20px var(--neu-shadow-light);
      --neu-out-sm: 3px 3px 6px var(--neu-shadow-dark), -3px -3px 6px var(--neu-shadow-light);
      --neu-in: inset 4px 4px 10px var(--neu-shadow-dark), inset -4px -4px 10px var(--neu-shadow-light);
      --neu-in-sm: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light);
      --neu-press: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);

      --radius: 12px;
      --radius-lg: 20px;
      --radius-xl: 32px;
      --radius-sm: 8px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background: var(--bg);
      font-family: 'Nunito', sans-serif;
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    a { text-decoration: none; color: inherit; }
    button { border: none; outline: none; background: none; cursor: pointer; font-family: inherit; }

    /* ══════════════════════════════════════════
       TOP NAV
    ══════════════════════════════════════════ */
    .topnav {
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 40px;
      position: sticky;
      top: 0;
      z-index: 100;
      background: var(--bg);
      /* backdrop-filter: blur(10px); */ /* Opcional si fuera transparente */
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .brand-logo {
      width: 42px; height: 42px;
      border-radius: 10px;
      background: var(--bg);
      box-shadow: var(--neu-out);
      display: grid;
      place-items: center;
      color: var(--verde);
    }
    .brand-logo svg { width: 22px; height: 22px; fill: currentColor; }

    .brand-name {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 16px;
      color: var(--verde);
      line-height: 1;
    }
    .brand-sub {
      font-size: 11px;
      font-weight: 600;
      color: var(--oro);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 3px;
    }

    .nav-pills {
      display: flex;
      gap: 16px;
      background: var(--bg);
      padding: 6px;
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-in);
    }

    .nav-pill {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: var(--radius);
      font-size: 13.5px;
      font-weight: 700;
      color: var(--text-muted);
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
    }

    .nav-pill:hover {
      color: var(--text-dark);
    }

    .nav-pill.active {
      background: var(--bg);
      box-shadow: var(--neu-out-sm);
      color: var(--verde);
    }

    .nav-pill svg { width: 18px; height: 18px; }

    .nav-badge {
      position: absolute;
      top: 4px; right: 4px;
      width: 8px; height: 8px;
      background: var(--red);
      border-radius: 50%;
      border: 2px solid var(--bg);
      box-shadow: var(--neu-out-sm);
      font-size: 0;
    }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .status-chip {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      color: var(--text-muted);
      box-shadow: var(--neu-in-sm);
      font-family: 'JetBrains Mono', monospace;
    }

    .status-led {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: #00e676;
      box-shadow: 0 0 8px #00e676;
      animation: breathe 2s infinite ease-in-out;
    }

    @keyframes breathe {
      0%, 100% { opacity: .6; transform: scale(.9); }
      50% { opacity: 1; transform: scale(1.1); }
    }

    .avatar-btn {
      width: 44px; height: 44px;
      border-radius: 50%;
      background: var(--bg);
      box-shadow: var(--neu-out);
      display: grid;
      place-items: center;
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      color: var(--verde);
      font-size: 14px;
      cursor: pointer;
      transition: box-shadow 0.2s;
    }
    .avatar-btn:active { box-shadow: var(--neu-press); }

    /* ══════════════════════════════════════════
       MAIN LAYOUT
    ══════════════════════════════════════════ */
    .wrapper {
      max-width: 1300px;
      width: 100%;
      margin: 0 auto;
      padding: 20px 40px 60px;
      flex: 1;
      position: relative;
    }

    .page {
      display: none; /* JS Toggle */
      animation: fadeIn 0.4s ease;
    }
    .page.active { display: block; }

    /* Para Laravel, como no usamos JS toggle, siempre mostramos el contenido */
    /* .page { display: block; }  <- Ajuste para Blade */
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ══════════════════════════════════════════
       PAGE HEADERS
    ══════════════════════════════════════════ */
    .ph {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 32px;
    }

    .ph-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--oro);
      font-weight: 700;
      margin-bottom: 4px;
    }

    .ph-title {
      font-family: 'Sora', sans-serif;
      font-size: 32px;
      font-weight: 800;
      color: var(--text-dark);
      letter-spacing: -0.5px;
      line-height: 1.1;
    }

    .ph-sub {
      font-size: 14px;
      color: var(--text-muted);
      margin-top: 6px;
      font-weight: 500;
    }

    .ph-actions {
      display: flex;
      gap: 16px;
    }

    /* ══════════════════════════════════════════
       COMPONENTS: BUTTONS
    ══════════════════════════════════════════ */
    .btn {
      padding: 12px 24px;
      border-radius: var(--radius);
      font-family: 'Sora', sans-serif;
      font-size: 13.5px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-neu {
      background: var(--bg);
      color: var(--text-dark);
      box-shadow: var(--neu-out);
    }
    .btn-neu:hover { box-shadow: var(--neu-out-lg); transform: translateY(-2px); }
    .btn-neu:active { box-shadow: var(--neu-press); transform: translateY(0); }

    .btn-oro {
      background: var(--bg);
      color: var(--oro);
      box-shadow: var(--neu-out);
    }
    .btn-oro:hover { color: var(--oro-bright); box-shadow: var(--neu-out-lg); }

    .btn-solid {
      background: var(--verde);
      color: white;
      box-shadow: 6px 6px 16px rgba(45,80,22, 0.3), -6px -6px 16px rgba(255,255,255, 0.8);
    }
    .btn-solid:hover {
      background: #36611a;
      box-shadow: 8px 8px 20px rgba(45,80,22, 0.4), -8px -8px 20px rgba(255,255,255, 0.9);
      transform: translateY(-2px);
    }

    .btn-sm { padding: 8px 16px; font-size: 12px; border-radius: var(--radius-sm); }
    .btn-icon { padding: 8px; width: 34px; height: 34px; display: grid; place-items: center; }

    /* ══════════════════════════════════════════
       DASHBOARD GRID
    ══════════════════════════════════════════ */
    .dash-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      grid-template-rows: auto auto auto;
      gap: 24px;
    }

    /* KPI ROW (Full Width) */
    .kpi-row {
      grid-column: 1 / -1;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }

    .kpi-card {
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 24px 22px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      position: relative;
      overflow: hidden;
      transition: box-shadow .25s;
    }
    .kpi-card:hover { box-shadow: var(--neu-out-lg); }

    .kp-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .kp-icon {
      width: 40px; height: 40px;
      border-radius: 12px;
      background: var(--bg);
      box-shadow: var(--neu-out);
      display: grid;
      place-items: center;
      font-size: 18px;
    }

    .kp-change {
      font-size: 11px;
      font-family: 'JetBrains Mono', monospace;
      font-weight: 700;
      padding: 4px 8px;
      border-radius: 6px;
      box-shadow: var(--neu-in-sm);
    }
    .kp-up { color: var(--verde); background: rgba(45,80,22, 0.03); }
    .kp-down { color: var(--red); background: rgba(201,76,76, 0.03); }
    .kp-flat { color: var(--text-muted); }

    .kp-value { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 700; color: var(--text-dark); line-height: 1; }
    .kp-label { font-size: 13px; font-weight: 700; color: var(--text); }
    .kp-desc { font-size: 11px; color: var(--text-muted); }

    .kpi-card-bg {
      position: absolute;
      right: -10px; bottom: -10px;
      width: 80px; height: 80px;
      border-radius: 50%;
      opacity: 0.04;
      filter: blur(20px);
    }

    /* WELCOME BAND */
    .welcome-band {
      grid-column: 1 / 2;
      background: var(--verde);
      border-radius: var(--radius-lg);
      padding: 32px;
      color: white;
      position: relative;
      overflow: hidden;
      box-shadow: 8px 8px 20px rgba(45,80,22, 0.25), -8px -8px 20px rgba(255,255,255, 0.8);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .wb-circles {
      position: absolute;
      top: -50px; left: -50px;
      width: 200px; height: 200px;
      border-radius: 50%;
      border: 40px solid rgba(255,255,255, 0.03);
    }
    .wb-circles2 {
      position: absolute;
      bottom: -30px; right: 100px;
      width: 140px; height: 140px;
      border-radius: 50%;
      background: rgba(255,255,255, 0.04);
    }

    .wb-tag { font-family: 'JetBrains Mono', monospace; font-size: 10px; opacity: 0.7; margin-bottom: 8px; letter-spacing: 1px; }
    .wb-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 700; margin-bottom: 6px; }
    .wb-sub { font-size: 13px; opacity: 0.85; max-width: 400px; line-height: 1.5; }

    .wb-date {
      text-align: right;
      position: relative;
      z-index: 2;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .wb-date-day { font-family: 'Sora', sans-serif; font-size: 42px; font-weight: 800; line-height: 1; }
    .wb-date-rest { font-family: 'JetBrains Mono', monospace; font-size: 11px; text-align: left; opacity: 0.8; line-height: 1.4; }

    /* QUICK ACTIONS */
    .quick-actions {
      grid-column: 2 / 3;
      grid-row: 2 / 4; /* Span vertically */
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .qa-title { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 700; color: var(--text-dark); }
    
    .qa-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      flex: 1;
    }

    .qa-item {
      background: var(--bg);
      border-radius: var(--radius);
      box-shadow: var(--neu-out);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      transition: all 0.2s;
      text-align: center;
      padding: 16px;
    }
    .qa-item:hover { box-shadow: var(--neu-out-lg); transform: translateY(-2px); }
    .qa-item:active { box-shadow: var(--neu-press); transform: translateY(0); }

    .qa-emoji { font-size: 24px; }
    .qa-label { font-size: 11.5px; font-weight: 700; color: var(--text); }

    /* CHART CARD */
    .chart-card {
      grid-column: 1 / 2;
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 24px;
      min-height: 300px;
      display: flex;
      flex-direction: column;
    }

    .cc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 24px;
    }
    .cc-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700; color: var(--text-dark); }
    .cc-sub { font-size: 12px; color: var(--text-muted); margin-top: 4px; }

    .tab-group {
      display: flex;
      background: var(--bg);
      padding: 4px;
      border-radius: 10px;
      box-shadow: var(--neu-in);
    }
    .tg-tab {
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 700;
      color: var(--text-muted);
      cursor: pointer;
    }
    .tg-tab.active {
      background: var(--bg);
      box-shadow: var(--neu-out-sm);
      color: var(--verde);
    }

    .chart-body {
      flex: 1;
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      padding: 0 10px;
      gap: 12px;
    }

    .cb-bar-wrap {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      height: 100%;
      justify-content: flex-end;
    }

    .cb-bar {
      width: 100%;
      max-width: 24px;
      border-radius: 6px;
      box-shadow: var(--neu-out-sm);
      transition: height 1s ease;
      position: relative;
    }
    
    .cb-bar.verde { background: var(--verde); }
    .cb-bar.oro   { background: var(--oro); }

    .cb-month { font-family: 'JetBrains Mono', monospace; font-size: 10px; color: var(--text-muted); }

    /* ══════════════════════════════════════════
       SURVEYS PAGE
    ══════════════════════════════════════════ */
    .surveys-layout {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .filter-neu {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 12px 20px;
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
    }

    .fn-label { font-size: 12px; font-weight: 700; color: var(--text-muted); }

    .fn-input {
      background: var(--bg);
      border: none;
      border-radius: 8px;
      box-shadow: var(--neu-in-sm);
      padding: 8px 12px;
      font-family: 'Nunito', sans-serif;
      font-size: 13px;
      color: var(--text);
      outline: none;
    }
    .fn-input:focus { box-shadow: var(--neu-in-sm), 0 0 0 2px var(--verde-pale); }

    .fn-search {
      flex: 1;
      position: relative;
    }
    .fn-search input { width: 100%; padding-left: 36px; }
    .fn-search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); opacity: 0.5; font-size: 14px; }

    .surveys-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 24px;
    }

    .survey-card {
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 0;
      overflow: hidden;
      transition: box-shadow .2s;
      cursor: pointer;
    }
    .survey-card:hover { box-shadow: var(--neu-out-lg); }

    .sc-banner { height: 6px; width: 100%; }
    .sc-banner.activa { background: var(--verde); }
    .sc-banner.pendiente { background: var(--oro); }
    .sc-banner.cerrada { background: var(--text-muted); }

    .sc-body { padding: 20px 24px; display: flex; flex-direction: column; gap: 16px; }

    .sc-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .sc-name { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
    .sc-desc { font-size: 12px; color: var(--text-muted); }

    .badge-neu {
      font-size: 10px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 999px;
      box-shadow: var(--neu-out-sm);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .bn-green { color: var(--verde); }
    .bn-gold { color: var(--oro); }
    .bn-muted { color: var(--text-muted); }

    .sc-stats {
      display: flex;
      gap: 12px;
      padding: 12px 0;
      border-top: 1px dashed rgba(0,0,0,0.06);
      border-bottom: 1px dashed rgba(0,0,0,0.06);
    }
    .sc-stat { flex: 1; text-align: center; }
    .sc-stat-val { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700; color: var(--text-dark); }
    .sc-stat-label { font-size: 10px; font-family: 'JetBrains Mono', monospace; color: var(--text-light); margin-top: 2px; }

    .sc-author { display: flex; align-items: center; gap: 8px; font-size: 10.5px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
    .sc-avatar {
      width: 24px; height: 24px;
      border-radius: 50%;
      background: var(--verde);
      color: white;
      display: grid;
      place-items: center;
      font-size: 10px;
      box-shadow: var(--neu-out-sm);
    }

    .sc-actions { display: flex; gap: 10px; margin-top: 4px; }
    .sc-btn {
      flex: 1;
      padding: 8px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 700;
      background: var(--bg);
      box-shadow: var(--neu-out);
      color: var(--text);
      transition: all 0.2s;
    }
    .sc-btn:hover { box-shadow: var(--neu-out-lg); transform: translateY(-1px); }
    .sc-btn:active { box-shadow: var(--neu-press); }
    .sc-btn.del:hover { color: var(--red); }

    /* ══════════════════════════════════════════
       USERS PAGE
    ══════════════════════════════════════════ */
    .users-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }

    .user-card {
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 24px;
      text-align: center;
      transition: box-shadow .2s;
    }
    .user-card:hover { box-shadow: var(--neu-out-lg); }

    .uc-avatar {
      width: 64px; height: 64px;
      border-radius: 50%;
      margin: 0 auto 12px;
      display: grid;
      place-items: center;
      font-family: 'Sora', sans-serif;
      font-size: 22px;
      font-weight: 700;
      box-shadow: var(--neu-out-lg);
    }

    .uc-name { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 700; color: var(--text-dark); }
    .uc-email { font-size: 11.5px; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; margin-top: 3px; }

    .uc-tags {
      display: flex;
      gap: 6px;
      justify-content: center;
      margin: 12px 0;
      flex-wrap: wrap;
    }

    .uc-stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin: 14px 0;
    }

    .uc-stat {
      background: var(--bg);
      border-radius: var(--radius-sm);
      box-shadow: var(--neu-in-sm);
      padding: 10px 6px;
      text-align: center;
    }

    .uc-stat-val { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 700; color: var(--text-dark); }
    .uc-stat-label { font-size: 9.5px; font-family: 'JetBrains Mono', monospace; color: var(--text-light); text-transform: uppercase; margin-top: 2px; }

    .uc-actions { display: flex; gap: 8px; }

    /* ══════════════════════════════════════════
       APPROVALS PAGE
    ══════════════════════════════════════════ */
    .approvals-layout {
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 22px;
    }

    .approval-item-card {
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 24px;
      margin-bottom: 16px;
      transition: box-shadow .2s;
    }
    .approval-item-card:hover { box-shadow: var(--neu-out-lg); }

    .ai-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 8px; }
    .ai-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 700; color: var(--text-dark); }
    .ai-meta { font-size: 12px; font-family: 'JetBrains Mono', monospace; color: var(--text-muted); margin-bottom: 16px; }

    .ai-preview {
      background: var(--bg);
      border-radius: var(--radius);
      box-shadow: var(--neu-in);
      padding: 14px 16px;
      margin-bottom: 14px;
    }

    .aip-label { font-size: 10px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: .8px; color: var(--text-light); margin-bottom: 10px; }
    .aip-dates { font-size: 12px; font-family: 'JetBrains Mono', monospace; color: var(--text-muted); margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed rgba(0,0,0,.07); }
    .aip-q { display: flex; align-items: center; justify-content: space-between; font-size: 13px; color: var(--text); padding: 5px 0; }

    .ai-comment {
      width: 100%;
      background: var(--bg);
      box-shadow: var(--neu-in);
      border: none;
      border-radius: var(--radius);
      font-family: 'Nunito', sans-serif;
      font-size: 13.5px;
      color: var(--text);
      padding: 11px 15px;
      outline: none;
      margin-bottom: 14px;
      transition: box-shadow .2s;
      font-weight: 500;
    }
    .ai-comment:focus { box-shadow: var(--neu-in), 0 0 0 2px var(--verde-pale); }
    .ai-comment::placeholder { color: var(--text-light); font-weight: 400; }

    .ai-btns { display: flex; gap: 12px; }

    .hist-neu {
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      overflow: hidden;
      position: sticky;
      top: 100px;
    }

    .hn-head { padding: 20px 20px 0; }
    .hn-title { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 700; color: var(--text-dark); }

    .hn-tabs {
      display: flex;
      gap: 4px;
      padding: 14px 16px 0;
    }

    .hn-tab {
      flex: 1;
      text-align: center;
      padding: 8px 4px;
      border-radius: var(--radius-sm);
      font-size: 11.5px;
      font-weight: 700;
      color: var(--text-muted);
      cursor: pointer;
      transition: all .2s;
      background: var(--bg);
      box-shadow: var(--neu-out);
    }
    .hn-tab.active { background: var(--verde); color: white; box-shadow: 3px 3px 8px rgba(45,80,22,.3); }

    .hn-list { padding: 12px 16px; display: flex; flex-direction: column; gap: 8px; }

    .hn-item {
      background: var(--bg);
      border-radius: var(--radius);
      box-shadow: var(--neu-out);
      padding: 12px 13px;
      cursor: pointer;
      transition: box-shadow .2s;
    }
    .hn-item:hover { box-shadow: var(--neu-out-lg); }

    .hn-name { font-size: 12.5px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
    .hn-meta { font-size: 11px; font-family: 'JetBrains Mono', monospace; color: var(--text-muted); display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }

    /* ══════════════════════════════════════════
       STATS PAGE
    ══════════════════════════════════════════ */
    .stats-layout { display: flex; flex-direction: column; gap: 22px; }

    .stats-top {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 22px;
    }

    .gauge-card {
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 24px;
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .gauge-circle {
      width: 90px; height: 90px;
      border-radius: 50%;
      box-shadow: var(--neu-out-lg);
      display: grid;
      place-items: center;
      flex-shrink: 0;
      background: var(--bg);
    }

    .gauge-inner {
      width: 66px; height: 66px;
      border-radius: 50%;
      box-shadow: var(--neu-in);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .gauge-val { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 700; color: var(--text-dark); line-height: 1; }
    .gauge-unit { font-size: 9px; font-family: 'JetBrains Mono', monospace; color: var(--text-light); text-transform: uppercase; }

    .gauge-info {}
    .gauge-name { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
    .gauge-sub  { font-size: 12px; color: var(--text-muted); }

    .stats-bottom {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 22px;
    }

    .scatter-card {
      background: var(--bg);
      border-radius: var(--radius-lg);
      box-shadow: var(--neu-out);
      padding: 24px;
    }

    .sc-dots {
      height: 160px;
      position: relative;
      background: var(--bg);
      border-radius: var(--radius);
      box-shadow: var(--neu-in);
      margin-top: 16px;
      overflow: hidden;
    }

    /* ══════════════════════════════════════════
       SURVEYS GRID
    ══════════════════════════════════════════ */
    .surveys-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 24px;
    }

    .btn-icon-neu {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--bg);
      box-shadow: var(--neu-out-sm);
      display: flex; align-items: center; justify-content: center;
      color: var(--text-muted);
      transition: all .2s;
    }
    .btn-icon-neu:hover { color: var(--verde); box-shadow: var(--neu-out); transform: translateY(-1px); }
    .btn-icon-neu:active { box-shadow: var(--neu-in-sm); transform: translateY(0); }

    /* ══════════════════════════════════════════
       FORM — NEW USER / CREATE SURVEY
    ══════════════════════════════════════════ */
    .form-neu {
      max-width: 640px;
      margin: 0 auto;
    }

    .form-neu-card {
      background: var(--bg);
      border-radius: var(--radius-xl);
      box-shadow: var(--neu-out-lg);
      overflow: hidden;
    }

    .fnc-head {
      background: var(--verde);
      padding: 28px 32px;
      position: relative;
      overflow: hidden;
    }

    .fnc-head::after {
      content: '';
      position: absolute;
      top: -30px; right: -30px;
      width: 130px; height: 130px;
      border-radius: 50%;
      border: 30px solid rgba(255,255,255,.06);
    }

    .fnc-head-title {
      font-family: 'Sora', sans-serif;
      font-size: 20px;
      font-weight: 700;
      color: white;
    }

    .fnc-head-sub { font-size: 13px; color: rgba(255,255,255,.55); margin-top: 4px; }

    .fnc-body { padding: 32px; display: flex; flex-direction: column; gap: 20px; }

    .fg { display: flex; flex-direction: column; gap: 8px; }
    .fg-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .fg label {
      font-size: 11px;
      font-family: 'JetBrains Mono', monospace;
      text-transform: uppercase;
      letter-spacing: .6px;
      color: var(--text-muted);
      font-weight: 500;
    }

    .fg input, .fg select {
      background: var(--bg);
      box-shadow: var(--neu-in);
      border: none;
      border-radius: var(--radius);
      color: var(--text);
      font-family: 'Nunito', sans-serif;
      font-size: 14px;
      font-weight: 600;
      padding: 12px 16px;
      outline: none;
      transition: box-shadow .2s;
      width: 100%;
    }
    .fg input:focus, .fg select:focus { box-shadow: var(--neu-in), 0 0 0 2px var(--verde-pale); }
    .fg input::placeholder { color: var(--text-light); font-weight: 400; }
    
    select.fg-sel {
      appearance: none;
      cursor: pointer;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%237a8f6a' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 14px center;
    }

    .fnc-foot {
      padding: 20px 32px;
      background: var(--bg-dark);
      display: flex;
      gap: 12px;
      justify-content: flex-end;
    }

    /* ══════════════════════════════════════════
       SCROLLBAR
    ══════════════════════════════════════════ */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--bg-dark); }
    ::-webkit-scrollbar-thumb { background: var(--verde-pale); border-radius: 999px; }

  </style>
</head>
<body>

<!-- ════════════════ TOP NAV ════════════════ -->
<nav class="topnav">
  <div class="brand">
    <div class="brand-logo">
      <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
    </div>
    <div>
      <div class="brand-name">SIEI – UAEMex</div>
      <div class="brand-sub">Sistema Integral de Encuestas</div>
    </div>
  </div>

  <div class="nav-pills">
    <a href="{{ route('dashboard') }}" class="nav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
      Dashboard
    </a>
    <a href="{{ route('surveys.index') }}" class="nav-pill {{ request()->routeIs('surveys.*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Encuestas
    </a>
    <a href="{{ route('users.index') }}" class="nav-pill {{ request()->routeIs('users.*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
      Usuarios
    </a>
    <a href="{{ route('admin.aprobaciones') }}" class="nav-pill {{ request()->routeIs('admin.aprobaciones') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      Aprobaciones
      @if(\App\Models\Survey::where('approval_status', 'pending')->count() > 0)
      <span class="nav-badge">{{ \App\Models\Survey::where('approval_status', 'pending')->count() }}</span>
      @endif
    </a>
    <a href="{{ route('statistics.index') }}" class="nav-pill {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      Estadísticas
    </a>
    <a href="{{ route('activity-logs.index') }}" class="nav-pill {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h7"/></svg>
      Bitácora
    </a>
  </div>

  <div class="nav-right">
    <div class="status-chip">
      <div class="status-led"></div>
      Sistema operando
    </div>
    <form method="POST" action="{{ route('logout') }}" id="logout-form">
      @csrf
      <button type="submit" class="avatar-btn" title="Cerrar sesión">
        {{ substr(Auth::user()->name ?? 'AL', 0, 2) }}
      </button>
    </form>
  </div>
</nav>

<!-- ════════════════ WRAPPER ════════════════ -->
<div class="wrapper">
  @yield('content')
</div>

</body>
</html>
