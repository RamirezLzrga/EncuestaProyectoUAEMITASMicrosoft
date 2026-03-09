<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI – UAEMex · @yield('title', 'Panel Administrativo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <style>
        :root{
            --bg:#e8ede2;--bg-dark:#dde3d6;--bg-light:#f3f7ee;
            --neu-shadow-dark:#c4c9be;--neu-shadow-light:#ffffff;
            --verde:#2D5016;--verde-mid:#3a6b1c;--verde-pale:#c8dbb8;--verde-xpale:#ddebd0;
            --oro:#C99A0A;--oro-bright:#e0ae12;--oro-pale:#f5e6a3;
            --text-dark:#1e2d14;--text:#3a4a2c;--text-muted:#7a8f6a;--text-light:#a5b896;
            --red:#c0392b;--green:#1e7e34;--blue:#1a5299;
            --neu-out:6px 6px 14px var(--neu-shadow-dark),-6px -6px 14px var(--neu-shadow-light);
            --neu-out-lg:10px 10px 24px var(--neu-shadow-dark),-10px -10px 24px var(--neu-shadow-light);
            --neu-in:inset 4px 4px 10px var(--neu-shadow-dark),inset -4px -4px 10px var(--neu-shadow-light);
            --neu-in-sm:inset 2px 2px 6px var(--neu-shadow-dark),inset -2px -2px 6px var(--neu-shadow-light);
            --neu-press:inset 5px 5px 12px var(--neu-shadow-dark),inset -5px -5px 12px var(--neu-shadow-light)
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Nunito',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;-webkit-font-smoothing:antialiased}
        .topnav{position:fixed;top:0;left:0;right:0;z-index:200;background:var(--bg);padding:0 36px;height:68px;display:flex;align-items:center;gap:0;box-shadow:0 4px 20px rgba(0,0,0,.08)}
        .brand{display:flex;align-items:center;gap:14px;margin-right:40px;flex-shrink:0}
        .brand-logo{width:42px;height:42px;border-radius:14px;background:var(--verde);display:grid;place-items:center;box-shadow:var(--neu-out);flex-shrink:0}
        .brand-logo svg{width:22px;height:22px;fill:var(--oro-bright)}
        .brand-name{font-family:'Sora',sans-serif;font-size:15px;font-weight:700;color:var(--verde);letter-spacing:-.3px;line-height:1.1}
        .brand-sub{font-size:10.5px;color:var(--text-muted);font-weight:400;margin-top:1px}
        .nav-pills{display:flex;align-items:center;gap:4px;flex:1;background:var(--bg);border-radius:999px;padding:5px;box-shadow:var(--neu-in-sm);max-width:560px}
        .nav-pill{display:flex;align-items:center;gap:7px;padding:8px 16px;border-radius:999px;font-size:13px;font-weight:700;color:var(--text-muted);cursor:pointer;transition:all .2s;white-space:nowrap;user-select:none;text-decoration:none}
        .nav-pill:hover{color:var(--verde)}
        .nav-pill.active{background:var(--verde);color:#fff;box-shadow:4px 4px 10px rgba(45,80,22,.35),-2px -2px 6px rgba(255,255,255,.2)}
        .nav-badge{background:var(--oro-bright);color:var(--verde);font-size:9.5px;font-weight:800;padding:1px 6px;border-radius:999px}
        .nav-right{margin-left:auto;display:flex;align-items:center;gap:14px}
        .status-chip{display:flex;align-items:center;gap:7px;padding:7px 16px;border-radius:999px;background:var(--bg);box-shadow:var(--neu-out);font-size:12px;font-weight:700;color:var(--text-muted)}
        .status-led{width:7px;height:7px;border-radius:50%;background:#4caf50;box-shadow:0 0 6px #4caf5099;animation:breathe 2.5s infinite}
        @keyframes breathe{0%,100%{box-shadow:0 0 6px #4caf5099}50%{box-shadow:0 0 12px #4caf50cc}}
        .avatar-btn{width:42px;height:42px;border-radius:50%;background:var(--verde);color:var(--oro-bright);font-family:'Sora',sans-serif;font-weight:700;font-size:14px;display:grid;place-items:center;cursor:pointer;box-shadow:var(--neu-out);transition:box-shadow .2s;flex-shrink:0;border:3px solid var(--bg);outline:3px solid var(--verde-pale)}
        .avatar-btn:hover{box-shadow:var(--neu-out-lg)}
        .wrapper{padding:90px 36px 60px;max-width:1300px;margin:0 auto}
        .page{display:block}

        .page-header{margin-bottom:18px}
        .page-title-row{display:flex;align-items:center;justify-content:space-between;gap:16px}
        .page-title{font-family:'Sora',sans-serif;font-weight:700;font-size:22px;color:var(--verde);letter-spacing:-.2px}
        .page-subtitle{font-size:12.5px;color:var(--text-muted);margin-top:2px}
        .page-actions{display:flex;align-items:center;gap:10px}

        .btn{display:inline-flex;align-items:center;gap:8px;padding:9px 14px;border-radius:12px;font-weight:800;font-size:12.5px;text-decoration:none;cursor:pointer;transition:transform .05s ease, box-shadow .2s ease;user-select:none;border:none}
        .btn svg{width:16px;height:16px}
        .btn:active{transform:translateY(1px)}
        .btn-gold{background:var(--oro-bright);color:var(--verde);box-shadow:6px 6px 14px var(--neu-shadow-dark),-6px -6px 14px var(--neu-shadow-light)}
        .btn-gold:hover{box-shadow:10px 10px 24px var(--neu-shadow-dark),-10px -10px 24px var(--neu-shadow-light)}
        .btn-secondary{background:var(--bg);color:var(--text);border:1px solid #d9dfd2;box-shadow:6px 6px 14px var(--neu-shadow-dark),-6px -6px 14px var(--neu-shadow-light)}
        .btn-secondary:hover{box-shadow:10px 10px 24px var(--neu-shadow-dark),-10px -10px 24px var(--neu-shadow-light)}
        .btn-neu{background:var(--bg);color:var(--text);box-shadow:var(--neu-out)}
        .btn-neu:hover{box-shadow:var(--neu-out-lg)}
        .btn-solid{background:var(--verde);color:#fff;box-shadow:5px 5px 14px rgba(45,80,22,.4),-3px -3px 8px rgba(255,255,255,.3)}
        .btn-solid:hover{background:var(--verde-mid)}
        .btn-oro{background:var(--oro-bright);color:var(--verde);box-shadow:5px 5px 14px rgba(201,154,10,.35),-3px -3px 8px rgba(255,255,255,.4)}
        .btn-oro:hover{background:var(--oro);color:#fff}
        .btn-sm{padding:8px 16px;font-size:12.5px}
        .btn-icon{width:42px;height:42px;padding:0;border-radius:14px;display:grid;place-items:center;font-size:16px}

        .bg-uaemex{background-color:var(--verde)}
        .text-uaemex{color:var(--verde)}

        .stats-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin:6px 0 18px}
        @media (max-width:1100px){.stats-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media (max-width:640px){.stats-grid{grid-template-columns:1fr}}
        .stat-card{background:var(--bg);border-radius:18px;padding:16px;box-shadow:6px 6px 14px var(--neu-shadow-dark),-6px -6px 14px var(--neu-shadow-light);border:1px solid #e6ebdf}
        .stat-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px}
        .stat-label{font-size:12px;font-weight:800;color:var(--text-muted);letter-spacing:.3px;text-transform:uppercase}
        .stat-icon{width:36px;height:36px;border-radius:12px;display:grid;place-items:center;background:var(--bg-light);box-shadow:inset 2px 2px 6px var(--neu-shadow-dark),inset -2px -2px 6px var(--neu-shadow-light);font-size:16px}
        .stat-icon.green{color:#2e7d32}
        .stat-icon.gold{color:var(--oro)}
        .stat-icon.blue{color:#2563eb}
        .stat-value{font-family:'Sora',sans-serif;font-size:28px;font-weight:800;color:var(--text-dark);letter-spacing:-.4px}
        .stat-change{display:flex;align-items:center;gap:6px;margin-top:6px;font-size:12px;color:var(--text-muted);font-weight:700}
        .stat-change.positive{color:#2e7d32}

        .alert-card{background:var(--bg);border-radius:18px;padding:16px;margin-bottom:18px;border:1px solid #e6ebdf;box-shadow:6px 6px 14px var(--neu-shadow-dark),-6px -6px 14px var(--neu-shadow-light)}
        .alert-header{display:flex;align-items:center;gap:12px}
        .alert-icon{width:36px;height:36px;border-radius:12px;display:grid;place-items:center;background:#fff;color:#b45309;border:1px solid #f4dab7;box-shadow:2px 2px 6px rgba(0,0,0,.04)}
        .alert-content h4{font-weight:800;font-size:14px;color:var(--text-dark)}
        .alert-content p{font-size:12.5px;color:var(--text)}

        .content-row{display:grid;grid-template-columns:2fr 1fr;gap:16px}
        @media (max-width:1100px){.content-row{grid-template-columns:1fr}}

        .card{background:var(--bg);border:1px solid #e6ebdf;border-radius:18px;box-shadow:6px 6px 14px var(--neu-shadow-dark),-6px -6px 14px var(--neu-shadow-light);overflow:hidden}
        .card-header{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #e6ebdf}
        .card-title{display:flex;align-items:center;gap:10px;font-weight:800;color:var(--text-dark)}
        .card-icon{width:28px;height:28px;border-radius:10px;display:grid;place-items:center;background:var(--bg-light);box-shadow:inset 2px 2px 6px var(--neu-shadow-dark),inset -2px -2px 6px var(--neu-shadow-light)}
        .card-actions{display:flex;align-items:center;gap:6px}
        .filter-chip{padding:6px 10px;border-radius:999px;font-weight:800;font-size:12px;color:var(--text);background:var(--bg);border:1px solid #dfe5d7;cursor:pointer}
        .filter-chip.active{background:var(--verde);color:#fff;border-color:var(--verde)}
        .chart-container{padding:16px;min-height:180px;display:flex;align-items:center;justify-content:center}
        .chart-placeholder-content{display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text)}
        .chart-icon{width:52px;height:52px;border-radius:16px;display:grid;place-items:center;background:var(--bg-light);box-shadow:inset 2px 2px 6px var(--neu-shadow-dark),inset -2px -2px 6px var(--neu-shadow-light);font-size:22px;margin-bottom:10px}

        .activity-list{display:flex;flex-direction:column}
        .activity-item{display:grid;grid-template-columns:auto 1fr auto;gap:12px;padding:12px 16px;border-bottom:1px solid #e6ebdf}
        .activity-icon-wrapper{width:34px;height:34px;border-radius:12px;display:grid;place-items:center;background:var(--bg-light);box-shadow:inset 2px 2px 6px var(--neu-shadow-dark),inset -2px -2px 6px var(--neu-shadow-light)}
        .activity-icon-wrapper.survey{color:#2563eb}
        .activity-icon-wrapper.user{color:#16a34a}
        .activity-icon-wrapper.response{color:#b45309}
        .activity-content{display:flex;flex-direction:column;gap:2px}
        .activity-title{font-weight:800;color:var(--text-dark);font-size:13px}
        .activity-description{font-size:12.5px;color:var(--text)}
        .activity-time{font-size:12px;color:var(--text-muted);font-weight:700}

        .ph{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px}
        .ph-label{font-size:11px;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:1.4px;color:var(--oro);font-weight:500;margin-bottom:5px}
        .ph-title{font-family:'Sora',sans-serif;font-size:28px;font-weight:700;color:var(--text-dark);letter-spacing:-.5px;line-height:1.1}
        .ph-sub{font-size:13px;color:var(--text-muted);margin-top:5px}

        .dash-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:22px}
        .kpi-row{grid-column:1/-1;display:grid;grid-template-columns:repeat(4,1fr);gap:22px}
        .kpi-card{background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px 22px;display:flex;flex-direction:column;gap:14px;position:relative;overflow:hidden;transition:box-shadow .25s}
        .kpi-card:hover{box-shadow:var(--neu-out-lg)}
        .kpi-card-bg{position:absolute;bottom:-14px;right:-14px;width:80px;height:80px;border-radius:50%;opacity:.1}
        .kp-top{display:flex;align-items:center;justify-content:space-between}
        .kp-icon{width:44px;height:44px;border-radius:14px;display:grid;place-items:center;font-size:20px;box-shadow:var(--neu-out)}
        .kp-change{display:flex;align-items:center;gap:4px;font-size:11.5px;font-weight:700;padding:4px 10px;border-radius:999px;font-family:'JetBrains Mono',monospace}
        .kp-up{background:#e2f4e7;color:var(--green)}
        .kp-down{background:#fde8e6;color:var(--red)}
        .kp-flat{background:var(--bg-dark);color:var(--text-muted)}
        .kp-value{font-family:'Sora',sans-serif;font-size:40px;font-weight:700;color:var(--text-dark);letter-spacing:-1.5px;line-height:1}
        .kp-label{font-size:11.5px;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.8px;color:var(--text-light);font-weight:500}
        .kp-desc{font-size:12.5px;color:var(--text-muted);margin-top:-6px}

        .welcome-band{grid-column:1/8;background:var(--verde);border-radius:24px;padding:28px 30px;box-shadow:8px 8px 20px rgba(45,80,22,.35),-4px -4px 12px rgba(255,255,255,.25);display:flex;align-items:center;justify-content:space-between;overflow:hidden;position:relative}
        .wb-circles{position:absolute;top:-30px;right:-30px;width:200px;height:200px;border-radius:50%;border:40px solid rgba(255,255,255,.04)}
        .wb-circles2{position:absolute;bottom:-40px;right:40px;width:140px;height:140px;border-radius:50%;border:30px solid rgba(255,255,255,.03)}
        .wb-tag{font-size:10.5px;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:1.2px;color:var(--oro-pale);margin-bottom:8px;opacity:.8}
        .wb-title{font-family:'Sora',sans-serif;font-size:20px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:6px}
        .wb-sub{font-size:13px;color:rgba(255,255,255,.6);max-width:300px}
        .wb-date{display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0}
        .wb-date-day{font-family:'Sora',sans-serif;font-size:48px;font-weight:700;color:var(--oro-bright);line-height:1;letter-spacing:-2px}
        .wb-date-rest{font-size:13px;color:rgba(255,255,255,.5);font-family:'JetBrains Mono',monospace;text-align:right}

        .quick-actions{grid-column:8/-1;background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px}
        .qa-title{font-size:13px;font-weight:700;color:var(--text);margin-bottom:16px;font-family:'Sora',sans-serif}
        .qa-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .qa-item{background:var(--bg);border-radius:16px;box-shadow:var(--neu-out);padding:14px;display:flex;flex-direction:column;align-items:center;gap:8px;cursor:pointer;transition:box-shadow .2s;text-align:center}
        .qa-item:hover{box-shadow:var(--neu-out-lg)}
        .qa-emoji{font-size:22px}
        .qa-label{font-size:11.5px;font-weight:700;color:var(--text)}

        .chart-card{grid-column:1/8;background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px}
        .cc-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
        .cc-title{font-family:'Sora',sans-serif;font-size:15px;font-weight:700;color:var(--text-dark)}
        .cc-sub{font-size:12px;color:var(--text-muted);margin-top:2px}
        .tab-group{display:flex;gap:4px;background:var(--bg);box-shadow:var(--neu-in-sm);border-radius:999px;padding:4px}
        .tg-tab{padding:5px 14px;border-radius:999px;font-size:11.5px;font-weight:700;color:var(--text-muted);cursor:pointer;transition:all .2s;font-family:'JetBrains Mono',monospace}
        .tg-tab.active{background:var(--verde);color:#fff;box-shadow:3px 3px 8px rgba(45,80,22,.3),-1px -1px 4px rgba(255,255,255,.2)}
        .chart-body{height:160px;display:flex;align-items:flex-end;gap:10px;padding:0 4px}
        .cb-bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;height:100%;justify-content:flex-end}
        .cb-bar{width:100%;border-radius:8px 8px 4px 4px;box-shadow:inset -2px -2px 5px rgba(255,255,255,.4),inset 2px 2px 5px rgba(0,0,0,.08);cursor:pointer;transition:opacity .15s;min-height:6px;position:relative}
        .cb-bar:hover{opacity:.8}
        .cb-bar.verde{background:linear-gradient(180deg,var(--verde-mid),var(--verde))}
        .cb-bar.oro{background:linear-gradient(180deg,var(--oro-bright),var(--oro))}
        .cb-month{font-size:9.5px;font-family:'JetBrains Mono',monospace;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px}

        .donut-card{grid-column:8/-1;background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px;display:flex;flex-direction:column}
        .donut-wrap{display:flex;align-items:center;gap:18px;margin-top:16px;flex:1}
        .donut-svg-wrap{position:relative;width:110px;height:110px;flex-shrink:0}
        .donut-svg{width:110px;height:110px;transform:rotate(-90deg)}
        .donut-center{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center}
        .donut-pct{font-family:'Sora',sans-serif;font-size:22px;font-weight:700;color:var(--text-dark);line-height:1}
        .donut-pct-label{font-size:9.5px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:.5px}
        .donut-legend{display:flex;flex-direction:column;gap:9px;flex:1}
        .dl-row{display:flex;align-items:center;gap:9px;font-size:12.5px;color:var(--text)}
        .dl-dot{width:10px;height:10px;border-radius:3px;flex-shrink:0}
        .dl-val{margin-left:auto;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:500;color:var(--text-muted)}

        .progress-card{grid-column:1/5;background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px}
        .pw-items{display:flex;flex-direction:column;gap:16px;margin-top:16px}
        .pw-item-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
        .pw-name{font-size:13px;font-weight:700;color:var(--text)}
        .pw-pct{font-size:12px;font-family:'JetBrains Mono',monospace;color:var(--text-muted);font-weight:500}
        .pw-track{height:10px;background:var(--bg);border-radius:999px;box-shadow:var(--neu-in-sm);overflow:hidden}
        .pw-fill{height:100%;border-radius:999px;box-shadow:inset -1px -1px 3px rgba(255,255,255,.3),inset 1px 1px 3px rgba(0,0,0,.1);transition:width .8s ease}
        .pw-fill.verde{background:linear-gradient(90deg,var(--verde-mid),var(--verde-pale))}
        .pw-fill.oro{background:linear-gradient(90deg,var(--oro-bright),var(--oro-pale))}
        .pw-fill.mix{background:linear-gradient(90deg,var(--verde),var(--oro-bright))}

        .heatmap-card{grid-column:5/9;background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px}
        .hm-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:5px;margin-top:16px}
        .hm-day-label{font-size:9px;font-family:'JetBrains Mono',monospace;text-align:center;color:var(--text-light);text-transform:uppercase;padding-bottom:4px}
        .hm-cell{aspect-ratio:1;border-radius:4px;cursor:pointer;transition:transform .15s;box-shadow:2px 2px 5px var(--neu-shadow-dark),-1px -1px 3px var(--neu-shadow-light)}
        .hm-cell:hover{transform:scale(1.15)}
        .hm-0{background:var(--bg-dark)}
        .hm-1{background:var(--verde-xpale)}
        .hm-2{background:var(--verde-pale)}
        .hm-3{background:var(--verde-mid)}
        .hm-4{background:var(--verde)}

        .table-card{grid-column:9/-1;background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px}
        .rc-list{display:flex;flex-direction:column;gap:10px;margin-top:14px}
        .rc-item{background:var(--bg);border-radius:16px;box-shadow:var(--neu-out);padding:13px 15px;transition:box-shadow .2s;cursor:pointer}
        .rc-item:hover{box-shadow:var(--neu-out-lg)}
        .rc-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px}
        .rc-name{font-size:13px;font-weight:700;color:var(--text-dark)}
        .rc-bar-wrap{display:flex;align-items:center;gap:8px}
        .rc-mini-bar{flex:1;height:5px;border-radius:999px;box-shadow:var(--neu-in-sm);overflow:hidden}
        .rc-mini-fill{height:100%;border-radius:999px;background:linear-gradient(90deg,var(--verde),var(--verde-pale))}
        .rc-num{font-size:11px;font-family:'JetBrains Mono',monospace;color:var(--text-muted);white-space:nowrap}

        .timeline-card{grid-column:1/5;background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:24px}
        .tl-list{display:flex;flex-direction:column;gap:0;margin-top:14px;position:relative}
        .tl-line{position:absolute;left:16px;top:8px;bottom:8px;width:2px;background:linear-gradient(180deg,var(--verde-pale),transparent);border-radius:999px}
        .tl-item{display:flex;gap:14px;padding:9px 0;position:relative}
        .tl-dot{width:32px;height:32px;border-radius:50%;background:var(--bg);box-shadow:var(--neu-out);display:grid;place-items:center}
        .tl-content{display:flex;flex-direction:column;gap:2px}
        .tl-action{font-size:13px;font-weight:700;color:var(--text-dark)}
        .tl-meta{font-size:11.5px;color:var(--text-muted);font-family:'JetBrains Mono',monospace}

        .badge-neu{background:var(--bg);box-shadow:var(--neu-in-sm);border-radius:999px;padding:2px 8px;font-weight:800}
        .bn-green{color:var(--green)}
        .bn-gold{color:var(--oro-bright)}

        .surveys-layout{display:flex;flex-direction:column;gap:18px}
        .filter-neu{display:flex;flex-wrap:wrap;align-items:center;gap:10px;background:var(--bg);box-shadow:var(--neu-out);border-radius:16px;padding:14px}
        .fn-label{font-size:12px;font-weight:700;color:var(--text)}
        .fn-input{background:var(--bg);border:none;box-shadow:var(--neu-in-sm);border-radius:12px;padding:8px 12px;font-size:12.5px;color:var(--text)}
        .fn-search{display:flex;align-items:center;gap:8px;background:var(--bg);box-shadow:var(--neu-in-sm);border-radius:12px;padding:8px 12px;min-width:220px;flex:1}
        .fn-search-icon{opacity:.6}
        .surveys-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
        .survey-card{background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);overflow:hidden;display:flex;flex-direction:column}
        .sc-banner{height:8px;background:var(--bg-dark)}
        .sc-banner.activa{background:var(--verde)}
        .sc-banner.pendiente{background:var(--oro-bright)}
        .sc-body{padding:16px;display:flex;flex-direction:column;gap:12px}
        .sc-top{display:flex;align-items:center;justify-content:space-between}
        .sc-name{font-weight:800;color:var(--text-dark)}
        .sc-desc{font-size:12px;color:var(--text-muted)}
        .sc-stats{display:flex;gap:10px}
        .sc-stat{background:var(--bg);box-shadow:var(--neu-in-sm);border-radius:12px;padding:8px 10px;display:flex;flex-direction:column;gap:2px;min-width:60px;text-align:center}
        .sc-stat-val{font-weight:800;color:var(--text-dark)}
        .sc-stat-label{font-size:11px;color:var(--text-muted)}
        .sc-author{display:flex;align-items:center;gap:8px;color:var(--text-muted);font-size:12px}
        .sc-avatar{width:28px;height:28px;border-radius:10px;background:var(--verde);color:var(--oro-bright);display:grid;place-items:center;font-weight:800}
        .sc-actions{display:flex;gap:8px;flex-wrap:wrap}
        .sc-btn{background:var(--bg);box-shadow:var(--neu-out);border:none;border-radius:12px;padding:6px 10px;font-weight:800;cursor:pointer}
        .sc-btn.del{color:var(--red)}

        .users-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
        .user-card{background:var(--bg);border-radius:24px;box-shadow:var(--neu-out);padding:18px;display:flex;flex-direction:column;gap:10px}
        .uc-avatar{width:48px;height:48px;border-radius:14px;display:grid;place-items:center;font-weight:800}
        .uc-name{font-weight:800;color:var(--text-dark)}
        .uc-email{font-size:12px;color:var(--text-muted)}
        .uc-tags{display:flex;gap:6px;flex-wrap:wrap}
        .uc-stats{display:flex;gap:12px}
        .uc-stat{background:var(--bg);box-shadow:var(--neu-in-sm);border-radius:12px;padding:8px 12px;display:flex;flex-direction:column;gap:2px;min-width:100px}
        .uc-stat-val{font-weight:800;color:var(--text-dark)}
        .uc-stat-label{font-size:11px;color:var(--text-muted)}
        .uc-actions{display:flex;gap:8px}
    </style>
    @stack('styles')
</head>
<body>
    @php
        $user = Auth::user();
        $initials = strtoupper(mb_substr($user->name ?? 'AD', 0, 2));
    @endphp
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
            <a class="nav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                Dashboard
            </a>
            <a class="nav-pill {{ request()->routeIs('surveys.*') ? 'active' : '' }}" href="{{ route('surveys.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Encuestas
            </a>
            <a class="nav-pill {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Usuarios
            </a>
            <a class="nav-pill {{ request()->routeIs('admin.aprobaciones') ? 'active' : '' }}" href="{{ route('admin.aprobaciones') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Aprobaciones
            </a>
            <a class="nav-pill {{ request()->routeIs('statistics.*') ? 'active' : '' }}" href="{{ route('statistics.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Estadísticas
            </a>
            <a class="nav-pill {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}" href="{{ route('activity-logs.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h7"/></svg>
                Bitácora
            </a>
        </div>
        <div class="nav-right">
            <div class="status-chip">
                <div class="status-led"></div>
                Sistema operando
            </div>
            <div class="avatar-btn">{{ $initials }}</div>
        </div>
    </nav>
    <div class="wrapper">
        <section class="page" id="app-content">
            @yield('content')
        </section>
    </div>
    @stack('scripts')
</body>
</html>
