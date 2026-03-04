<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title', 'Mi Espacio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --uaemex-green: #1a5c2a;
            --uaemex-green-dark: #12411d;
            --uaemex-green-light: #2a7b3d;
            --uaemex-gold: #c9a227;
            --uaemex-gold-dark: #a8861e;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --success: #059669;
            --warning: #D97706;
            --danger: #DC2626;
            --info: #2563EB;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .bg-uaemex {
            background-color: var(--uaemex-green);
        }

        .text-uaemex {
            color: var(--uaemex-green);
        }

        .border-uaemex {
            border-color: var(--uaemex-green);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .top-header {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-dark) 100%);
            color: white;
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            border-bottom: 2px solid var(--uaemex-gold);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .university-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .university-shield {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--uaemex-green);
            font-size: 1.125rem;
            box-shadow: var(--shadow);
        }

        .brand-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.125rem;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .brand-text p {
            font-size: 0.75rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .system-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            font-size: 0.875rem;
            backdrop-filter: blur(10px);
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            background: #10B981;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            color: white;
        }

        .header-icon-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .user-avatar-btn {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-avatar-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .user-dropdown {
            position: absolute;
            right: 0;
            top: 52px;
            min-width: 220px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            padding: 0.75rem 0.75rem 0.75rem;
            z-index: 1100;
        }

        .user-dropdown-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-100);
            margin-bottom: 0.5rem;
        }

        .user-dropdown-avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: var(--uaemex-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.82rem;
            color: white;
        }

        .user-dropdown-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-900);
        }

        .user-dropdown-role {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.125rem 0.5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--gray-200);
            color: var(--gray-700);
            margin-top: 0.15rem;
        }

        .user-dropdown-footer {
            padding-top: 0.5rem;
            display: flex;
            justify-content: flex-end;
        }

        .btn-logout-admin {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            border: 1px solid var(--gray-300);
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--gray-700);
            background: white;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-logout-admin:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .top-bar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }

        .bar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .university-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .shield {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 1rem;
        }

        .brand-info h1 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .brand-info p {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .nav-menu {
            display: flex;
            gap: 0.25rem;
        }

        .nav-link {
            padding: 0.625rem 1rem;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9375rem;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover {
            background: var(--gray-100);
            color: var(--gray-900);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-light) 100%);
            color: white;
        }

        .bar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notif-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            width: 16px;
            height: 16px;
            border-radius: 999px;
            background: #ef4444;
            font-size: 0.625rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid white;
        }

        .header-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 0.75rem);
            width: 320px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.16);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            z-index: 50;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-100);
        }

        .dropdown-header-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--gray-500);
        }

        .dropdown-mark-all {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--uaemex-green);
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 999px;
        }

        .dropdown-mark-all:hover {
            background: var(--gray-100);
        }

        .dropdown-body {
            padding: 0.75rem 0.75rem 0.9rem;
            max-height: 260px;
            overflow-y: auto;
        }

        .dropdown-empty {
            font-size: 0.75rem;
            color: var(--gray-400);
            text-align: center;
            padding: 1rem 0.5rem;
        }

        .notif-item {
            width: 100%;
            text-align: left;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            padding: 0.65rem 0.75rem;
            cursor: pointer;
            transition: all 0.15s;
            margin-bottom: 0.5rem;
        }

        .notif-item:hover {
            background: var(--gray-50);
            border-color: var(--uaemex-green);
        }

        .notif-item-title {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.15rem;
        }

        .notif-item-msg {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .notif-item-time {
            font-size: 0.6875rem;
            color: var(--gray-400);
            margin-top: 0.2rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.45rem 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 999px;
            cursor: pointer;
            background: white;
            transition: all 0.2s;
        }

        .user-menu:hover {
            border-color: var(--uaemex-green);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.875rem;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-900);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .user-dropdown-body {
            padding: 0.75rem;
        }

        .user-dropdown-link {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 0.7rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--gray-700);
            text-decoration: none;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.15s;
        }

        .user-dropdown-link i {
            font-size: 0.875rem;
            color: var(--gray-400);
        }

        .user-dropdown-link:hover {
            background: var(--gray-50);
            color: var(--gray-900);
        }

        .user-dropdown-link.danger {
            color: #b91c1c;
        }

        .user-dropdown-link.danger:hover {
            background: #fef2f2;
            color: #7f1d1d;
        }

        .admin-layout {
            display: flex;
        }

        .navigation-bar {
            background: var(--uaemex-green);
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: var(--shadow-sm);
            position: fixed;
            top: 72px;
            left: 0;
            bottom: 0;
            width: 240px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            padding: 1.25rem 0.75rem;
        }

        .nav-tabs {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            overflow-y: auto;
            padding-right: 0.25rem;
        }

        .nav-tab {
            padding: 0.7rem 1.1rem;
            margin: 0 0.25rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 999px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .nav-tab svg {
            flex-shrink: 0;
        }

        .nav-tab:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-tab.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            font-weight: 600;
            border-left: 3px solid var(--uaemex-gold);
        }

        .tab-badge {
            background: var(--danger);
            color: white;
            padding: 0.125rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .main-wrapper {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
            margin-left: 260px;
            font-size: 0.875rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--gray-900);
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: var(--gray-500);
            font-size: 0.875rem;
        }

        .page-actions {
            display: flex;
            gap: 0.75rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--uaemex-green);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, rgba(0, 104, 56, 0.1) 0%, rgba(0, 104, 56, 0.05) 100%);
        }

        .stat-icon.gold {
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.1) 0%, rgba(201, 169, 97, 0.05) 100%);
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1;
            margin-bottom: 0.5rem;
            font-variant-numeric: tabular-nums;
        }

        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .stat-change.positive {
            background: rgba(5, 150, 105, 0.1);
            color: var(--success);
        }

        .stat-change.negative {
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-dark) 100%);
            border-radius: 16px;
            padding: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(201, 169, 97, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .greeting {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .greeting-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .quick-stat {
            display: flex;
            flex-direction: column;
        }

        .quick-stat-value {
            font-size: 2.1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-variant-numeric: tabular-nums;
        }

        .quick-stat-label {
            font-size: 0.9375rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .action-card {
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.75rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--uaemex-green);
        }

        .action-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .action-icon.primary {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-light) 100%);
        }

        .action-icon.gold {
            background: linear-gradient(135deg, var(--uaemex-gold) 0%, var(--uaemex-gold-dark) 100%);
        }

        .action-icon.blue {
            background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
        }

        .action-content h3 {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
        }

        .action-content p {
            font-size: 0.9375rem;
            color: var(--gray-600);
            line-height: 1.5;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-100);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .view-all-link {
            color: var(--uaemex-green);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s;
        }

        .view-all-link:hover {
            gap: 0.625rem;
        }

        .survey-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .survey-item {
            padding: 1.25rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .survey-item:hover {
            border-color: var(--uaemex-green);
            box-shadow: var(--shadow-md);
        }

        .survey-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .survey-title {
            font-size: 1.0625rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .survey-meta {
            display: flex;
            gap: 1.25rem;
            font-size: 0.8125rem;
            color: var(--gray-500);
        }

        .survey-meta span {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-badge.active {
            background: rgba(5, 150, 105, 0.1);
            color: var(--success);
        }

        .status-badge.draft {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .status-badge.closed {
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
        }

        .survey-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .survey-stat {
            text-align: center;
        }

        .survey-stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
            font-variant-numeric: tabular-nums;
        }

        .survey-stat-label {
            font-size: 0.8125rem;
            color: var(--gray-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
        }

        .activity-item:hover {
            background: var(--gray-50);
        }

        .activity-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .activity-icon-box.green {
            background: rgba(0, 104, 56, 0.1);
        }

        .activity-icon-box.gold {
            background: rgba(201, 169, 97, 0.1);
        }

        .activity-icon-box.blue {
            background: rgba(37, 99, 235, 0.1);
        }

        .activity-info {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            font-size: 0.9375rem;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .activity-description {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .activity-time {
            font-size: 0.8125rem;
            color: var(--gray-400);
            font-weight: 500;
        }

        .templates-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }

        .template-card {
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .template-card:hover {
            transform: translateY(-2px);
            border-color: var(--uaemex-gold);
            box-shadow: var(--shadow-lg);
        }

        .template-icon-box {
            width: 52px;
            height: 52px;
            background: var(--gray-100);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .template-title {
            font-size: 1.0625rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
        }

        .template-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.5;
            margin-bottom: 0.75rem;
        }

        .template-uses {
            font-size: 0.8125rem;
            color: var(--gray-500);
            font-weight: 600;
        }

        .chart-area {
            position: relative;
            height: 280px;
            background: var(--gray-50);
            border-radius: 10px;
            padding: 1rem;
        }

        .chart-area canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .chart-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--gray-400);
            pointer-events: none;
        }

        .chart-placeholder-icon {
            font-size: 3rem;
            margin-bottom: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-light) 100%);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            background: white;
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-outline:hover {
            border-color: var(--gray-400);
            background: var(--gray-50);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid transparent;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--uaemex-green);
            color: #ffffff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-primary:hover {
            background: var(--uaemex-green-dark);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--uaemex-green);
            border-color: var(--uaemex-green);
        }

        .btn-secondary:hover {
            background: rgba(26, 92, 42, 0.06);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--uaemex-gold) 0%, var(--uaemex-gold-dark) 100%);
            color: #ffffff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        }

        .btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.16);
        }

        .btn-outline {
            background: transparent;
            color: var(--uaemex-green);
            border-color: var(--uaemex-green);
        }

        .btn-outline:hover {
            background: rgba(26, 92, 42, 0.06);
        }

        @media (max-width: 1200px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .templates-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem 1rem;
            }

            .nav-menu {
                display: none;
            }

            .search-box {
                width: 200px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .greeting {
                font-size: 1.5rem;
            }

            .quick-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .header-dropdown {
                width: 100%;
                max-width: 18rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <header class="top-header">
        <div class="header-left">
            <div class="university-brand">
                <div class="university-shield">
                    <img src="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y" alt="UAEMex Logo" style="width: 90%; height: 90%; object-fit: contain; border-radius: 6px;">
                </div>
                <div class="brand-text">
                    <h1>SIEI - UAEMex</h1>
                    <p>Sistema Integral de Encuestas Institucionales</p>
                </div>
            </div>
            <div class="system-status">
                <span class="status-indicator"></span>
                <span>Panel de editor</span>
            </div>
        </div>
        <div class="header-right">
            <div style="display:flex;align-items:center;gap:0.75rem;position:relative;">
                <div style="position:relative;">
                    <button id="notificationsBtn" class="header-icon-btn" type="button">
                        <i class="fas fa-bell"></i>
                        <span id="notificationsBadge" class="notif-badge hidden"></span>
                    </button>
                    <div id="notificationsDropdown" class="header-dropdown hidden">
                        <div class="dropdown-header">
                            <span class="dropdown-header-title">Notificaciones</span>
                            <button id="notificationsMarkAll" class="dropdown-mark-all" type="button">Marcar todas</button>
                        </div>
                        <div class="dropdown-body">
                            <div id="notificationsList">
                                <div class="dropdown-empty">No tienes notificaciones nuevas.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="position:relative;">
                    <button id="userMenuBtn" class="user-avatar-btn" type="button">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </button>
                    <div id="userMenuDropdown" class="user-dropdown hidden">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-avatar">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                                <div class="user-dropdown-role">
                                    @switch(Auth::user()->role)
                                        @case('admin') Administrador @break
                                        @case('editor') Editor @break
                                        @default Usuario
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <div class="user-dropdown-footer" style="justify-content:space-between;width:100%;">
                            <a href="{{ route('profile.show') }}" class="btn-logout-admin" style="margin-right:0.5rem;">
                                <i class="fas fa-user-cog"></i>
                                Mi perfil
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-logout-admin">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="admin-layout">
        <nav class="navigation-bar">
            <div class="nav-tabs">
                <a href="{{ route('editor.dashboard') }}"
                   class="nav-tab {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Mi Espacio
                </a>
                <a href="{{ route('surveys.index') }}"
                   class="nav-tab {{ request()->routeIs('surveys.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Mis Encuestas
                </a>
                <a href="{{ route('statistics.index') }}"
                   class="nav-tab {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Estadísticas
                </a>
                <a href="{{ route('editor.encuestas.plantillas') }}"
                   class="nav-tab {{ request()->routeIs('editor.encuestas.plantillas') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    Plantillas
                </a>
            </div>
        </nav>
        <main class="main-wrapper">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userMenuDropdown = document.getElementById('userMenuDropdown');

            const notificationsBtn = document.getElementById('notificationsBtn');
            const notificationsDropdown = document.getElementById('notificationsDropdown');
            const notificationsBadge = document.getElementById('notificationsBadge');
            const notificationsList = document.getElementById('notificationsList');
            const notificationsMarkAll = document.getElementById('notificationsMarkAll');

            if (userMenuBtn && userMenuDropdown) {
                userMenuBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    userMenuDropdown.classList.toggle('hidden');
                    if (notificationsDropdown) {
                        notificationsDropdown.classList.add('hidden');
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                        userMenuDropdown.classList.add('hidden');
                    }
                });
            }

            if (notificationsBtn && notificationsDropdown) {
                notificationsBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    notificationsDropdown.classList.toggle('hidden');
                    if (userMenuDropdown) {
                        userMenuDropdown.classList.add('hidden');
                    }
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
                        if (item.url) {
                            btn.addEventListener('click', function () {
                                window.location.href = item.url;
                            });
                        }
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
                    .then(function (response) { return response.json(); })
                    .then(function (data) { renderNotifications(data); })
                    .catch(function () { });
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
                        .then(function (response) { return response.json(); })
                        .then(function () { fetchNotifications(); })
                        .catch(function () { });
                });
            }

            fetchNotifications();
            setInterval(fetchNotifications, 15000);
        });
    </script>

    @stack('scripts')
</body>
</html>
