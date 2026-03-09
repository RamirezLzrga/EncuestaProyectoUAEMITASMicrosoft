@extends('layouts.auth')

@section('title', 'Iniciar Sesión')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --verde:        #2D6A2D;
    --verde-oscuro: #1a4a1a;
    --verde-claro:  #4a8f4a;
    --verde-menta:  #d4ead4;
    --oro:          #C9A84C;
    --oro-claro:    #e8c96b;
    --crema:        #F9F6EF;
    --blanco:       #ffffff;
    --gris-texto:   #2a2a2a;
    --gris-suave:   #6b6b6b;
    --borde:        rgba(45,106,45,0.15);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  .login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'DM Sans', sans-serif;
    background-color: var(--crema);
    position: relative;
    overflow: hidden;
    padding: 40px 20px;
  }

  .login-page::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
      radial-gradient(ellipse at 20% 50%, rgba(45,106,45,0.12) 0%, transparent 55%),
      radial-gradient(ellipse at 80% 20%, rgba(201,168,76,0.10) 0%, transparent 50%),
      radial-gradient(ellipse at 60% 90%, rgba(45,106,45,0.08) 0%, transparent 50%);
    pointer-events: none;
    z-index: 0;
  }

  .login-page::after {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      linear-gradient(rgba(45,106,45,0.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(45,106,45,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
    z-index: 0;
  }

  .gold-top-bar {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--oro), var(--oro-claro), transparent);
    z-index: 100;
  }

  .login-card {
    position: relative;
    z-index: 1;
    background: var(--blanco);
    border-radius: 24px;
    width: 100%;
    max-width: 440px;
    box-shadow:
      0 4px 6px rgba(0,0,0,0.04),
      0 20px 60px rgba(45,106,45,0.12),
      0 0 0 1px var(--borde);
    overflow: hidden;
    animation: cardIn 0.6s cubic-bezier(0.22,1,0.36,1) both;
  }

  @keyframes cardIn {
    from { opacity: 0; transform: translateY(24px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0)    scale(1);    }
  }

  .card-header {
    background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde) 100%);
    padding: 36px 36px 48px;
    position: relative;
    overflow: hidden;
    text-align: center;
  }

  .card-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }

  .header-deco-1 {
    position: absolute;
    width: 160px; height: 160px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.08);
    top: -40px; right: -40px;
  }
  .header-deco-2 {
    position: absolute;
    width: 100px; height: 100px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.06);
    bottom: 20px; left: -30px;
  }

  .logo-wrap {
    position: relative;
    z-index: 1;
    display: inline-flex;
    margin-bottom: 20px;
  }

  .logo-escudo {
    width: 68px; height: 68px;
    background: var(--blanco);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    box-shadow:
      0 8px 30px rgba(0,0,0,0.2),
      0 0 0 4px rgba(255,255,255,0.15);
  }

  .logo-inner {
    width: 54px; height: 54px;
    background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-claro));
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-weight: 900;
    font-size: 22px;
    color: var(--oro-claro);
    letter-spacing: -1px;
  }

  .live-badge {
    position: absolute;
    top: -4px; right: -4px;
    width: 14px; height: 14px;
    background: #4ade80;
    border-radius: 50%;
    border: 2px solid var(--blanco);
    animation: livePulse 2s ease-in-out infinite;
  }
  @keyframes livePulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(74,222,128,0.5); }
    50%       { box-shadow: 0 0 0 5px rgba(74,222,128,0); }
  }

  .header-title {
    position: relative;
    z-index: 1;
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    font-weight: 700;
    color: var(--blanco);
    letter-spacing: -0.3px;
    line-height: 1.1;
    margin-bottom: 6px;
  }

  .header-subtitle {
    position: relative;
    z-index: 1;
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    color: rgba(255,255,255,0.55);
    letter-spacing: 0.16em;
    text-transform: uppercase;
    margin-bottom: 14px;
  }

  .header-gold-line {
    position: relative;
    z-index: 1;
    display: inline-block;
    width: 40px; height: 3px;
    background: linear-gradient(90deg, var(--oro), var(--oro-claro));
    border-radius: 2px;
  }

  .card-body {
    padding: 36px 36px 28px;
  }

  .field-label {
    display: block;
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--verde-oscuro);
    margin-bottom: 8px;
  }

  .input-wrap {
    position: relative;
    margin-bottom: 20px;
  }

  .input-icon {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    display: flex;
    align-items: center;
    padding-left: 14px;
    color: var(--verde-claro);
    pointer-events: none;
    transition: color 0.2s;
  }

  .field-input {
    width: 100%;
    padding: 13px 16px 13px 42px;
    border: 1.5px solid rgba(45,106,45,0.2);
    border-radius: 10px;
    background: var(--crema);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: var(--gris-texto);
    outline: none;
    transition: all 0.22s ease;
  }

  .field-input::placeholder {
    color: #bbb;
    font-weight: 300;
  }

  .field-input:focus {
    border-color: var(--verde);
    background: var(--blanco);
    box-shadow: 0 0 0 4px rgba(45,106,45,0.08);
  }

  .field-input:focus + .input-icon,
  .input-wrap:focus-within .input-icon {
    color: var(--verde-oscuro);
  }

  .field-error {
    color: #dc2626;
    font-size: 11px;
    margin-top: 5px;
    font-weight: 400;
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .options-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
  }

  .remember-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--gris-suave);
    cursor: pointer;
    user-select: none;
  }

  .remember-label input[type="checkbox"] {
    width: 16px; height: 16px;
    accent-color: var(--verde);
    border-radius: 4px;
    cursor: pointer;
  }

  .forgot-link {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: var(--verde);
    text-decoration: none;
    transition: color 0.2s;
  }
  .forgot-link:hover { color: var(--verde-oscuro); text-decoration: underline; }

  .btn-login {
    width: 100%;
    padding: 15px 24px;
    background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde) 100%);
    color: var(--blanco);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 6px 22px rgba(45,106,45,0.4);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
  }

  .btn-login::after {
    content: '';
    position: absolute; inset: 0;
    background: rgba(255,255,255,0.08);
    opacity: 0;
    transition: opacity 0.2s;
  }

  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(45,106,45,0.50);
  }
  .btn-login:hover::after { opacity: 1; }
  .btn-login:active { transform: translateY(0); }

  .demo-box {
    margin-top: 24px;
    background: var(--crema);
    border-radius: 12px;
    padding: 14px 16px;
    border-left: 3px solid var(--oro);
    display: flex;
    align-items: flex-start;
    gap: 12px;
    border-top-left-radius: 2px;
    border-bottom-left-radius: 2px;
  }

  .demo-icon {
    width: 30px; height: 30px;
    background: linear-gradient(135deg, var(--oro), var(--oro-claro));
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 1px;
  }

  .demo-title {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--verde-oscuro);
    margin-bottom: 4px;
  }

  .demo-cred {
    font-family: 'DM Mono', monospace;
    font-size: 12px;
    color: var(--gris-suave);
    line-height: 1.6;
  }

  .register-row {
    margin-top: 20px;
    text-align: center;
    font-size: 13px;
    color: var(--gris-suave);
  }

  .register-row a {
    font-weight: 600;
    color: var(--verde);
    text-decoration: none;
    transition: color 0.2s;
  }
  .register-row a:hover { color: var(--verde-oscuro); text-decoration: underline; }

  .card-footer {
    padding: 16px 36px 24px;
    border-top: 1px solid var(--borde);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .footer-emblem {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    color: var(--gris-suave);
    letter-spacing: 0.1em;
    text-transform: uppercase;
  }

  .footer-emblem .ua-mark {
    font-family: 'Playfair Display', serif;
    font-size: 12px;
    font-weight: 700;
    color: var(--oro);
  }

  .footer-dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--borde);
  }

  .corner-tl, .corner-br {
    position: absolute;
    width: 20px; height: 20px;
    pointer-events: none;
  }
  .corner-tl {
    top: 8px; left: 8px;
    border-top: 2px solid var(--oro);
    border-left: 2px solid var(--oro);
    border-radius: 4px 0 0 0;
    opacity: 0.5;
  }
  .corner-br {
    bottom: 8px; right: 8px;
    border-bottom: 2px solid var(--oro);
    border-right: 2px solid var(--oro);
    border-radius: 0 0 4px 0;
    opacity: 0.5;
  }
</style>
@endpush

@section('content')
<div class="login-page">

  <div class="gold-top-bar"></div>

  <div class="login-card">
    <div class="corner-tl"></div>
    <div class="corner-br"></div>

    <div class="card-header">
      <div class="header-deco-1"></div>
      <div class="header-deco-2"></div>

      <div class="logo-wrap">
        <div class="logo-escudo">
          <img src="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y" alt="UAEMex Logo" style="width: 90%; height: 90%; object-fit: contain; border-radius: 12px;">
        </div>
        <div class="live-badge"></div>
      </div>

      <h1 class="header-title">SIEI UAEMex</h1>
      <p class="header-subtitle">Sistema Integral de Evaluación Institucional</p>
      <span class="header-gold-line"></span>
    </div>

    <div class="card-body">
      <form action="{{ route('login') }}" method="POST">
        @csrf

        <div>
          <label for="email" class="field-label">Usuario Institucional</label>
          <div class="input-wrap">
            <input
              type="email"
              name="email"
              id="email"
              required
              class="field-input"
              placeholder="correo@uaemex.mx"
              value="{{ old('email') }}"
            >
            <span class="input-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
            </span>
          </div>
          @error('email')
            <p class="field-error">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <div>
          <label for="password" class="field-label">Contraseña</label>
          <div class="input-wrap">
            <input
              type="password"
              name="password"
              id="password"
              required
              class="field-input"
              placeholder="••••••••"
            >
            <span class="input-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </span>
          </div>
          @error('password')
            <p class="field-error">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <div class="options-row">
          
          <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn-login">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
            <polyline points="10 17 15 12 10 7"/>
            <line x1="15" y1="12" x2="3" y2="12"/>
          </svg>
          Iniciar Sesión
        </button>

      </form>


      <div class="register-row">
        ¿No tienes cuenta? Acude al departamento correspondiente</a>
      </div>
    </div>

    <div class="card-footer">
      <div class="footer-emblem">
        <span class="ua-mark">UA</span>
        <div class="footer-dot"></div>
        <span>Sistema oficial</span>
        <div class="footer-dot"></div>
        <span>UAEMex · 2026</span>
      </div>
    </div>
  </div>

</div>
@endsection
