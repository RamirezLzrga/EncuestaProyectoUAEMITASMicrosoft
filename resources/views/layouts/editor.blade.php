<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIEI – UAEMex · Editor</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&family=Sora:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
  --bg:          #e8ede2;
  --bg-dark:     #dde3d6;
  --bg-light:    #f3f7ee;
  --neu-dark:    #c4c9be;
  --neu-light:   #ffffff;
  --verde:       #2D5016;
  --verde-mid:   #3a6b1c;
  --verde-pale:  #c8dbb8;
  --verde-xpale: #ddebd0;
  --oro:         #C99A0A;
  --oro-pale:    #f5e6a3;
  --oro-bright:  #e0ae12;
  --text-dark:   #1e2d14;
  --text:        #3a4a2c;
  --text-muted:  #7a8f6a;
  --text-light:  #a5b896;
  --red:         #c0392b;
  --red-pale:    #fde8e6;
  --green:       #1e7e34;
  --green-pale:  #e2f4e7;
  --blue:        #1a5299;
  --blue-pale:   #ddeaf8;
  --radius-sm:   8px;
  --radius:      16px;
  --radius-lg:   24px;
  --radius-xl:   32px;
  --neu-out:    6px 6px 14px var(--neu-dark), -6px -6px 14px var(--neu-light);
  --neu-out-lg: 10px 10px 24px var(--neu-dark), -10px -10px 24px var(--neu-light);
  --neu-in:     inset 4px 4px 10px var(--neu-dark), inset -4px -4px 10px var(--neu-light);
  --neu-in-sm:  inset 2px 2px 6px var(--neu-dark), inset -2px -2px 6px var(--neu-light);
  --neu-press:  inset 5px 5px 12px var(--neu-dark), inset -5px -5px 12px var(--neu-light);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Nunito', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; -webkit-font-smoothing: antialiased; }

/* ── TOP NAV ── */
.topnav {
  position: fixed; top: 0; left: 0; right: 0; z-index: 200;
  background: var(--bg); padding: 0 36px; height: 68px;
  display: flex; align-items: center; gap: 0;
  box-shadow: 0 4px 20px rgba(0,0,0,.08);
}
.brand { display: flex; align-items: center; gap: 14px; margin-right: 40px; flex-shrink: 0; }
.brand-logo {
  width: 42px; height: 42px; border-radius: 14px; background: var(--verde);
  display: grid; place-items: center; box-shadow: var(--neu-out); flex-shrink: 0;
}
.brand-logo svg { width: 22px; height: 22px; fill: var(--oro-bright); }
.brand-name { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 700; color: var(--verde); letter-spacing: -.3px; line-height: 1.1; }
.brand-sub  { font-size: 10.5px; color: var(--text-muted); font-weight: 400; margin-top: 1px; }

.nav-pills {
  display: flex; align-items: center; gap: 4px; flex: 1;
  background: var(--bg); border-radius: 999px; padding: 5px;
  box-shadow: var(--neu-in-sm); max-width: 480px;
}
.nav-pill {
  display: flex; align-items: center; gap: 7px; padding: 8px 16px;
  border-radius: 999px; font-size: 13px; font-weight: 600;
  color: var(--text-muted); cursor: pointer; transition: all .2s;
  white-space: nowrap; user-select: none; text-decoration: none;
}
.nav-pill:hover { color: var(--verde); }
.nav-pill.active {
  background: var(--verde); color: white;
  box-shadow: 4px 4px 10px rgba(45,80,22,.35), -2px -2px 6px rgba(255,255,255,.2);
}
.nav-pill svg { width: 7px; height: 15px; flex-shrink: 0; }
.nav-right { margin-left: auto; display: flex; align-items: center; gap: 14px; }
.role-chip {
  padding: 6px 14px; border-radius: 999px; background: var(--bg);
  box-shadow: var(--neu-out); font-size: 11.5px; font-weight: 700;
  color: var(--oro); font-family: 'JetBrains Mono', monospace; letter-spacing: .5px;
}
.status-chip {
  display: flex; align-items: center; gap: 7px; padding: 7px 16px;
  border-radius: 999px; background: var(--bg); box-shadow: var(--neu-out);
  font-size: 12px; font-weight: 600; color: var(--text-muted);
}
.status-led { width: 7px; height: 7px; border-radius: 50%; background: #4caf50; box-shadow: 0 0 6px #4caf5099; animation: breathe 2.5s infinite; }
@keyframes breathe { 0%,100%{ box-shadow: 0 0 6px #4caf5099; } 50%{ box-shadow: 0 0 12px #4caf50cc; } }
.avatar-btn {
  width: 42px; height: 42px; border-radius: 50%; background: var(--verde);
  color: var(--oro-bright); font-family: 'Sora', sans-serif; font-weight: 700;
  font-size: 14px; display: grid; place-items: center; cursor: pointer;
  box-shadow: var(--neu-out); transition: box-shadow .2s; flex-shrink: 0;
  border: 3px solid var(--bg); outline: 3px solid var(--verde-pale);
}
.avatar-btn:hover { box-shadow: var(--neu-out-lg); }
.notif-btn {
  width: 42px; height: 42px; border-radius: 50%; background: var(--bg);
  display: grid; place-items: center; cursor: pointer; box-shadow: var(--neu-out);
  font-size: 18px; transition: box-shadow .2s; position: relative;
}
.notif-btn:hover { box-shadow: var(--neu-out-lg); }
.notif-dot {
  position: absolute; top: 8px; right: 9px;
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--oro-bright); border: 2px solid var(--bg);
  display: none;
}
.notif-wrapper { position: relative; }
.notif-dropdown {
    position: absolute; top: 55px; right: -10px; width: 320px;
    background: var(--bg); border-radius: var(--radius);
    box-shadow: var(--neu-out-lg); padding: 16px; z-index: 1000;
    display: none; border: 1px solid rgba(255,255,255,0.4);
    opacity: 0; transform: translateY(-10px); transition: all 0.2s ease;
}
.notif-dropdown.show { display: block; opacity: 1; transform: translateY(0); }
.nd-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 13px; font-weight: 700; color: var(--text-dark); }
.nd-mark-read { background: none; border: none; color: var(--verde); font-size: 11px; cursor: pointer; text-decoration: underline; font-family: 'Nunito', sans-serif; }
.nd-list { max-height: 300px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px; }
.nd-item {
    background: var(--bg-light); border-radius: var(--radius-sm); padding: 10px;
    font-size: 12px; color: var(--text); box-shadow: var(--neu-in-sm);
    cursor: pointer; transition: background 0.2s; text-decoration: none; display: block;
}
.nd-item:hover { background: white; }
.nd-title { font-weight: 700; color: var(--verde); margin-bottom: 2px; }
.nd-time { font-size: 10px; color: var(--text-muted); margin-top: 4px; text-align: right; }
.nd-empty { text-align: center; padding: 20px; color: var(--text-muted); font-size: 12px; }

/* ── WRAPPER ── */
.wrapper { padding: 90px 36px 60px; max-width: 1300px; margin: 0 auto; }
.page { display: none; animation: fadeIn .3s ease; }
.page.active { display: block; }
@keyframes fadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }

/* ── PAGE HEADER ── */
.ph { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 32px; }
.ph-label { font-size: 11px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: 1.4px; color: var(--oro); font-weight: 500; margin-bottom: 5px; }
.ph-title { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 700; color: var(--text-dark); letter-spacing: -.5px; line-height: 1.1; }
.ph-sub   { font-size: 13px; color: var(--text-muted); margin-top: 5px; }
.ph-actions { display: flex; gap: 12px; align-items: center; }

/* ── BUTTONS ── */
.btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 11px 22px; border-radius: 999px; font-size: 13.5px; font-weight: 700;
  font-family: 'Nunito', sans-serif; cursor: pointer; transition: all .2s;
  border: none; text-decoration: none; user-select: none;
}
.btn-neu { background: var(--bg); color: var(--text); box-shadow: var(--neu-out); }
.btn-neu:hover { box-shadow: var(--neu-out-lg); }
.btn-neu:active { box-shadow: var(--neu-press); }
.btn-solid { background: var(--verde); color: white; box-shadow: 5px 5px 14px rgba(45,80,22,.4), -3px -3px 8px rgba(255,255,255,.3); }
.btn-solid:hover { background: var(--verde-mid); }
.btn-oro { background: var(--oro-bright); color: var(--verde); box-shadow: 5px 5px 14px rgba(201,154,10,.35), -3px -3px 8px rgba(255,255,255,.4); }
.btn-oro:hover { background: var(--oro); color: white; }
.btn-sm { padding: 8px 16px; font-size: 12.5px; }
.btn-danger { background: var(--bg); color: var(--red); box-shadow: var(--neu-out); }
.btn-danger:hover { box-shadow: var(--neu-out-lg); }

/* ── NEU BASE ── */
.nc { background: var(--bg); border-radius: var(--radius-lg); box-shadow: var(--neu-out); padding: 24px; }
.nc-inset { background: var(--bg); border-radius: var(--radius); box-shadow: var(--neu-in); padding: 16px; }

/* ── BADGES ── */
.badge-neu {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 4px 11px; border-radius: 999px; font-size: 11px;
  font-weight: 700; box-shadow: var(--neu-out); white-space: nowrap;
}
.bn-green { color: var(--green); } .bn-gold { color: var(--oro); }
.bn-muted { color: var(--text-muted); } .bn-blue { color: var(--blue); }
.bn-red   { color: var(--red); }

/* ═══════════════════════════════════
   DASHBOARD — MI ESPACIO
═══════════════════════════════════ */
.dash-grid { display: grid; grid-template-columns: repeat(12,1fr); gap: 22px; }

/* Welcome banner */
.welcome-editor {
  grid-column: 1 / -1;
  background: var(--verde);
  border-radius: var(--radius-lg);
  padding: 26px 32px;
  box-shadow: 8px 8px 20px rgba(45,80,22,.35), -4px -4px 12px rgba(255,255,255,.25);
  display: flex; align-items: center; justify-content: space-between;
  overflow: hidden; position: relative;
}
.we-circle1 { position:absolute; top:-30px; right:-30px; width:180px; height:180px; border-radius:50%; border:40px solid rgba(255,255,255,.04); }
.we-circle2 { position:absolute; bottom:-40px; right:80px; width:120px; height:120px; border-radius:50%; border:28px solid rgba(255,255,255,.03); }
.we-tag   { font-size:10.5px; font-family:'JetBrains Mono',monospace; text-transform:uppercase; letter-spacing:1.2px; color:var(--oro-pale); opacity:.8; margin-bottom:8px; }
.we-title { font-family:'Sora',sans-serif; font-size:20px; font-weight:700; color:white; margin-bottom:6px; }
.we-sub   { font-size:13px; color:rgba(255,255,255,.6); max-width:320px; }
.we-right { display:flex; flex-direction:column; align-items:flex-end; gap:6px; flex-shrink:0; }
.we-day   { font-family:'Sora',sans-serif; font-size:52px; font-weight:700; color:var(--oro-bright); letter-spacing:-2px; line-height:1; }
.we-date  { font-size:12px; color:rgba(255,255,255,.5); font-family:'JetBrains Mono',monospace; text-align:right; }

/* KPIs */
.kpi-row { grid-column:1/-1; display:grid; grid-template-columns:repeat(3,1fr); gap:22px; }
.kpi-card {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:22px; display:flex; flex-direction:column; gap:12px;
  position:relative; overflow:hidden; transition:box-shadow .25s;
}
.kpi-card:hover { box-shadow:var(--neu-out-lg); }
.kpi-card-bg { position:absolute; bottom:-14px; right:-14px; width:80px; height:80px; border-radius:50%; opacity:.1; }
.kp-top { display:flex; align-items:center; justify-content:space-between; }
.kp-icon { width:44px; height:44px; border-radius:14px; display:grid; place-items:center; font-size:20px; box-shadow:var(--neu-out); }
.kp-change { display:flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; padding:4px 10px; border-radius:999px; font-family:'JetBrains Mono',monospace; }
.kp-up   { background:var(--green-pale); color:var(--green); }
.kp-flat { background:var(--bg-dark);    color:var(--text-muted); }
.kp-down { background:var(--red-pale);   color:var(--red); }
.kp-value { font-family:'Sora',sans-serif; font-size:40px; font-weight:700; color:var(--text-dark); letter-spacing:-1.5px; line-height:1; }
.kp-label { font-size:11.5px; font-family:'JetBrains Mono',monospace; text-transform:uppercase; letter-spacing:.8px; color:var(--text-light); font-weight:500; }
.kp-desc  { font-size:12.5px; color:var(--text-muted); margin-top:-4px; }

/* Quick actions */
.quick-actions { grid-column:1/5; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.qa-title { font-family:'Sora',sans-serif; font-size:13px; font-weight:700; color:var(--text); margin-bottom:16px; }
.qa-grid  { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.qa-item  {
  background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-out);
  padding:14px; display:flex; flex-direction:column; align-items:center; gap:8px;
  cursor:pointer; transition:box-shadow .2s; text-align:center;
  text-decoration: none;
}
.qa-item:hover  { box-shadow:var(--neu-out-lg); }
.qa-item:active { box-shadow:var(--neu-press); }
.qa-emoji { font-size:22px; }
.qa-label { font-size:11.5px; font-weight:700; color:var(--text); }

/* Mis encuestas recientes card */
.recent-surveys { grid-column:5/-1; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.rs-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.rs-title  { font-family:'Sora',sans-serif; font-size:15px; font-weight:700; color:var(--text-dark); }
.rs-link   { font-size:12.5px; font-weight:700; color:var(--verde); cursor:pointer; text-decoration:none; }
.rs-link:hover { text-decoration:underline; }
.rs-empty  { text-align:center; padding:32px 0; color:var(--text-muted); font-size:13px; }
.rs-empty-icon { font-size:36px; margin-bottom:10px; opacity:.4; }

.rc-item {
  background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-out);
  padding:13px 15px; margin-bottom:10px; transition:box-shadow .2s; cursor:pointer;
  text-decoration: none; display: block;
}
.rc-item:hover { box-shadow:var(--neu-out-lg); }
.rc-top  { display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; }
.rc-name { font-size:13px; font-weight:700; color:var(--text-dark); }
.rc-bar-wrap { display:flex; align-items:center; gap:8px; }
.rc-mini-bar { flex:1; height:5px; border-radius:999px; box-shadow:var(--neu-in-sm); overflow:hidden; }
.rc-mini-fill { height:100%; border-radius:999px; background:linear-gradient(90deg,var(--verde),var(--verde-pale)); }
.rc-num  { font-size:11px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); white-space:nowrap; }

/* Performance chart */
.perf-card {
  grid-column:1/-1; background:var(--bg); border-radius:var(--radius-lg);
  box-shadow:var(--neu-out); padding:24px;
}
.cc-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.cc-title  { font-family:'Sora',sans-serif; font-size:15px; font-weight:700; color:var(--text-dark); }
.cc-sub    { font-size:12px; color:var(--text-muted); margin-top:2px; }
.tab-group { display:flex; gap:4px; background:var(--bg); box-shadow:var(--neu-in-sm); border-radius:999px; padding:4px; }
.tg-tab    { padding:5px 14px; border-radius:999px; font-size:11.5px; font-weight:700; color:var(--text-muted); cursor:pointer; transition:all .2s; font-family:'JetBrains Mono',monospace; }
.tg-tab.active { background:var(--verde); color:white; box-shadow:3px 3px 8px rgba(45,80,22,.3),-1px -1px 4px rgba(255,255,255,.2); }

.chart-bars { height:150px; display:flex; align-items:flex-end; gap:10px; padding:0 4px; }
.cb-wrap    { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end; }
.cb-bar     { width:100%; border-radius:8px 8px 4px 4px; box-shadow:inset -2px -2px 5px rgba(255,255,255,.4),inset 2px 2px 5px rgba(0,0,0,.08); cursor:pointer; transition:opacity .15s; min-height:6px; }
.cb-bar:hover { opacity:.8; }
.cb-bar.verde { background:linear-gradient(180deg,var(--verde-mid),var(--verde)); }
.cb-bar.oro   { background:linear-gradient(180deg,var(--oro-bright),var(--oro)); }
.cb-month  { font-size:9.5px; font-family:'JetBrains Mono',monospace; color:var(--text-light); text-transform:uppercase; letter-spacing:.5px; }

/* scrollbar */
::-webkit-scrollbar { width:5px; }
::-webkit-scrollbar-track { background:var(--bg-dark); }
::-webkit-scrollbar-thumb { background:var(--verde-pale); border-radius:999px; }

/* Otros estilos para secciones extra que se requieran en el futuro */
.surveys-layout { display:flex; flex-direction:column; gap:22px; }
.filter-neu {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:18px 24px; display:flex; gap:14px; align-items:center; flex-wrap:wrap;
}
.fn-label { font-size:11.5px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); white-space:nowrap; }
.fn-input {
  background:var(--bg); box-shadow:var(--neu-in-sm); border:none; border-radius:999px;
  color:var(--text); font-family:'Nunito',sans-serif; font-size:13px; font-weight:600;
  padding:8px 16px; outline:none; transition:box-shadow .2s;
}
.fn-input:focus { box-shadow:var(--neu-in); }
.fn-input::placeholder { color:var(--text-light); font-weight:400; }
select.fn-input { cursor:pointer; appearance:none; padding-right:30px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%237a8f6a' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; }
.fn-search { flex:1; position:relative; min-width:200px; }
.fn-search-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:13px; color:var(--text-light); pointer-events:none; }
.fn-search input { width:100%; padding-left:36px; }

.surveys-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
.survey-card  { background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); overflow:hidden; transition:box-shadow .2s; cursor:pointer; display: block; text-decoration: none; color: inherit; }
.survey-card:hover { box-shadow:var(--neu-out-lg); }
.sc-banner { height:6px; }
.sc-banner.activa    { background:linear-gradient(90deg,var(--verde),var(--verde-pale)); }
.sc-banner.pendiente { background:linear-gradient(90deg,var(--oro-bright),var(--oro-pale)); }
.sc-banner.borrador  { background:linear-gradient(90deg,var(--text-muted),var(--bg-dark)); }
.sc-body     { padding:18px 20px; }
.sc-top      { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:10px; }
.sc-name     { font-family:'Sora',sans-serif; font-size:15px; font-weight:700; color:var(--text-dark); line-height:1.2; }
.sc-desc     { font-size:12px; color:var(--text-muted); margin-top:3px; }
.sc-stats    { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin:14px 0; }
.sc-stat     { background:var(--bg); border-radius:var(--radius-sm); box-shadow:var(--neu-in-sm); padding:10px; text-align:center; }
.sc-stat-val { font-family:'Sora',sans-serif; font-size:18px; font-weight:700; color:var(--text-dark); }
.sc-stat-lbl { font-size:10px; font-family:'JetBrains Mono',monospace; color:var(--text-light); text-transform:uppercase; margin-top:2px; }
.sc-author   { display:flex; align-items:center; gap:8px; margin-top:12px; padding-top:12px; border-top:1px solid rgba(0,0,0,.05); font-size:12px; color:var(--text-muted); }
</style>
</head>
<body>

<!-- TOP NAV -->
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
    <a href="{{ route('editor.dashboard') }}" class="nav-pill {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Mi Espacio
    </a>
    <a href="{{ route('surveys.index') }}" class="nav-pill {{ request()->routeIs('surveys.*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Mis Encuestas
    </a>
    <a href="{{ route('statistics.index') }}" class="nav-pill {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      Estadísticas
    </a>
    <a href="{{ route('editor.encuestas.plantillas') }}" class="nav-pill {{ request()->routeIs('editor.encuestas.plantillas') ? 'active' : '' }}">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
      Plantillas
    </a>
  </div>

  <div class="nav-right">
    <div class="role-chip">{{ strtoupper(Auth::user()->role ?? 'EDITOR') }}</div>
    <div class="status-chip"><div class="status-led"></div>Panel de editor</div>
    
    <div class="notif-wrapper">
        <div class="notif-btn" id="notifBtn">
            🔔
            <div class="notif-dot" id="notifDot"></div>
        </div>
        <div class="notif-dropdown" id="notifDropdown">
            <div class="nd-header">
                <span>Notificaciones</span>
                <button class="nd-mark-read" id="markAllRead">Marcar todas leídas</button>
            </div>
            <div class="nd-list" id="notifList">
                <!-- Items injected by JS -->
                <div class="nd-empty">Cargando...</div>
            </div>
        </div>
    </div>

    <div class="avatar-btn" title="{{ Auth::user()->name }}">
        {{ substr(Auth::user()->name, 0, 2) }}
    </div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="btn btn-sm btn-danger" style="padding: 6px 12px; font-size: 11px;">
            Salir
        </button>
    </form>
  </div>
</nav>

<div class="wrapper">
    @yield('content')
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifList = document.getElementById('notifList');
    const notifDot = document.getElementById('notifDot');
    const markAllReadBtn = document.getElementById('markAllRead');

    // Toggle dropdown
    notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        notifDropdown.classList.toggle('show');
    });

    // Close on click outside
    document.addEventListener('click', (e) => {
        if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
            notifDropdown.classList.remove('show');
        }
    });

    // Fetch notifications
    function fetchNotifications() {
        fetch('{{ route("notifications.unread") }}')
            .then(response => response.json())
            .then(data => {
                // Update dot
                if (data.count > 0) {
                    notifDot.style.display = 'block';
                } else {
                    notifDot.style.display = 'none';
                }

                // Update list
                notifList.innerHTML = '';
                if (data.count === 0) {
                    notifList.innerHTML = '<div class="nd-empty">No tienes notificaciones nuevas</div>';
                } else {
                    data.items.forEach(item => {
                        const el = document.createElement('a');
                        el.className = 'nd-item';
                        el.href = item.url || '#';
                        el.innerHTML = `
                            <div class="nd-title">${item.title}</div>
                            <div>${item.message}</div>
                            <div class="nd-time">${item.created_at}</div>
                        `;
                        notifList.appendChild(el);
                    });
                }
            })
            .catch(err => console.error('Error fetching notifications:', err));
    }

    // Initial fetch
    fetchNotifications();

    // Poll every 5 seconds
    setInterval(fetchNotifications, 5000);

    // Mark all as read
    markAllReadBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent closing dropdown
        fetch('{{ route("notifications.markAllRead") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(() => {
            fetchNotifications();
        });
    });
});

// Tab groups
document.querySelectorAll('.tg-tab').forEach(t => {
  t.addEventListener('click', () => {
    t.closest('.tab-group').querySelectorAll('.tg-tab').forEach(x => x.classList.remove('active'));
    t.classList.add('active');
  });
});
// Template type tabs
document.querySelectorAll('.tpl-tab').forEach(t => {
  t.addEventListener('click', () => {
    t.closest('.tpl-type-tabs').querySelectorAll('.tpl-tab').forEach(x => x.classList.remove('active'));
    t.classList.add('active');
  });
});
// Checkboxes
document.querySelectorAll('.chk').forEach(c => {
  c.addEventListener('click', () => {
    c.classList.toggle('on');
    c.textContent = c.classList.contains('on') ? '✓' : ' ';
  });
});
</script>
</body>
</html>