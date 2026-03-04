<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex – Plataforma de Encuestas Institucional</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <style>
        :root {
            --verde: #2D6A2D;
            --verde-oscuro: #1a4a1a;
            --verde-claro: #4a8f4a;
            --verde-menta: #d4ead4;
            --oro: #C9A84C;
            --oro-claro: #e8c96b;
            --crema: #F9F6EF;
            --blanco: #ffffff;
            --gris-texto: #2a2a2a;
            --gris-suave: #6b6b6b;
            --borde: rgba(45,106,45,0.15);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--crema);
            color: var(--gris-texto);
            overflow-x: hidden;
        }

        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 0 60px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(249,246,239,0.90);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--borde);
            animation: slideDown 0.6s ease both;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to   { transform: translateY(0);     opacity: 1; }
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .logo-escudo {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde-claro) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 18px;
            color: var(--oro-claro);
            letter-spacing: -1px;
            box-shadow: 0 4px 16px rgba(45,106,45,0.35);
            flex-shrink: 0;
        }

        .logo-text { display: flex; flex-direction: column; line-height: 1; }
        .logo-text .siei {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--verde-claro);
            font-weight: 500;
        }
        .logo-text .uaemex {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            font-weight: 700;
            color: var(--verde-oscuro);
            letter-spacing: -0.3px;
        }

        .nav-actions { display: flex; align-items: center; gap: 12px; }

        .btn-ghost {
            padding: 9px 22px;
            border: 1.5px solid var(--verde);
            border-radius: 8px;
            background: transparent;
            color: var(--verde-oscuro);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.22s ease;
            text-decoration: none;
        }
        .btn-ghost:hover {
            background: var(--verde-menta);
            border-color: var(--verde-oscuro);
        }

        .btn-solid {
            padding: 10px 26px;
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde) 100%);
            border: none;
            border-radius: 8px;
            color: var(--blanco);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.22s ease;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(45,106,45,0.35);
        }
        .btn-solid:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(45,106,45,0.45);
        }

        .hero {
            min-height: 100vh;
            padding: 110px 60px 60px;
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 55%;
            height: 100%;
            background: linear-gradient(135deg, var(--verde-menta) 0%, rgba(212,234,212,0.3) 100%);
            clip-path: polygon(12% 0%, 100% 0%, 100% 100%, 0% 100%);
            z-index: 0;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 72px; left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--oro) 0%, var(--verde-claro) 40%, transparent 100%);
            opacity: 0.5;
        }

        .deco-circle {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            border: 1px solid rgba(45,106,45,0.12);
            right: 10%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 0;
        }
        .deco-circle::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 1px solid rgba(45,106,45,0.08);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .badge-institucional {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px 6px 8px;
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-radius: 100px;
            margin-bottom: 32px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            animation: fadeUp 0.7s 0.2s ease both;
        }
        .badge-dot {
            width: 26px;
            height: 26px;
            background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-claro));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .badge-dot svg { width: 12px; height: 12px; fill: white; }
        .badge-label {
            font-family: 'DM Mono', monospace;
            font-size: 10.5px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--verde-oscuro);
            font-weight: 500;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(46px, 6vw, 78px);
            font-weight: 900;
            line-height: 1.05;
            color: var(--verde-oscuro);
            margin-bottom: 8px;
            animation: fadeUp 0.7s 0.35s ease both;
        }

        .hero-title .accent-line {
            display: block;
            color: var(--verde);
            position: relative;
        }
        .hero-title .accent-line::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--oro) 0%, var(--oro-claro) 100%);
            border-radius: 2px;
            opacity: 0.7;
        }

        .hero-subtitle {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 3.5vw, 46px);
            font-weight: 400;
            color: var(--gris-suave);
            margin-bottom: 28px;
            animation: fadeUp 0.7s 0.45s ease both;
            font-style: italic;
        }

        .hero-description {
            font-size: 16px;
            line-height: 1.75;
            color: var(--gris-suave);
            max-width: 520px;
            margin-bottom: 44px;
            animation: fadeUp 0.7s 0.55s ease both;
            font-weight: 300;
        }
        .hero-description strong {
            color: var(--gris-texto);
            font-weight: 500;
        }

        .hero-ctas {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 52px;
            animation: fadeUp 0.7s 0.65s ease both;
        }

        .cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde) 100%);
            color: var(--blanco);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(45,106,45,0.4);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .cta-primary::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.1);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .cta-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 32px rgba(45,106,45,0.5); }
        .cta-primary:hover::after { opacity: 1; }
        .cta-primary svg { width: 18px; height: 18px; }

        .cta-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 28px;
            background: var(--blanco);
            color: var(--verde-oscuro);
            border: 1.5px solid var(--borde);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .cta-secondary:hover {
            border-color: var(--verde-claro);
            background: var(--verde-menta);
            transform: translateY(-2px);
        }

        .hero-trust {
            display: flex;
            align-items: center;
            gap: 24px;
            animation: fadeUp 0.7s 0.75s ease both;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 400;
            color: var(--verde-claro);
        }
        .trust-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .trust-divider {
            width: 1px;
            height: 16px;
            background: var(--borde);
        }

        .hero-visual {
            position: relative;
            z-index: 2;
            animation: fadeUp 0.8s 0.4s ease both;
        }

        .dashboard-card {
            background: #0f1923;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 40px 80px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }
        .dashboard-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 70% 0%, rgba(45,106,45,0.25) 0%, transparent 60%);
        }

        .dc-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .dc-dots { display: flex; gap: 6px; }
        .dc-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
        }
        .dc-dot:nth-child(1) { background: #ff5f57; }
        .dc-dot:nth-child(2) { background: #ffbd2e; }
        .dc-dot:nth-child(3) { background: #28ca41; }
        .dc-title-bar {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .dc-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
            margin-bottom: 18px;
        }

        .dc-stat {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            padding: 14px;
        }
        .dc-stat-label {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .dc-stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: white;
        }
        .dc-stat-change {
            font-size: 10px;
            color: #4ade80;
            margin-top: 2px;
            font-weight: 500;
        }

        .dc-chart-area {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 14px;
        }
        .dc-chart-label {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            color: rgba(255,255,255,0.3);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 5px;
            height: 60px;
        }
        .bar {
            flex: 1;
            background: linear-gradient(180deg, #4ade80 0%, #22c55e 100%);
            border-radius: 4px 4px 0 0;
            opacity: 0.8;
            animation: growBar 1s ease both;
            transform-origin: bottom;
        }
        @keyframes growBar {
            from { transform: scaleY(0); opacity: 0; }
            to   { transform: scaleY(1); opacity: 0.8; }
        }
        .bar:nth-child(1) { height: 35%; animation-delay: 0.8s; }
        .bar:nth-child(2) { height: 55%; animation-delay: 0.9s; }
        .bar:nth-child(3) { height: 70%; animation-delay: 1.0s; }
        .bar:nth-child(4) { height: 45%; animation-delay: 1.1s; }
        .bar:nth-child(5) { height: 85%; animation-delay: 1.2s; background: linear-gradient(180deg, var(--oro-claro) 0%, var(--oro) 100%); }
        .bar:nth-child(6) { height: 60%; animation-delay: 1.3s; }
        .bar:nth-child(7) { height: 90%; animation-delay: 1.4s; }
        .bar:nth-child(8) { height: 50%; animation-delay: 1.5s; }
        .bar:nth-child(9) { height: 75%; animation-delay: 1.6s; }
        .bar:nth-child(10) { height: 95%; animation-delay: 1.7s; background: linear-gradient(180deg, #60a5fa 0%, #3b82f6 100%); }
        .bar:nth-child(11) { height: 65%; animation-delay: 1.8s; }
        .bar:nth-child(12) { height: 80%; animation-delay: 1.9s; }

        .dc-bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .dc-mini-stat {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .dc-mini-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }
        .icon-green { background: rgba(74,222,128,0.15); }
        .icon-gold  { background: rgba(201,168,76,0.15); }
        .dc-mini-label {
            font-family: 'DM Mono', monospace;
            font-size: 8px;
            color: rgba(255,255,255,0.3);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .dc-mini-value {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: white;
        }

        .floating-card {
            position: absolute;
            bottom: -20px;
            left: -28px;
            background: var(--blanco);
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.18);
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1px solid rgba(0,0,0,0.06);
            animation: floatCard 3s ease-in-out infinite;
            z-index: 10;
        }
        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-6px); }
        }
        .fc-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-claro));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .fc-icon svg { width: 20px; height: 20px; fill: white; }
        .fc-label {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            color: var(--gris-suave);
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .fc-value {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--verde-oscuro);
            line-height: 1;
        }
        .fc-subtext {
            font-size: 11px;
            color: #4ade80;
            font-weight: 500;
            margin-top: 1px;
        }

        .floating-badge {
            position: absolute;
            top: -16px;
            right: -16px;
            background: linear-gradient(135deg, var(--oro) 0%, var(--oro-claro) 100%);
            border-radius: 12px;
            padding: 10px 16px;
            box-shadow: 0 8px 24px rgba(201,168,76,0.4);
            animation: floatBadge 3.5s ease-in-out infinite;
            z-index: 10;
        }
        @keyframes floatBadge {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50%       { transform: translateY(-5px) rotate(2deg); }
        }
        .fb-value {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--verde-oscuro);
            line-height: 1;
        }
        .fb-label {
            font-family: 'DM Mono', monospace;
            font-size: 8px;
            color: rgba(26,74,26,0.7);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .stats-band {
            background: var(--verde-oscuro);
            padding: 50px 60px;
            position: relative;
            overflow: hidden;
        }
        .stats-band::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 100%, rgba(201,168,76,0.12) 0%, transparent 60%);
        }
        .stats-band::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--oro), transparent);
        }

        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        .stat-item {
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.1);
            padding: 0 20px;
        }
        .stat-item:last-child { border-right: none; }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 46px;
            font-weight: 900;
            color: var(--blanco);
            line-height: 1;
            margin-bottom: 6px;
        }
        .stat-number span {
            color: var(--oro);
        }
        .stat-desc {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .features {
            padding: 100px 60px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .section-header {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: end;
            margin-bottom: 60px;
        }

        .section-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--verde-claro);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-eyebrow::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--oro);
            display: block;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 700;
            color: var(--verde-oscuro);
            line-height: 1.15;
        }

        .section-link {
            font-size: 13px;
            font-weight: 500;
            color: var(--verde-claro);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid var(--borde);
            padding-bottom: 2px;
            transition: color 0.2s;
        }
        .section-link:hover { color: var(--verde-oscuro); }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-radius: 18px;
            padding: 36px 32px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .feature-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--verde-oscuro), var(--verde-claro));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            box-shadow: 0 20px 50px rgba(45,106,45,0.12);
            transform: translateY(-4px);
            border-color: rgba(45,106,45,0.25);
        }
        .feature-card:hover::after { transform: scaleX(1); }

        .feature-card.featured {
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde) 100%);
            color: white;
            border-color: transparent;
        }
        .feature-card.featured .feature-icon-wrap {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.1);
        }
        .feature-card.featured .feature-icon { color: var(--oro-claro); }
        .feature-card.featured .feature-title { color: var(--blanco); }
        .feature-card.featured .feature-desc { color: rgba(255,255,255,0.7); }
        .feature-card.featured::after { display: none; }

        .feature-icon-wrap {
            width: 52px; height: 52px;
            border: 1px solid var(--borde);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
            background: var(--crema);
        }
        .feature-icon { font-size: 22px; }

        .feature-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--verde-oscuro);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .feature-desc {
            font-size: 14px;
            line-height: 1.7;
            color: var(--gris-suave);
            font-weight: 300;
        }

        .cta-section {
            margin: 0 60px 100px;
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, #1a5e1a 50%, var(--verde) 100%);
            border-radius: 28px;
            padding: 80px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .cta-section::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--oro-claro);
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 54px);
            font-weight: 900;
            color: var(--blanco);
            line-height: 1.1;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .cta-subtitle {
            font-size: 16px;
            color: rgba(255,255,255,0.65);
            margin-bottom: 44px;
            position: relative;
            z-index: 1;
            font-weight: 300;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .cta-btn-primary {
            padding: 16px 38px;
            background: linear-gradient(135deg, var(--oro) 0%, var(--oro-claro) 100%);
            color: var(--verde-oscuro);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 8px 28px rgba(201,168,76,0.4);
            transition: all 0.25s ease;
        }
        .cta-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(201,168,76,0.55);
        }

        .cta-btn-secondary {
            padding: 16px 30px;
            background: rgba(255,255,255,0.08);
            color: var(--blanco);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(4px);
        }
        .cta-btn-secondary:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.35);
            transform: translateY(-2px);
        }

        footer {
            border-top: 1px solid var(--borde);
            padding: 32px 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .footer-logo-mark {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-claro));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 13px;
            font-weight: 900;
            color: var(--oro-claro);
        }
        .footer-logo-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--gris-suave);
            font-weight: 400;
        }

        .footer-copy {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: var(--gris-suave);
            letter-spacing: 0.06em;
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }
        .footer-links a {
            font-size: 13px;
            color: var(--gris-suave);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--verde-oscuro); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .corner-deco {
            position: absolute;
            top: 80px;
            right: 30px;
            width: 80px;
            height: 80px;
            border-top: 2px solid var(--oro);
            border-right: 2px solid var(--oro);
            border-radius: 0 12px 0 0;
            opacity: 0.4;
            z-index: 1;
        }

        .live-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
            margin-right: 6px;
            vertical-align: middle;
        }
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(74,222,128,0.5); }
            50%       { box-shadow: 0 0 0 6px rgba(74,222,128,0); }
        }
    </style>
</head>
<body>

<nav>
    <a href="#" class="nav-logo">
        <div class="logo-escudo">
            <div style="background:#fff;border-radius:8px;margin:4px;width:calc(100% - 8px);height:calc(100% - 8px);display:flex;align-items:center;justify-content:center;box-shadow:inset 0 0 0 1px rgba(0,0,0,0.04);">
                <img src="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y" alt="UAEMex Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius:6px;">
            </div>
        </div>
        <div class="logo-text">
            <span class="siei">SIEI</span>
            <span class="uaemex">UAEMex</span>
        </div>
    </a>
  
</nav>

<section class="hero">
    <div class="deco-circle"></div>
    <div class="corner-deco"></div>

    <div class="hero-content">
        <div class="">          
        </div>

        <h1 class="hero-title">
            Plataforma de
            <span class="accent-line">Encuestas</span>
        </h1>
        <p class="hero-subtitle">Institucional UAEMex</p>

        <p class="hero-description">
            Bienvenido al sistema oficial de la <strong>Universidad Autónoma del Estado de México.</strong> Una herramienta moderna para la recopilación, análisis y gestión de datos institucionales con la más alta seguridad y confiabilidad.
        </p>

        <div class="hero-ctas">
            @auth
                <a href="{{ route('dashboard') }}" class="cta-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Ir al Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="cta-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Iniciar Sesión
                </a>
                <a href="#features" class="cta-secondary">
                    Conocer más →
                </a>
            @endauth
        </div>

        <div class="hero-trust">
            <span class="trust-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span class="live-dot"></span>Datos en tiempo real
            </span>
            <div class="trust-divider"></div>
            <span class="trust-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Seguro y confiable
            </span>
            <div class="trust-divider"></div>
            <span class="trust-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                UAEM Certificado
            </span>
        </div>
    </div>

    <div class="hero-visual">
        <div class="dashboard-card">
            <div class="dc-topbar">
                <div class="dc-dots">
                    <div class="dc-dot"></div>
                    <div class="dc-dot"></div>
                    <div class="dc-dot"></div>
                </div>
                <div class="dc-title-bar">SIEI Dashboard · Ciclo 2025–2026</div>
                <div style="width:36px"></div>
            </div>

            <div class="dc-stats-grid">
                <div class="dc-stat">
                    <div class="dc-stat-label">Respuestas</div>
                    <div class="dc-stat-value">1,240</div>
                    <div class="dc-stat-change">↑ +18% esta semana</div>
                </div>
                <div class="dc-stat">
                    <div class="dc-stat-label">Facultades</div>
                    <div class="dc-stat-value">31</div>
                    <div class="dc-stat-change">↑ Participando</div>
                </div>
                <div class="dc-stat">
                    <div class="dc-stat-label">Completado</div>
                    <div class="dc-stat-value">94<span style="font-size:14px;color:rgba(255,255,255,0.4)">%</span></div>
                    <div class="dc-stat-change">↑ Meta alcanzada</div>
                </div>
            </div>

            <div class="dc-chart-area">
                <div class="dc-chart-label">Respuestas por mes · 2025</div>
                <div class="bar-chart">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div>

            <div class="dc-bottom-row">
                <div class="dc-mini-stat">
                    <div class="dc-mini-icon icon-green">📋</div>
                    <div>
                        <div class="dc-mini-label">Encuestas activas</div>
                        <div class="dc-mini-value">12</div>
                    </div>
                </div>
                <div class="dc-mini-stat">
                    <div class="dc-mini-icon icon-gold">⏱</div>
                    <div>
                        <div class="dc-mini-label">Tiempo promedio</div>
                        <div class="dc-mini-value">4.2 min</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="floating-card">
            <div class="fc-icon">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <div class="fc-label">Respuestas hoy</div>
                <div class="fc-value">+1,240</div>
                <div class="fc-subtext">↑ récord del día</div>
            </div>
        </div>

        <div class="floating-badge">
            <div class="fb-value">99.9%</div>
            <div class="fb-label">Uptime</div>
        </div>
    </div>
</section>


<footer>
    <div class="footer-copy">© {{ date('Y') }} Universidad Autónoma del Estado de México. Todos los derechos reservados.</div>
</footer>

</body>
</html>
