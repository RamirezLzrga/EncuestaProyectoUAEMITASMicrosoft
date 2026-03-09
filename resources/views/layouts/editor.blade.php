<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIEI – UAEMex · Editor</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&family=Sora:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
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
  white-space: nowrap; user-select: none;
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

/* Activity sidebar */
.activity-card { grid-column:1/5; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.act-list { display:flex; flex-direction:column; gap:10px; margin-top:14px; }
.act-item {
  background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-out);
  padding:12px 14px; display:flex; align-items:flex-start; gap:12px;
  transition:box-shadow .2s; cursor:pointer;
}
.act-item:hover { box-shadow:var(--neu-out-lg); }
.act-icon { width:34px; height:34px; border-radius:10px; box-shadow:var(--neu-out); display:grid; place-items:center; font-size:15px; flex-shrink:0; }
.act-text { font-size:12.5px; font-weight:600; color:var(--text-dark); line-height:1.3; }
.act-meta { font-size:11px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); margin-top:3px; }
.act-time { font-size:10.5px; font-family:'JetBrains Mono',monospace; color:var(--text-light); margin-left:auto; white-space:nowrap; padding-top:1px; flex-shrink:0; }

/* Progress widget */
.progress-card { grid-column:5/-1; background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
.pw-items { display:flex; flex-direction:column; gap:14px; margin-top:14px; }
.pw-item-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:7px; }
.pw-name  { font-size:13px; font-weight:600; color:var(--text); }
.pw-pct   { font-size:12px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); font-weight:500; }
.pw-track { height:10px; background:var(--bg); border-radius:999px; box-shadow:var(--neu-in-sm); overflow:hidden; }
.pw-fill  { height:100%; border-radius:999px; box-shadow:inset -1px -1px 3px rgba(255,255,255,.3),inset 1px 1px 3px rgba(0,0,0,.1); transition:width .8s ease; }
.pw-fill.verde { background:linear-gradient(90deg,var(--verde-mid),var(--verde-pale)); }
.pw-fill.oro   { background:linear-gradient(90deg,var(--oro-bright),var(--oro-pale)); }
.pw-fill.mix   { background:linear-gradient(90deg,var(--verde),var(--oro-bright)); }

/* ═══════════════════════════════════
   EDITOR BUILDER LAYOUT
═══════════════════════════════════ */
.editor-layout {
  display: grid;
  grid-template-columns: 260px 1fr 320px;
  gap: 24px;
  align-items: start;
  padding-bottom: 60px;
}
@media (max-width: 1100px) {
  .editor-layout { grid-template-columns: 240px 1fr; }
  .editor-right { display: none; } /* Hide preview on smaller screens */
}

/* Left Panel */
.editor-left { display: flex; flex-direction: column; gap: 20px; position: sticky; top: 90px; }
.ed-panel {
  background: var(--bg);
  border-radius: var(--radius-lg);
  box-shadow: var(--neu-out);
  padding: 20px;
}
.ed-panel-title {
  font-family: 'Sora', sans-serif;
  font-size: 13px;
  font-weight: 700;
  color: var(--text-dark);
  margin-bottom: 14px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Question Type Buttons */
.q-type-btn {
  display: flex; align-items: center; gap: 10px;
  width: 100%;
  padding: 10px 14px;
  background: var(--bg);
  border: none;
  border-radius: var(--radius);
  box-shadow: var(--neu-out);
  cursor: pointer;
  transition: all 0.2s;
  color: var(--text);
  font-family: 'Nunito', sans-serif;
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 10px;
  text-align: left;
}
.q-type-btn:hover {
  box-shadow: var(--neu-out-lg);
  transform: translateY(-2px);
  color: var(--verde);
}
.q-type-btn:active { box-shadow: var(--neu-press); transform: translateY(0); }
.q-type-icon {
  width: 28px; height: 28px;
  border-radius: 8px;
  background: var(--bg-light);
  display: grid; place-items: center;
  color: var(--text-muted);
  box-shadow: var(--neu-in-sm);
}
.q-type-btn:hover .q-type-icon { color: var(--verde); background: white; }
.q-type-plus { margin-left: auto; font-size: 16px; font-weight: 300; opacity: 0.5; }

/* Center Panel */
.editor-center { display: flex; flex-direction: column; gap: 24px; min-width: 0; }
.ed-form-header {
  background: var(--bg);
  border-radius: var(--radius-lg);
  box-shadow: var(--neu-out);
  padding: 32px;
  border-top: 6px solid var(--verde);
}
.ed-form-title-input {
  width: 100%;
  border: none;
  background: transparent;
  font-family: 'Sora', sans-serif;
  font-size: 24px;
  font-weight: 700;
  color: var(--text-dark);
  padding: 8px 0;
  border-bottom: 1px solid transparent;
  transition: border-color 0.2s;
  outline: none;
}
.ed-form-title-input:focus { border-bottom-color: var(--verde); }
.ed-form-desc-input {
  width: 100%;
  border: none;
  background: transparent;
  font-size: 14px;
  color: var(--text-muted);
  padding: 8px 0;
  margin-top: 8px;
  outline: none;
}

/* Question Card */
.q-card {
  background: var(--bg);
  border-radius: var(--radius-lg);
  box-shadow: var(--neu-out);
  padding: 24px;
  position: relative;
  transition: box-shadow 0.2s;
  border-left: 4px solid transparent;
}
.q-card:hover { box-shadow: var(--neu-out-lg); }
.q-card:focus-within { border-left-color: var(--verde); }

.q-top { display: flex; gap: 16px; margin-bottom: 20px; align-items: flex-start; }
.q-input {
  background: var(--bg-light);
  border: 1px solid rgba(0,0,0,0.05);
  border-radius: 8px;
  padding: 10px 14px;
  font-family: 'Nunito', sans-serif;
  font-size: 14px;
  color: var(--text-dark);
  outline: none;
  transition: all 0.2s;
}
.q-input:focus {
  background: white;
  border-color: var(--verde-pale);
  box-shadow: 0 2px 8px rgba(45,80,22,0.08);
}
.question-input-text { flex: 1; font-weight: 600; }
.question-input-type { width: 140px; cursor: pointer; }

/* Options */
.options-container { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
.opt-row { display: flex; align-items: center; gap: 10px; }
.opt-circle {
  width: 18px; height: 18px;
  border: 2px solid var(--neu-dark);
  border-radius: 50%;
  box-shadow: var(--neu-out);
}
.opt-input {
  flex: 1;
  background: transparent;
  border: none;
  border-bottom: 1px solid rgba(0,0,0,0.1);
  padding: 6px 0;
  font-size: 13px;
  color: var(--text);
  outline: none;
}
.opt-input:focus { border-bottom-color: var(--verde); }
.opt-del {
  cursor: pointer;
  color: var(--text-muted);
  opacity: 0.5;
  padding: 4px;
}
.opt-del:hover { opacity: 1; color: var(--red); }

.add-opt {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 13px; font-weight: 600; color: var(--text-muted);
  cursor: pointer; margin-top: 6px; padding: 4px 0;
}
.add-opt:hover { color: var(--verde); }

/* Footer */
.q-footer {
  display: flex; align-items: center; justify-content: space-between;
  padding-top: 16px;
  border-top: 1px solid rgba(0,0,0,0.05);
}
.chk-group { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); cursor: pointer; user-select: none; }
.chk {
  width: 18px; height: 18px;
  border-radius: 4px;
  background: var(--bg);
  box-shadow: var(--neu-out);
  display: grid; place-items: center;
  font-size: 10px; color: white;
  transition: all 0.2s;
}
.chk.on { background: var(--verde); box-shadow: inset 2px 2px 5px rgba(0,0,0,0.2); }

.add-q-btn {
  width: 100%;
  padding: 16px;
  border-radius: var(--radius-lg);
  background: var(--bg);
  box-shadow: var(--neu-out);
  border: 2px dashed var(--neu-dark);
  color: var(--text-muted);
  font-weight: 700;
  font-size: 14px;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  cursor: pointer;
  transition: all 0.2s;
}
.add-q-btn:hover {
  border-color: var(--verde);
  color: var(--verde);
  background: var(--bg-light);
}

/* Right Panel (Preview) */
.editor-right { position: sticky; top: 90px; height: calc(100vh - 120px); overflow: hidden; }
.preview-panel {
  background: white;
  border-radius: var(--radius-lg);
  box-shadow: var(--neu-out-lg);
  height: 100%;
  display: flex; flex-direction: column;
  overflow: hidden;
  border: 8px solid var(--bg-dark);
}
.pv-header {
  padding: 20px;
  background: var(--verde);
  color: white;
  flex-shrink: 0;
}
.pv-label { font-size: 10px; letter-spacing: 1px; opacity: 0.7; margin-bottom: 4px; }
.pv-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700; line-height: 1.2; }
.pv-sub { font-size: 11px; opacity: 0.8; margin-top: 2px; }
.pv-bar { height: 4px; background: rgba(0,0,0,0.1); }
.pv-bar-fill { width: 30%; height: 100%; background: var(--oro-bright); }
.pv-body {
  flex: 1;
  padding: 20px;
  overflow-y: auto;
  background: #f8f9fa;
  display: flex; flex-direction: column; gap: 16px;
}
.pv-q { font-size: 14px; font-weight: 600; color: #333; margin-bottom: 8px; }
.pv-opt { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; margin-bottom: 6px; }
.pv-opt-circle { width: 14px; height: 14px; border: 1px solid #ccc; border-radius: 50%; background: white; }

/* ═══════════════════════════════════
   MIS ENCUESTAS
═══════════════════════════════════ */
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

.empty-state {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:60px 24px; text-align:center;
}
.empty-icon  { font-size:52px; margin-bottom:16px; opacity:.35; }
.empty-title { font-family:'Sora',sans-serif; font-size:18px; font-weight:700; color:var(--text); margin-bottom:8px; }
.empty-sub   { font-size:13px; color:var(--text-muted); margin-bottom:24px; }

.surveys-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
.survey-card  { background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); overflow:hidden; transition:box-shadow .2s; cursor:pointer; }
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
.sc-av       { width:26px; height:26px; border-radius:50%; background:var(--verde); color:var(--oro-bright); font-size:11px; font-weight:700; display:grid; place-items:center; flex-shrink:0; box-shadow:var(--neu-out); }
.sc-actions  { display:flex; gap:7px; margin-top:12px; }
.sc-btn      { flex:1; padding:8px; border-radius:var(--radius-sm); background:var(--bg); box-shadow:var(--neu-out); border:none; font-size:12px; font-weight:700; color:var(--text-muted); cursor:pointer; transition:all .2s; font-family:'Nunito',sans-serif; display:flex; align-items:center; justify-content:center; gap:5px; }
.sc-btn:hover { color:var(--verde); box-shadow:var(--neu-out-lg); }
.sc-btn:active { box-shadow:var(--neu-press); }
.sc-btn.del:hover { color:var(--red); }

/* ═══════════════════════════════════
   PLANTILLAS
═══════════════════════════════════ */
.templates-layout { display:flex; flex-direction:column; gap:22px; }
.tpl-type-bar {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:18px 24px;
}
.tpl-type-label { font-size:11.5px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); margin-bottom:14px; text-transform:uppercase; letter-spacing:.8px; }
.tpl-type-tabs  { display:flex; gap:10px; flex-wrap:wrap; }
.tpl-tab {
  padding:9px 20px; border-radius:999px; font-size:13px; font-weight:700;
  cursor:pointer; background:var(--bg); box-shadow:var(--neu-out); color:var(--text-muted);
  transition:all .2s; font-family:'Nunito',sans-serif;
}
.tpl-tab:hover  { color:var(--verde); box-shadow:var(--neu-out-lg); }
.tpl-tab:active { box-shadow:var(--neu-press); }
.tpl-tab.active { background:var(--verde); color:white; box-shadow:4px 4px 10px rgba(45,80,22,.35); }

.tpl-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
.tpl-card {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:22px; transition:box-shadow .2s; cursor:pointer;
}
.tpl-card:hover { box-shadow:var(--neu-out-lg); }
.tpl-emoji { font-size:32px; margin-bottom:12px; }
.tpl-name  { font-family:'Sora',sans-serif; font-size:15px; font-weight:700; color:var(--text-dark); margin-bottom:6px; }
.tpl-desc  { font-size:12.5px; color:var(--text-muted); line-height:1.5; margin-bottom:16px; }
.tpl-type-badge { font-size:11px; font-family:'JetBrains Mono',monospace; color:var(--text-light); text-transform:uppercase; letter-spacing:.5px; margin-bottom:12px; }
.tpl-use-btn {
  width:100%; padding:10px; border-radius:999px; background:var(--verde); color:white;
  border:none; font-family:'Nunito',sans-serif; font-size:13px; font-weight:700;
  cursor:pointer; box-shadow:4px 4px 10px rgba(45,80,22,.3); transition:all .2s;
}
.tpl-use-btn:hover { background:var(--verde-mid); box-shadow:5px 5px 14px rgba(45,80,22,.4); }

/* ═══════════════════════════════════
   ESTADÍSTICAS
═══════════════════════════════════ */
.stats-layout { display:flex; flex-direction:column; gap:22px; }

.stats-mini-row { display:grid; grid-template-columns:1fr 1fr; gap:22px; }
.gauge-card {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:24px; display:flex; align-items:center; gap:20px;
}
.gauge-circle { width:90px; height:90px; border-radius:50%; box-shadow:var(--neu-out-lg); display:grid; place-items:center; flex-shrink:0; background:var(--bg); }
.gauge-inner  { width:66px; height:66px; border-radius:50%; box-shadow:var(--neu-in); display:flex; flex-direction:column; align-items:center; justify-content:center; }
.gauge-val    { font-family:'Sora',sans-serif; font-size:18px; font-weight:700; color:var(--text-dark); line-height:1; }
.gauge-unit   { font-size:9px; font-family:'JetBrains Mono',monospace; color:var(--text-light); text-transform:uppercase; }
.gauge-name   { font-family:'Sora',sans-serif; font-size:15px; font-weight:700; color:var(--text-dark); margin-bottom:4px; }
.gauge-sub    { font-size:12px; color:var(--text-muted); }

.stats-charts { display:grid; grid-template-columns:2fr 1fr; gap:22px; }

.bar-chart-horiz { padding:16px; display:flex; flex-direction:column; gap:10px; }
.bar-row { display:flex; align-items:center; gap:10px; font-size:13px; color:var(--body); }
.bar-row-label { width:90px; font-size:12px; color:var(--text-muted); text-align:right; }
.bar-track { flex:1; height:10px; background:var(--bg); border-radius:999px; box-shadow:var(--neu-in-sm); overflow:hidden; }
.bar-fill  { height:100%; border-radius:999px; transition:width .6s ease; }
.bar-fill.verde { background:linear-gradient(90deg,var(--verde-mid),var(--verde-pale)); }
.bar-fill.oro   { background:linear-gradient(90deg,var(--oro-bright),var(--oro-pale)); }
.bar-pct   { font-size:11.5px; font-family:'JetBrains Mono',monospace; color:var(--text-muted); min-width:36px; }

.donut-card { background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:24px; }
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

/* ═══════════════════════════════════
   EDITOR DE ENCUESTA (3 COL)
═══════════════════════════════════ */
.editor-layout {
  display:grid; grid-template-columns:240px 1fr 260px; gap:20px; align-items:start;
}

/* Panel izquierdo */
.editor-left { display:flex; flex-direction:column; gap:16px; position:sticky; top:80px; }

.ed-panel { background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); padding:18px; }
.ed-panel-title { font-size:10.5px; font-family:'JetBrains Mono',monospace; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:14px; font-weight:500; }

.q-type-btn {
  display:flex; align-items:center; gap:10px; width:100%; padding:10px 12px;
  background:var(--bg); border-radius:var(--radius-sm); box-shadow:var(--neu-out);
  border:none; font-family:'Nunito',sans-serif; font-size:13px; font-weight:600;
  color:var(--text); cursor:pointer; transition:all .2s; margin-bottom:8px; text-align:left;
}
.q-type-btn:last-child { margin-bottom:0; }
.q-type-btn:hover { color:var(--verde); box-shadow:var(--neu-out-lg); }
.q-type-btn:active { box-shadow:var(--neu-press); }
.q-type-icon { width:28px; height:28px; border-radius:8px; background:var(--bg); box-shadow:var(--neu-in-sm); display:grid; place-items:center; font-size:14px; flex-shrink:0; }
.q-type-plus { margin-left:auto; font-size:16px; color:var(--verde); }

/* Centro */
.editor-center { display:flex; flex-direction:column; gap:14px; }

.ed-form-header {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:24px; border-left:5px solid var(--oro-bright);
}
.ed-form-title-input {
  font-family:'Sora',sans-serif; font-size:22px; font-weight:700; color:var(--text-dark);
  background:transparent; border:none; outline:none; width:100%;
}
.ed-form-title-input::placeholder { color:var(--bg-dark); }
.ed-form-desc-input {
  font-size:13.5px; color:var(--text-muted); background:transparent; border:none;
  outline:none; width:100%; margin-top:8px; border-top:1px solid rgba(0,0,0,.05); padding-top:10px;
}
.ed-form-desc-input::placeholder { color:var(--bg-dark); }

.q-card {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out);
  padding:20px 22px; border-left:4px solid var(--verde);
}
.q-top   { display:flex; gap:12px; align-items:flex-start; margin-bottom:14px; }
.q-input { flex:1; background:var(--bg); box-shadow:var(--neu-in-sm); border:none; border-radius:var(--radius-sm); color:var(--text-dark); font-family:'Nunito',sans-serif; font-size:14px; font-weight:600; padding:11px 14px; outline:none; transition:box-shadow .2s; }
.q-input:focus { box-shadow:var(--neu-in); }
.q-input::placeholder { color:var(--text-light); font-weight:400; }
select.q-input { appearance:none; cursor:pointer; padding-right:32px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%237a8f6a' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; }

.opt-row { display:flex; align-items:center; gap:10px; padding:7px 0; border-bottom:1px solid rgba(0,0,0,.04); }
.opt-circle { width:14px; height:14px; border-radius:50%; box-shadow:var(--neu-out); flex-shrink:0; }
.opt-input  { flex:1; background:transparent; border:none; outline:none; font-family:'Nunito',sans-serif; font-size:13.5px; font-weight:600; color:var(--text); }
.opt-input::placeholder { color:var(--text-light); font-weight:400; }
.opt-del { color:var(--text-light); cursor:pointer; font-size:13px; transition:color .15s; }
.opt-del:hover { color:var(--red); }

.add-opt { font-size:12.5px; font-weight:700; color:var(--verde-mid); cursor:pointer; margin-top:10px; display:flex; align-items:center; gap:5px; }
.add-opt:hover { color:var(--verde); }

.q-footer { display:flex; align-items:center; justify-content:space-between; margin-top:14px; padding-top:12px; border-top:1px solid rgba(0,0,0,.04); }
.chk-group { display:flex; align-items:center; gap:7px; font-size:13px; color:var(--text); cursor:pointer; }
.chk { width:16px; height:16px; border-radius:4px; box-shadow:var(--neu-out); transition:all .12s; display:grid; place-items:center; flex-shrink:0; cursor:pointer; font-size:10px; }
.chk.on { background:var(--verde); color:white; }

.add-q-btn {
  width:100%; padding:12px; border-radius:var(--radius-lg); background:var(--bg);
  box-shadow:var(--neu-out); border:none; font-family:'Nunito',sans-serif;
  font-size:13.5px; font-weight:700; color:var(--verde); cursor:pointer;
  transition:all .2s; display:flex; align-items:center; justify-content:center; gap:8px;
}
.add-q-btn:hover  { box-shadow:var(--neu-out-lg); }
.add-q-btn:active { box-shadow:var(--neu-press); }

/* Derecha — preview */
.editor-right { position:sticky; top:80px; }
.preview-panel {
  background:var(--bg); border-radius:var(--radius-lg); box-shadow:var(--neu-out); overflow:hidden;
}
.pv-header  { background:var(--verde); padding:14px 16px; }
.pv-label   { font-size:10px; font-family:'JetBrains Mono',monospace; text-transform:uppercase; letter-spacing:1px; color:rgba(255,255,255,.6); margin-bottom:4px; }
.pv-title   { font-family:'Sora',sans-serif; font-size:14px; font-weight:700; color:white; line-height:1.2; }
.pv-sub     { font-size:11.5px; color:rgba(255,255,255,.6); margin-top:4px; }
.pv-bar     { height:4px; background:var(--verde-pale); margin:0 16px; border-radius:999px; margin-bottom:10px; overflow:hidden; }
.pv-bar-fill { height:100%; width:30%; background:var(--oro-bright); border-radius:999px; }
.pv-body    { padding:14px 16px; display:flex; flex-direction:column; gap:14px; }
.pv-q       { font-size:12.5px; font-weight:700; color:var(--text-dark); margin-bottom:7px; }
.pv-opt     { display:flex; align-items:center; gap:7px; font-size:11.5px; color:var(--text); padding:4px 0; }
.pv-opt-circle { width:12px; height:12px; border-radius:50%; box-shadow:var(--neu-out); flex-shrink:0; }

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
      <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
    </div>
    <div>
      <div class="brand-name">SIEI – UAEMex</div>
      <div class="brand-sub">Sistema Integral de Encuestas</div>
    </div>
  </div>

  <div class="nav-pills">
    <a href="{{ route('editor.dashboard') }}" class="nav-pill {{ Request::routeIs('editor.dashboard') ? 'active' : '' }}" style="text-decoration: none;">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Mi Espacio
    </a>
    <a href="{{ route('surveys.index') }}" class="nav-pill {{ Request::routeIs('surveys.*') || Request::routeIs('editor.encuestas.editar') || Request::routeIs('editor.encuestas.nueva') ? 'active' : '' }}" style="text-decoration: none;">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Mis Encuestas
    </a>
    <a href="{{ route('statistics.index') }}" class="nav-pill {{ Request::routeIs('statistics.*') ? 'active' : '' }}" style="text-decoration: none;">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      Estadísticas
    </a>
  </div>

  <div class="nav-right">
    <div class="role-chip">EDITOR</div>
    <div class="status-chip"><div class="status-led"></div>Panel de editor</div>
    <div class="notif-btn" id="notif-btn" style="cursor: pointer; position: relative;">
        🔔
        <div class="notif-dot" id="notif-dot" style="display: none;"></div>
        <div id="notif-count" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; font-size: 10px; width: 15px; height: 15px; display: none; align-items: center; justify-content: center;">0</div>
        
        <!-- Dropdown Notificaciones -->
        <div id="notif-dropdown" style="display: none; position: absolute; top: 100%; right: 0; width: 300px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); z-index: 1000; margin-top: 10px; overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; font-weight: 600; font-size: 14px; color: #111827; background: #f9fafb; display: flex; justify-content: space-between; align-items: center;">
                <span>Notificaciones</span>
                <span id="mark-all-read" style="font-size: 11px; color: #2563EB; cursor: pointer; font-weight: 500;">Marcar leídas</span>
            </div>
            <div id="notif-list" style="max-height: 300px; overflow-y: auto;">
                <!-- Items will be injected here -->
            </div>
            <div id="notif-empty" style="padding: 24px; text-align: center; color: #6b7280; display: none;">
                <div style="font-size: 24px; margin-bottom: 8px;">🔕</div>
                <div style="font-size: 13px;">No tienes notificaciones nuevas</div>
            </div>
        </div>
    </div>
    <div style="position: relative;">
      <div class="avatar-btn" id="user-menu-btn">{{ substr(optional(Auth::user())->name ?? 'U', 0, 2) }}</div>
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
</div><!-- /wrapper -->

<script>
// Notification System
document.addEventListener('DOMContentLoaded', function() {
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    const notifDot = document.getElementById('notif-dot');
    const notifCount = document.getElementById('notif-count');
    const notifBtn = document.getElementById('notif-btn');
    const notifDropdown = document.getElementById('notif-dropdown');
    const notifList = document.getElementById('notif-list');
    const notifEmpty = document.getElementById('notif-empty');
    const markAllReadBtn = document.getElementById('mark-all-read');
    
    let lastCount = 0;
    let initialLoad = true;
    let notifications = [];

    // Unlock audio context on first user interaction
    document.addEventListener('click', function() {
        if (audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
    }, { once: true });

    function playSound() {
        if (audioCtx.state === 'suspended') {
            audioCtx.resume().then(() => playTone());
        } else {
            playTone();
        }
    }

    function playTone() {
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        
        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // A5
        oscillator.frequency.exponentialRampToValueAtTime(440, audioCtx.currentTime + 0.5); // Drop to A4
        
        gainNode.gain.setValueAtTime(0.3, audioCtx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
        
        oscillator.start();
        oscillator.stop(audioCtx.currentTime + 0.5);
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
                    notifCount.style.display = 'flex';
                    
                    // If count increased, play sound
                    if (!initialLoad && count > lastCount) {
                        playSound();
                    }
                } else {
                    notifDot.style.display = 'none';
                    notifCount.style.display = 'none';
                }
                
                lastCount = count;
                initialLoad = false;
                
                // If dropdown is open, re-render to show new items
                if (notifDropdown.style.display === 'block') {
                    renderNotifications();
                }
            })
            .catch(err => console.error('Notification poll error:', err));
    }

    function renderNotifications() {
        notifList.innerHTML = '';
        
        if (notifications.length === 0) {
            notifEmpty.style.display = 'block';
            notifList.style.display = 'none';
        } else {
            notifEmpty.style.display = 'none';
            notifList.style.display = 'block';
            
            notifications.forEach(n => {
                const item = document.createElement('div');
                item.style.padding = '12px 16px';
                item.style.borderBottom = '1px solid #f3f4f6';
                item.style.cursor = 'pointer';
                item.style.transition = 'background-color 0.2s';
                
                item.innerHTML = `
                    <div style="font-weight: 600; color: #1f2937; font-size: 13px; margin-bottom: 2px;">${n.title}</div>
                    <div style="color: #4b5563; font-size: 12px; line-height: 1.4;">${n.message}</div>
                    <div style="color: #9ca3af; font-size: 11px; margin-top: 4px;">${n.created_at}</div>
                `;
                
                item.addEventListener('click', () => {
                    window.location.href = n.url;
                });
                
                item.onmouseover = () => item.style.backgroundColor = '#f9fafb';
                item.onmouseout = () => item.style.backgroundColor = 'white';
                
                notifList.appendChild(item);
            });
        }
    }

    // Initial check
    checkNotifications();

    // Poll every 5 seconds
    setInterval(checkNotifications, 5000);

    // Toggle dropdown
    notifBtn.addEventListener('click', function(e) {
        if (e.target.closest('#notif-dropdown')) return;
        
        if (notifDropdown.style.display === 'none') {
            notifDropdown.style.display = 'block';
            renderNotifications();
        } else {
            notifDropdown.style.display = 'none';
        }
    });

    // Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!notifBtn.contains(e.target)) {
            notifDropdown.style.display = 'none';
        }
    });

    // Mark all as read
    markAllReadBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        fetch('{{ route("notifications.markAllRead") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(() => {
            checkNotifications();
        })
        .catch(err => console.error('Error marking read:', err));
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const userBtn = document.getElementById('user-menu-btn');
  const userDropdown = document.getElementById('user-menu-dropdown');

  if (!userBtn || !userDropdown) return;

  userBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    userDropdown.style.display = (userDropdown.style.display === 'block') ? 'none' : 'block';
  });

  document.addEventListener('click', function(e) {
    if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
      userDropdown.style.display = 'none';
    }
  });
});
</script>

<script>
function sp(id, navEl) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById(id)?.classList.add('active');
  document.querySelectorAll('.nav-pill').forEach(p => p.classList.remove('active'));
  if (navEl) navEl.classList.add('active');
  window.scrollTo({ top:0, behavior:'smooth' });
}
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
@stack('scripts')
</body>
</html>
