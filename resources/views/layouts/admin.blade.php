<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIEI – UAEMex · Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&family=Sora:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          uaemex: '#2D5016',
          'uaemex-light': '#3a6b1c',
          'uaemex-pale': '#c8dbb8',
          'oro': '#C99A0A',
        }
      }
    }
  }
</script>
<style>
:root {
  --uaemex: #2D5016;
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
  display: flex; align-items: center; gap: 4px;
  background: var(--bg); border-radius: 999px; padding: 5px;
  box-shadow: var(--neu-in-sm);
  overflow-x: auto;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE 10+ */
}
.nav-pills::-webkit-scrollbar {
  display: none; /* Chrome/Safari */
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
.nav-pill svg { width: 15px; height: 15px; flex-shrink: 0; }
.nav-right { margin-left: auto; display: flex; align-items: center; gap: 14px; }
.role-chip {
  padding: 6px 14px; border-radius: 999px; background: var(--bg);
  box-shadow: var(--neu-out); font-size: 11.5px; font-weight: 700;
  color: var(--oro); font-family: 'JetBrains Mono', monospace; letter-spacing: .5px;
}
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
.notif-count {
  position: absolute; top: -5px; right: -5px;
  background: var(--red); color: white; border-radius: 999px;
  padding: 2px 6px; font-size: 10px; font-weight: 700;
  border: 2px solid var(--bg); display: none;
}

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
   DASHBOARD — ADMIN
═══════════════════════════════════ */
.dash-grid { display: grid; grid-template-columns: repeat(12,1fr); gap: 22px; }

/* Welcome banner */
.welcome-band {
  grid-column: 1 / -1;
  background: var(--verde);
  border-radius: var(--radius-lg);
  padding: 26px 32px;
  box-shadow: 8px 8px 20px rgba(45,80,22,.35), -4px -4px 12px rgba(255,255,255,.25);
  display: flex; align-items: center; justify-content: space-between;
  overflow: hidden; position: relative;
}
.wb-circles { position:absolute; top:-30px; right:-30px; width:180px; height:180px; border-radius:50%; border:40px solid rgba(255,255,255,.04); }
.wb-circles2 { position:absolute; bottom:-40px; right:80px; width:120px; height:120px; border-radius:50%; border:28px solid rgba(255,255,255,.03); }
.wb-tag   { font-size:10.5px; font-family:'JetBrains Mono',monospace; text-transform:uppercase; letter-spacing:1.2px; color:var(--oro-pale); opacity:.8; margin-bottom:8px; }
.wb-title { font-family:'Sora',sans-serif; font-size:20px; font-weight:700; color:white; margin-bottom:6px; }
.wb-sub   { font-size:13px; color:rgba(255,255,255,.6); max-width:320px; }
.wb-date { display:flex; flex-direction:column; align-items:flex-end; gap:6px; flex-shrink:0; }
.wb-date-day { font-family:'Sora',sans-serif; font-size:52px; font-weight:700; color:var(--oro-bright); letter-spacing:-2px; line-height:1; }
.wb-date-rest { font-size:12px; color:rgba(255,255,255,.5); font-family:'JetBrains Mono',monospace; text-align:right; }

/* KPIs */
.kpi-row { grid-column:1/-1; display:grid; grid-template-columns:repeat(4,1fr); gap:22px; }
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
  cursor:pointer; transition:box-shadow .2s; text-align:center; text-decoration:none;
}
.qa-item:hover  { box-shadow:var(--neu-out-lg); }
.qa-item:active { box-shadow:var(--neu-press); }
.qa-emoji { font-size:22px; }
.qa-label { font-size:11.5px; font-weight:700; color:var(--text); }

/* Chart Card */
.chart-card {
  grid-column:5/-1; background:var(--bg); border-radius:var(--radius-lg);
  box-shadow:var(--neu-out); padding:24px;
}
.cc-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.cc-title  { font-family:'Sora',sans-serif; font-size:15px; font-weight:700; color:var(--text-dark); }
.cc-sub    { font-size:12px; color:var(--text-muted); margin-top:2px; }
.tab-group { display:flex; gap:4px; background:var(--bg); box-shadow:var(--neu-in-sm); border-radius:999px; padding:4px; }
.tg-tab    { padding:5px 14px; border-radius:999px; font-size:11.5px; font-weight:700; color:var(--text-muted); cursor:pointer; transition:all .2s; font-family:'JetBrains Mono',monospace; }
.tg-tab.active { background:var(--verde); color:white; box-shadow:3px 3px 8px rgba(45,80,22,.3),-1px -1px 4px rgba(255,255,255,.2); }

.chart-body { height:180px; display:flex; align-items:flex-end; gap:10px; padding:0 4px; }
.cb-bar-wrap { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end; }
.cb-bar      { width:100%; border-radius:8px 8px 4px 4px; box-shadow:inset -2px -2px 5px rgba(255,255,255,.4),inset 2px 2px 5px rgba(0,0,0,.08); cursor:pointer; transition:opacity .15s; min-height:6px; }
.cb-bar:hover { opacity:.8; }
.cb-bar.verde { background:linear-gradient(180deg,var(--verde-mid),var(--verde)); }
.cb-bar.oro   { background:linear-gradient(180deg,var(--oro-bright),var(--oro)); }
.cb-month     { font-size:9.5px; font-family:'JetBrains Mono',monospace; color:var(--text-light); text-transform:uppercase; letter-spacing:.5px; }

/* Donut Card */
.donut-card { grid-column:1/5; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.donut-wrap { display:flex; align-items:center; gap:18px; margin-top:16px; }
.donut-svg-wrap { position:relative; width:110px; height:110px; flex-shrink:0; }
.donut-svg   { width:110px; height:110px; transform:rotate(-90deg); }
.donut-center { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.donut-pct   { font-family:'Sora',sans-serif; font-size:22px; font-weight:700; color:var(--text-dark); line-height:1; }
.donut-pct-label { font-size:9.5px; color:var(--text-muted); font-family:'JetBrains Mono',monospace; text-transform:uppercase; letter-spacing:.5px; }
.donut-legend { display:flex; flex-direction:column; gap:9px; flex:1; }
.dl-row { display:flex; align-items:center; gap:9px; font-size:12.5px; color:var(--text); }
.dl-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }
.dl-val { margin-left:auto; font-family:'JetBrains Mono',monospace; font-size:12px; font-weight:500; color:var(--text-muted); }

/* Progress Card */
.progress-card { grid-column:5/9; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.pw-items { display:flex; flex-direction:column; gap:14px; margin-top:14px; }
.pw-item-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:7px; }
.pw-name  { font-size:13px; font-weight:600; color:var(--text); }
.pw-pct   { font-size:12px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); font-weight:500; }
.pw-track { height:10px; background:var(--bg); border-radius:999px; box-shadow:var(--neu-in-sm); overflow:hidden; }
.pw-fill  { height:100%; border-radius:999px; box-shadow:inset -1px -1px 3px rgba(255,255,255,.3),inset 1px 1px 3px rgba(0,0,0,.1); transition:width .8s ease; }
.pw-fill.verde { background:linear-gradient(90deg,var(--verde-mid),var(--verde-pale)); }
.pw-fill.oro   { background:linear-gradient(90deg,var(--oro-bright),var(--oro-pale)); }

/* Heatmap Card */
.heatmap-card { grid-column:9/-1; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.hm-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:6px; margin-top:16px; }
.hm-day-label { font-size:10px; font-family:'JetBrains Mono',monospace; color:var(--text-light); text-align:center; margin-bottom:4px; }
.hm-cell { aspect-ratio:1; border-radius:4px; box-shadow:var(--neu-in-sm); }
.hm-0 { background:var(--bg); }
.hm-1 { background:var(--verde-pale); }
.hm-2 { background:var(--verde-mid); }
.hm-3 { background:var(--verde); }
.hm-4 { background:var(--text-dark); }

/* Table Card */
.table-card { grid-column:1/7; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.rc-list { display:flex; flex-direction:column; gap:10px; margin-top:16px; }
.rc-item {
  background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-out);
  padding:13px 15px; transition:box-shadow .2s; cursor:pointer;
}
.rc-item:hover { box-shadow:var(--neu-out-lg); }
.rc-top  { display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; }
.rc-name { font-size:13px; font-weight:700; color:var(--text-dark); }
.rc-bar-wrap { display:flex; align-items:center; gap:8px; }
.rc-mini-bar { flex:1; height:5px; border-radius:999px; box-shadow:var(--neu-in-sm); overflow:hidden; }
.rc-mini-fill { height:100%; border-radius:999px; background:linear-gradient(90deg,var(--verde),var(--verde-pale)); }
.rc-num  { font-size:11px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); white-space:nowrap; }

/* Timeline Card */
.timeline-card { grid-column:7/-1; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }

/* Generic Neumorphic Card */
.neu-card {
  background: var(--bg);
  border-radius: var(--radius-lg);
  box-shadow: var(--neu-out);
  padding: 24px;
  margin-bottom: 22px;
  transition: box-shadow 0.2s ease;
}
.neu-card:hover { box-shadow: var(--neu-out-lg); }

/* Form Elements */
.form-group { margin-bottom: 16px; }
.form-label { display: block; font-size: 13px; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; font-family: 'Sora', sans-serif; }
.form-input {
  width: 100%;
  background: var(--bg);
  border: none;
  border-radius: var(--radius);
  padding: 12px 16px;
  font-family: 'Nunito', sans-serif;
  font-size: 14px;
  color: var(--text);
  box-shadow: var(--neu-in-sm);
  outline: none;
  transition: box-shadow 0.2s;
}
.form-input:focus { box-shadow: var(--neu-in); }

/* Grid Layouts */
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
.grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }

/* Status Badges */
.status-pill {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 6px 12px; border-radius: 999px;
  font-size: 11.5px; font-weight: 700;
  box-shadow: var(--neu-out);
}
.status-pending { color: var(--oro-bright); }
.status-approved { color: var(--green); }
.status-rejected { color: var(--red); }

.tl-list { display:flex; flex-direction:column; gap:16px; margin-top:16px; position:relative; }
.tl-line { position:absolute; top:10px; bottom:10px; left:14px; width:2px; background:var(--bg-dark); z-index:0; }
.tl-item { display:flex; gap:12px; align-items:flex-start; position:relative; z-index:1; }
.tl-dot { width:30px; height:30px; border-radius:50%; background:var(--bg); box-shadow:var(--neu-out); display:grid; place-items:center; font-size:12px; flex-shrink:0; }
.tl-content { flex:1; padding-top:4px; }
.tl-action { font-size:13px; font-weight:600; color:var(--text); }
.tl-meta { font-size:11px; color:var(--text-muted); margin-top:2px; }

/* scrollbar */
::-webkit-scrollbar { width:5px; }
::-webkit-scrollbar-track { background:var(--bg-dark); }
::-webkit-scrollbar-thumb { background:var(--verde-pale); border-radius:999px; }
</style>
@stack('styles')
</head>
<body>

<!-- TOP NAV -->
<nav class="topnav">
  <div class="brand">
    <div class="brand-logo">
      <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
    </div>
    <div style="line-height:1.2">
      <div class="brand-name">SIEI</div>
      <div class="brand-sub">UAEMex</div>
    </div>
  </div>

  <div class="nav-pills">
    <a href="{{ route('dashboard') }}" class="nav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
      Dashboard
    </a>
    <a href="{{ route('surveys.index') }}" class="nav-pill {{ request()->routeIs('surveys.*') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
      Encuestas
    </a>
    <a href="{{ route('admin.aprobaciones') }}" class="nav-pill {{ request()->routeIs('admin.aprobaciones') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
      Aprobaciones
    </a>
    <a href="{{ route('users.index') }}" class="nav-pill {{ request()->routeIs('users.*') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
      Usuarios
    </a>
    <a href="{{ route('statistics.index') }}" class="nav-pill {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
      Estadísticas
    </a>
    <a href="{{ route('activity-logs.index') }}" class="nav-pill {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
      Bitácora
    </a>
  </div>

  <div class="nav-right">
    <div class="role-chip">ADMIN</div>
    
    <div style="position: relative;">
      <div class="notif-btn" id="notif-btn">
        <i class="fa-regular fa-bell"></i>
        <div class="notif-dot" id="notif-dot"></div>
        <div class="notif-count" id="notif-count">0</div>
      </div>
      <!-- Notif Dropdown -->
      <div id="notif-dropdown" style="display:none; position:absolute; top: 100%; right: 0; width: 320px; background: white; border: 1px solid #e5e7eb; border-radius: 10px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); z-index: 1000; margin-top: 10px; overflow: hidden;">
        <div style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; font-weight: 600; color: #111827; display:flex; justify-content:space-between; align-items:center;">
          <span>Notificaciones</span>
          <span id="mark-all-read" style="font-size: 11px; color: #2563EB; cursor: pointer;">Marcar leídas</span>
        </div>
        <div id="notif-list" style="max-height: 300px; overflow-y: auto;">
          <!-- Items will be injected here -->
        </div>
      </div>
    </div>

    <div style="position: relative;">
      <div class="avatar-btn" id="user-menu-btn">{{ substr(optional(Auth::user())->name ?? 'U', 0, 2) }}</div>
      <!-- User Menu Dropdown -->
      <div id="user-menu-dropdown" style="display:none; position:absolute; top: 100%; right: 0; width: 240px; background: white; border: 1px solid #e5e7eb; border-radius: 10px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); z-index: 1000; margin-top: 10px; overflow: hidden;">
        <div style="padding: 14px 16px; border-bottom: 1px solid #f3f4f6; background: #f9fafb;">
          <div style="font-weight: 700; font-size: 13px; color: #111827; line-height: 1.2;">{{ optional(Auth::user())->name ?? 'Usuario' }}</div>
          <div style="font-size: 11px; color: #6b7280; margin-top: 4px;">
            @switch(optional(Auth::user())->role)
              @case('admin') Administrador @break
              @case('editor') Editor @break
              @default Usuario
            @endswitch
          </div>
        </div>
        <div style="padding: 10px 12px; display: flex; flex-direction: column; gap: 8px;">
          <a href="{{ route('profile.show') }}" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius: 10px; text-decoration:none; color:#111827; background:#ffffff; border:1px solid #f3f4f6;">
            <span style="font-size: 16px; line-height: 1;">👤</span>
            <span style="font-weight: 600; font-size: 13px;">Mi perfil</span>
          </a>
          <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" style="width:100%; display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius: 10px; border:1px solid #f3f4f6; background:#ffffff; color:#111827; cursor:pointer;">
              <span style="font-size: 16px; line-height: 1;">🚪</span>
              <span style="font-weight: 700; font-size: 13px;">Cerrar sesión</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

<div class="wrapper">
  @yield('content')
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
  // ─── USER MENU ───
  const userMenuBtn = document.getElementById('user-menu-btn');
  const userMenuDropdown = document.getElementById('user-menu-dropdown');

  userMenuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    userMenuDropdown.style.display = userMenuDropdown.style.display === 'block' ? 'none' : 'block';
    if (notifDropdown) notifDropdown.style.display = 'none';
  });

  // ─── NOTIFICATIONS ───
  const notifBtn = document.getElementById('notif-btn');
  const notifDropdown = document.getElementById('notif-dropdown');
  const notifList = document.getElementById('notif-list');
  const notifDot = document.getElementById('notif-dot');
  const notifCount = document.getElementById('notif-count');
  const markAllReadBtn = document.getElementById('mark-all-read');
  
  let notifications = [];
  let initialLoad = true;
  let lastCount = 0;

  // Audio Context for sound
  let audioCtx = null;
  
  function initAudio() {
    if (!audioCtx) {
      const AudioContext = window.AudioContext || window.webkitAudioContext;
      audioCtx = new AudioContext();
    }
    if (audioCtx.state === 'suspended') {
      audioCtx.resume();
    }
  }

  function playSound() {
    initAudio();
    if (!audioCtx) return;

    const oscillator = audioCtx.createOscillator();
    const gainNode = audioCtx.createGain();

    oscillator.type = 'sine';
    oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // A5
    oscillator.frequency.exponentialRampToValueAtTime(440, audioCtx.currentTime + 0.5); // Drop to A4

    gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
    gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);

    oscillator.connect(gainNode);
    gainNode.connect(audioCtx.destination);

    oscillator.start();
    oscillator.stop(audioCtx.currentTime + 0.5);
  }

  // Unlock audio on first interaction
  document.addEventListener('click', initAudio, { once: true });

  notifBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    notifDropdown.style.display = notifDropdown.style.display === 'block' ? 'none' : 'block';
    if (userMenuDropdown) userMenuDropdown.style.display = 'none';
    if (notifDropdown.style.display === 'block') {
      renderNotifications();
    }
  });

  document.addEventListener('click', () => {
    if (userMenuDropdown) userMenuDropdown.style.display = 'none';
    if (notifDropdown) notifDropdown.style.display = 'none';
  });
  
  if (notifDropdown) notifDropdown.addEventListener('click', e => e.stopPropagation());
  if (userMenuDropdown) userMenuDropdown.addEventListener('click', e => e.stopPropagation());

  function renderNotifications() {
    notifList.innerHTML = '';
    
    if (notifications.length === 0) {
      notifList.innerHTML = `
        <div style="padding: 20px; text-align: center; color: #6b7280; font-size: 13px;">
          <div style="font-size: 24px; margin-bottom: 8px;">🔕</div>
          No tienes notificaciones nuevas
        </div>
      `;
      return;
    }

    notifications.forEach(n => {
      const item = document.createElement('div');
      item.style.padding = '12px 16px';
      item.style.borderBottom = '1px solid #f3f4f6';
      item.style.cursor = 'pointer';
      item.style.transition = 'background 0.2s';
      item.onmouseover = () => item.style.background = '#f9fafb';
      item.onmouseout = () => item.style.background = 'white';
      
      let icon = '📢';
      if (n.type === 'approval') icon = '✅';
      if (n.type === 'rejection') icon = '❌';
      if (n.type === 'submission') icon = '📝';

      item.innerHTML = `
        <div style="display:flex; gap:10px;">
          <div style="font-size:18px;">${icon}</div>
          <div>
            <div style="font-size:13px; font-weight:600; color:#111827;">${n.title}</div>
            <div style="font-size:12px; color:#4b5563; margin-top:2px;">${n.message}</div>
            <div style="font-size:10px; color:#9ca3af; margin-top:4px;">${n.created_at}</div>
          </div>
        </div>
      `;
      
      item.onclick = () => {
        if (n.url) window.location.href = n.url;
      };
      
      notifList.appendChild(item);
    });
  }

  function checkNotifications() {
    fetch('{{ route("notifications.unread") }}')
      .then(response => response.json())
      .then(data => {
        const count = data.count;
        notifications = data.items || [];
        
        if (count > 0) {
          notifDot.style.display = 'block';
          notifCount.innerText = count > 9 ? '9+' : count;
          notifCount.style.display = 'flex'; // Use flex to center text
          
          if (!initialLoad && count > lastCount) {
            playSound();
          }
        } else {
          notifDot.style.display = 'none';
          notifCount.style.display = 'none';
        }
        
        lastCount = count;
        initialLoad = false;
        
        if (notifDropdown.style.display === 'block') {
          renderNotifications();
        }
      })
      .catch(err => console.error('Notification poll error:', err));
  }

  markAllReadBtn.addEventListener('click', () => {
    fetch('{{ route("notifications.markAllRead") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      }
    })
    .then(res => res.json())
    .then(() => {
      checkNotifications();
    });
  });

  // Poll every 5 seconds
  setInterval(checkNotifications, 5000);
  checkNotifications(); // Initial check
</script>
@stack('scripts')
</body>
</html>
