@extends('layouts.admin')

@section('title', 'Usuarios')

@push('styles')
    <style>
        body { overflow: hidden; }
        .wrapper { height: 100vh; overflow: hidden; }
        #users-page { height: 100%; display: flex; flex-direction: column; max-width: 1100px; margin: 0 auto; }
        #users-results { flex: 1; min-height: 0; overflow: hidden; }
        #users-list { flex: 1; min-height: 0; overflow: hidden; display: flex; flex-direction: column; }
        #users-scroll { flex: 1; min-height: 0; overflow: auto; padding: 8px; }
        #users-pagination { padding: 12px 8px 4px; }
    </style>
@endpush

@section('content')
    <div id="users-page">
        <div style="display:flex; justify-content:center; align-items:flex-end; margin-bottom:22px; text-align:center;">
            <div>
                <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:6px;">
                </div>
                <h1 style="font-family:'Sora',sans-serif; font-size:32px; font-weight:700; color:var(--text-dark); margin-bottom:8px;">Usuarios del Sistema</h1>
                <p style="color:var(--text-muted);">Gestiona roles, estados y permisos</p>
            </div>
        </div>

        <div class="neu-card" style="padding:16px 18px; margin-bottom:18px;">
            <form id="users-filter-form" method="GET" action="{{ route('users.index') }}" style="display:flex; gap:12px; align-items:center;">
                <div style="flex:1; display:flex; align-items:center; gap:8px; background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm); padding:0 12px; min-width:260px;">
                    <span style="font-size:16px;">🔍</span>
                    <input id="users-live-search" type="text" name="search" value="{{ request('search') }}" placeholder="Buscar usuario..."
                        style="border:none; background:transparent; padding:12px 0; font-family:'Nunito',sans-serif; font-size:14px; width:100%; outline:none; color:var(--text);">
                </div>
                <a href="{{ route('users.create') }}" class="btn btn-solid" style="white-space:nowrap;" data-users-modal="create">+ Agregar</a>
            </form>
        </div>

        <div id="users-results" class="neu-card" style="padding:14px; display:flex; flex-direction:column;">
            <div id="users-list">
                <div id="users-scroll">
                    @php
                        $usersActive = $users->getCollection()->filter(fn ($uu) => ($uu->status ?? null) === 'active');
                        $usersInactive = $users->getCollection()->filter(fn ($uu) => ($uu->status ?? null) === 'inactive');
                    @endphp
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px;">
                        <div style="display:flex; flex-direction:column; gap:14px;">
                            <div class="neu-card" style="padding:12px 14px; display:flex; align-items:center; gap:10px;">
                                <span style="width:10px; height:10px; border-radius:50%; background:var(--green); box-shadow:0 6px 14px rgba(0,0,0,0.08);"></span>
                                <span style="font-family:'Sora',sans-serif; font-weight:900; color:var(--text-dark);">Activos</span>
                            </div>
                            @forelse($usersActive as $u)
                                <div class="neu-card" style="display:flex; align-items:center; gap:14px; margin-bottom:0; position:relative; overflow:hidden; padding:14px 14px 14px 28px; flex-wrap:wrap;">
                                    <div style="position:absolute; left:12px; top:14px; bottom:14px; width:6px; border-radius:999px; background:var(--green);"></div>

                                    <div style="width:52px; height:52px; border-radius:50%; background:var(--verde); color:var(--oro-bright); display:grid; place-items:center; font-family:'Sora',sans-serif; font-weight:700; font-size:20px; box-shadow:var(--neu-out); flex:0 0 auto;">
                                        {{ strtoupper(substr($u->name,0,1)) }}
                                    </div>

                                    <div style="min-width:220px; flex:1; display:flex; flex-direction:column; gap:6px;">
                                        <div style="min-width:0;">
                                            <div style="font-family:'Sora',sans-serif; font-weight:700; font-size:16px; color:var(--text-dark); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $u->name }}</div>
                                            <div style="font-size:12px; color:var(--text-muted); margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $u->email }}</div>
                                        </div>

                                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                            <span class="status-pill" style="background:var(--bg); color:{{ $u->role==='admin' ? 'var(--verde)' : ($u->role==='editor' ? 'var(--blue)' : 'var(--text)') }}; font-size:10px; padding:4px 10px;">
                                                {{ ucfirst($u->role) }}
                                            </span>
                                            <span class="status-pill" style="background:var(--green-pale); color:var(--green); font-size:10px; padding:4px 10px;">
                                                ● Activo
                                            </span>
                                        </div>
                                    </div>

                                    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; justify-content:flex-end; flex:0 0 auto;">
                                        <div style="display:flex; gap:10px;">
                                            <div style="width:96px; background:var(--bg-light); border-radius:var(--radius-sm); padding:8px; text-align:center;">
                                                <div style="font-size:14px; font-weight:700; color:var(--text-dark); line-height:1;">{{ $u->surveys_count ?? 0 }}</div>
                                                <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-top:4px;">Encuestas</div>
                                            </div>
                                            <div style="width:96px; background:var(--bg-light); border-radius:var(--radius-sm); padding:8px; text-align:center;">
                                                <div style="font-size:14px; font-weight:700; color:var(--text-dark); line-height:1;">{{ $u->actions_count ?? 0 }}</div>
                                                <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-top:4px;">Acciones</div>
                                            </div>
                                        </div>

                                        <div style="display:flex; gap:8px;">
                                            <a href="{{ route('users.edit', $u->id) }}" class="btn btn-neu btn-sm" style="justify-content:center;" data-users-modal="edit">✏ Editar</a>
                                            @php
                                                $toggleUrl = \Illuminate\Support\Facades\Route::has('users.toggle-status')
                                                    ? route('users.toggle-status', $u->id)
                                                    : url('/users/' . $u->id . '/toggle-status');
                                            @endphp
                                            <form
                                                action="{{ $toggleUrl }}"
                                                method="POST"
                                                data-confirm-title="Confirmación"
                                                data-confirm-message="¿Inactivar usuario?"
                                                data-confirm-button="Inactivar"
                                                data-confirm-button-class="btn-danger"
                                            >
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm" style="justify-content:center;">
                                                    Inactivar
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('users.destroy', $u->id) }}"
                                                method="POST"
                                                data-confirm-title="Confirmación"
                                                data-confirm-message="¿Eliminar usuario?"
                                                data-confirm-button="Eliminar"
                                                data-confirm-button-class="btn-danger"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding:8px 12px;">🗑</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="neu-card" style="text-align:center; color:var(--text-muted);">
                                    No hay usuarios activos.
                                </div>
                            @endforelse
                        </div>

                        <div style="display:flex; flex-direction:column; gap:14px;">
                            <div class="neu-card" style="padding:12px 14px; display:flex; align-items:center; gap:10px;">
                                <span style="width:10px; height:10px; border-radius:50%; background:var(--red); box-shadow:0 6px 14px rgba(0,0,0,0.08);"></span>
                                <span style="font-family:'Sora',sans-serif; font-weight:900; color:var(--text-dark);">Inactivos</span>
                            </div>
                            @forelse($usersInactive as $u)
                                <div class="neu-card" style="display:flex; align-items:center; gap:14px; margin-bottom:0; position:relative; overflow:hidden; padding:14px 14px 14px 28px; flex-wrap:wrap;">
                                    <div style="position:absolute; left:12px; top:14px; bottom:14px; width:6px; border-radius:999px; background:var(--red);"></div>

                                    <div style="width:52px; height:52px; border-radius:50%; background:var(--verde); color:var(--oro-bright); display:grid; place-items:center; font-family:'Sora',sans-serif; font-weight:700; font-size:20px; box-shadow:var(--neu-out); flex:0 0 auto;">
                                        {{ strtoupper(substr($u->name,0,1)) }}
                                    </div>

                                    <div style="min-width:220px; flex:1; display:flex; flex-direction:column; gap:6px;">
                                        <div style="min-width:0;">
                                            <div style="font-family:'Sora',sans-serif; font-weight:700; font-size:16px; color:var(--text-dark); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $u->name }}</div>
                                            <div style="font-size:12px; color:var(--text-muted); margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $u->email }}</div>
                                        </div>

                                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                            <span class="status-pill" style="background:var(--bg); color:{{ $u->role==='admin' ? 'var(--verde)' : ($u->role==='editor' ? 'var(--blue)' : 'var(--text)') }}; font-size:10px; padding:4px 10px;">
                                                {{ ucfirst($u->role) }}
                                            </span>
                                            <span class="status-pill" style="background:var(--red-pale); color:var(--red); font-size:10px; padding:4px 10px;">
                                                ● Inactivo
                                            </span>
                                        </div>
                                    </div>

                                    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; justify-content:flex-end; flex:0 0 auto;">
                                        <div style="display:flex; gap:10px;">
                                            <div style="width:96px; background:var(--bg-light); border-radius:var(--radius-sm); padding:8px; text-align:center;">
                                                <div style="font-size:14px; font-weight:700; color:var(--text-dark); line-height:1;">{{ $u->surveys_count ?? 0 }}</div>
                                                <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-top:4px;">Encuestas</div>
                                            </div>
                                            <div style="width:96px; background:var(--bg-light); border-radius:var(--radius-sm); padding:8px; text-align:center;">
                                                <div style="font-size:14px; font-weight:700; color:var(--text-dark); line-height:1;">{{ $u->actions_count ?? 0 }}</div>
                                                <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-top:4px;">Acciones</div>
                                            </div>
                                        </div>

                                        <div style="display:flex; gap:8px;">
                                            <a href="{{ route('users.edit', $u->id) }}" class="btn btn-neu btn-sm" style="justify-content:center;" data-users-modal="edit">✏ Editar</a>
                                            @php
                                                $toggleUrl = \Illuminate\Support\Facades\Route::has('users.toggle-status')
                                                    ? route('users.toggle-status', $u->id)
                                                    : url('/users/' . $u->id . '/toggle-status');
                                            @endphp
                                            <form
                                                action="{{ $toggleUrl }}"
                                                method="POST"
                                                data-confirm-title="Confirmación"
                                                data-confirm-message="¿Activar usuario?"
                                                data-confirm-button="Activar"
                                                data-confirm-button-class="btn-oro"
                                            >
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-oro btn-sm" style="justify-content:center;">
                                                    Activar
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('users.destroy', $u->id) }}"
                                                method="POST"
                                                data-confirm-title="Confirmación"
                                                data-confirm-message="¿Eliminar usuario?"
                                                data-confirm-button="Eliminar"
                                                data-confirm-button-class="btn-danger"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding:8px 12px;">🗑</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="neu-card" style="text-align:center; color:var(--text-muted);">
                                    No hay usuarios inactivos.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div id="users-pagination">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="users-modal" style="display:none; position:fixed; inset:0; z-index:9999;">
        <div id="users-modal-backdrop" style="position:absolute; inset:0; background:rgba(0,0,0,0.35);"></div>
        <div style="position:relative; max-width:920px; margin:40px auto; padding:0 14px;">
            <div style="background:var(--bg); border-radius:var(--radius-lg); box-shadow:0 22px 60px rgba(0,0,0,0.35); padding:0; overflow:hidden; max-height:calc(100vh - 80px);">
                <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 18px; border-bottom:1px solid rgba(0,0,0,0.05); background:var(--bg);">
                    <div id="users-modal-title" style="font-family:'Sora',sans-serif; font-weight:800; color:var(--text-dark);">Cargando…</div>
                    <button type="button" id="users-modal-close" class="btn btn-neu btn-sm">✕</button>
                </div>
                <div id="users-modal-body" style="background:var(--bg); overflow:auto; max-height:calc(100vh - 140px);"></div>
            </div>
        </div>
    </div>

    <div id="users-confirm-modal" style="display:none; position:fixed; inset:0; z-index:10000;">
        <div id="users-confirm-backdrop" style="position:absolute; inset:0; background:rgba(0,0,0,0.35);"></div>
        <div style="position:relative; max-width:520px; margin:120px auto; padding:0 14px;">
            <div style="background:var(--bg); border-radius:var(--radius-lg); box-shadow:0 22px 60px rgba(0,0,0,0.35); padding:18px; overflow:hidden;">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                    <div id="users-confirm-title" style="font-family:'Sora',sans-serif; font-weight:900; color:var(--text-dark);">Confirmación</div>
                    <button type="button" id="users-confirm-close" class="btn btn-neu btn-sm">✕</button>
                </div>
                <div id="users-confirm-message" style="margin-top:12px; color:var(--text); font-weight:700;"></div>
                <div style="margin-top:18px; display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" id="users-confirm-cancel" class="btn btn-neu">Cancelar</button>
                    <button type="button" id="users-confirm-ok" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="users-auth-modal" style="display:none; position:fixed; inset:0; z-index:10001;">
        <div id="users-auth-backdrop" style="position:absolute; inset:0; background:rgba(0,0,0,0.35);"></div>
        <div style="position:relative; max-width:520px; margin:120px auto; padding:0 14px;">
            <div style="background:var(--bg); border-radius:var(--radius-lg); box-shadow:0 22px 60px rgba(0,0,0,0.35); padding:18px; overflow:hidden;">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                    <div style="font-family:'Sora',sans-serif; font-weight:900; color:var(--text-dark);">Seguridad</div>
                    <button type="button" id="users-auth-close" class="btn btn-neu btn-sm">✕</button>
                </div>
                <div style="margin-top:12px;">
                    <label for="users-auth-password" class="form-label">Contraseña:</label>
                    <input id="users-auth-password" type="password" class="form-input" autocomplete="current-password" />
                    <p id="users-auth-error" class="text-red-500 text-xs mt-1" style="display:none;"></p>
                </div>
                <div style="margin-top:18px; display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" id="users-auth-cancel" class="btn btn-neu">Cancelar</button>
                    <button type="button" id="users-auth-ok" class="btn btn-solid">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <style>
            @keyframes usersSpin { to { transform: rotate(360deg); } }
        </style>
        <script>
            (function () {
                var form = document.getElementById('users-filter-form');
                if (!form) return;

                var search = document.getElementById('users-live-search');
                var results = document.getElementById('users-results');
                if (!results) return;

                var modal = document.getElementById('users-modal');
                var modalBackdrop = document.getElementById('users-modal-backdrop');
                var modalClose = document.getElementById('users-modal-close');
                var modalTitle = document.getElementById('users-modal-title');
                var modalBody = document.getElementById('users-modal-body');

                var confirmModal = document.getElementById('users-confirm-modal');
                var confirmBackdrop = document.getElementById('users-confirm-backdrop');
                var confirmClose = document.getElementById('users-confirm-close');
                var confirmTitle = document.getElementById('users-confirm-title');
                var confirmMessage = document.getElementById('users-confirm-message');
                var confirmCancel = document.getElementById('users-confirm-cancel');
                var confirmOk = document.getElementById('users-confirm-ok');
                var pendingConfirmForm = null;

                var authModal = document.getElementById('users-auth-modal');
                var authBackdrop = document.getElementById('users-auth-backdrop');
                var authClose = document.getElementById('users-auth-close');
                var authCancel = document.getElementById('users-auth-cancel');
                var authOk = document.getElementById('users-auth-ok');
                var authPassword = document.getElementById('users-auth-password');
                var authError = document.getElementById('users-auth-error');
                var pendingAuthForm = null;

                var timer = null;
                var controller = null;
                var requestSeq = 0;
                var lastQueryString = null;

                function getQueryString() {
                    var params = new URLSearchParams(new FormData(form));
                    return params.toString();
                }

                function setLoading(isLoading) {
                    results.style.opacity = isLoading ? '0.55' : '';
                    results.style.pointerEvents = isLoading ? 'none' : '';
                }

                function replaceResultsFromHtml(htmlText) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(htmlText, 'text/html');
                    var nextResults = doc.getElementById('users-results');
                    if (!nextResults) return;
                    results.innerHTML = nextResults.innerHTML;
                    bindPagination();
                    bindModalTriggers();
                    bindConfirmForms();
                }

                function fetchResults(url, pushUrl) {
                    requestSeq += 1;
                    var seq = requestSeq;

                    if (controller) controller.abort();
                    controller = new AbortController();

                    setLoading(true);

                    return fetch(url, {
                        method: 'GET',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        signal: controller.signal
                    })
                        .then(function (r) { return r.text(); })
                        .then(function (htmlText) {
                            if (seq !== requestSeq) return;
                            replaceResultsFromHtml(htmlText);
                            if (pushUrl) {
                                window.history.replaceState({}, '', pushUrl);
                            }
                        })
                        .catch(function () {})
                        .finally(function () {
                            if (seq !== requestSeq) return;
                            setLoading(false);
                        });
                }

                function triggerFetch() {
                    var qs = getQueryString();
                    if (qs === lastQueryString) return;
                    lastQueryString = qs;
                    var url = form.action + (qs ? ('?' + qs) : '');
                    fetchResults(url, url);
                }

                function setModalOpen(isOpen) {
                    if (!modal) return;
                    modal.style.display = isOpen ? 'block' : 'none';
                    if (isOpen) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                        modalBody.innerHTML = '';
                    }
                }

                function setConfirmOpen(isOpen) {
                    if (!confirmModal) return;
                    confirmModal.style.display = isOpen ? 'block' : 'none';
                    if (!isOpen) pendingConfirmForm = null;
                }

                function setAuthOpen(isOpen) {
                    if (!authModal) return;
                    authModal.style.display = isOpen ? 'block' : 'none';
                    if (!isOpen) {
                        pendingAuthForm = null;
                        if (authPassword) authPassword.value = '';
                        if (authError) {
                            authError.textContent = '';
                            authError.style.display = 'none';
                        }
                    }
                }

                function clearModalErrors(modalForm) {
                    if (!modalForm) return;
                    var existing = modalForm.querySelectorAll('[data-field-error]');
                    Array.prototype.forEach.call(existing, function (el) { el.remove(); });
                }

                function showModalErrors(modalForm, errors) {
                    if (!modalForm || !errors) return;
                    Object.keys(errors).forEach(function (field) {
                        var messages = errors[field];
                        if (!messages || !messages.length) return;

                        var input = modalForm.querySelector('[name="' + field + '"]');
                        if (!input) return;

                        var p = document.createElement('p');
                        p.setAttribute('data-field-error', field);
                        p.className = 'text-red-500 text-xs mt-1';
                        p.textContent = messages[0];

                        if (input.nextSibling) {
                            input.parentNode.insertBefore(p, input.nextSibling);
                        } else {
                            input.parentNode.appendChild(p);
                        }
                    });
                }

                function setAuthError(message) {
                    if (!authError) return;
                    authError.textContent = message || '';
                    authError.style.display = message ? 'block' : 'none';
                }

                function setButtonLoading(button, isLoading, label) {
                    if (!button) return;
                    if (isLoading) {
                        if (!button.dataset.originalHtml) button.dataset.originalHtml = button.innerHTML;
                        button.disabled = true;
                        button.style.opacity = '0.85';
                        button.style.pointerEvents = 'none';
                        button.innerHTML = '<span style="display:inline-flex; align-items:center; gap:10px;">'
                            + '<span style="width:14px; height:14px; border:2px solid rgba(255,255,255,0.55); border-top-color:rgba(255,255,255,1); border-radius:50%; display:inline-block; animation: usersSpin 0.8s linear infinite;"></span>'
                            + '<span>' + (label || 'Cargando…') + '</span>'
                            + '</span>';
                    } else {
                        button.disabled = false;
                        button.style.opacity = '';
                        button.style.pointerEvents = '';
                        if (button.dataset.originalHtml) {
                            button.innerHTML = button.dataset.originalHtml;
                            delete button.dataset.originalHtml;
                        }
                    }
                }

                function prevalidateModalFormAjax(modalForm) {
                    clearModalErrors(modalForm);
                    setAuthError('');

                    var submitBtn = modalForm.querySelector('button[type="submit"]');
                    setButtonLoading(submitBtn, true, 'Validando…');

                    var formData = new FormData(modalForm);
                    formData.append('validate_only', '1');

                    return fetch(modalForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                        .then(function (r) {
                            if (r.status === 422) return r.json().then(function (data) { return { ok: false, status: 422, data: data }; });
                            if (!r.ok) return r.text().then(function (t) { return { ok: false, status: r.status, text: t }; });
                            return r.json().then(function (data) { return { ok: true, data: data }; }).catch(function () { return { ok: true, data: {} }; });
                        })
                        .then(function (res) {
                            if (!res.ok && res.status === 422) {
                                showModalErrors(modalForm, (res.data || {}).errors || {});
                                setButtonLoading(submitBtn, false);
                                return false;
                            }
                            if (!res.ok) {
                                setButtonLoading(submitBtn, false);
                                return false;
                            }
                            setButtonLoading(submitBtn, false);
                            return true;
                        })
                        .catch(function () {
                            setButtonLoading(submitBtn, false);
                            return false;
                        });
                }

                function submitModalFormAjax(modalForm, adminPassword) {
                    if (!modalForm) return;

                    clearModalErrors(modalForm);
                    setAuthError('');

                    setButtonLoading(authOk, true, 'Guardando…');

                    var formData = new FormData(modalForm);
                    if (adminPassword) formData.append('admin_password', adminPassword);

                    fetch(modalForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                        .then(function (r) {
                            if (r.status === 422) return r.json().then(function (data) { return { ok: false, status: 422, data: data }; });
                            if (!r.ok) return r.text().then(function (t) { return { ok: false, status: r.status, text: t }; });
                            return r.json().then(function (data) { return { ok: true, data: data }; }).catch(function () { return { ok: true, data: {} }; });
                        })
                        .then(function (res) {
                            if (!res.ok && res.status === 422) {
                                var errors = (res.data || {}).errors || {};
                                if (errors.admin_password && errors.admin_password.length) {
                                    setButtonLoading(authOk, false);
                                    setAuthError(errors.admin_password[0]);
                                    setAuthOpen(true);
                                    if (authPassword) authPassword.focus();
                                    return;
                                }
                                setButtonLoading(authOk, false);
                                showModalErrors(modalForm, errors);
                                return;
                            }

                            if (!res.ok) {
                                setButtonLoading(authOk, false);
                                return;
                            }

                            setAuthOpen(false);
                            setModalOpen(false);
                            triggerFetch();
                            setButtonLoading(authOk, false);
                        })
                        .catch(function () {
                            setButtonLoading(authOk, false);
                        });
                }

                function bindModalForm(modalForm) {
                    if (!modalForm) return;

                    modalForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        if (typeof modalForm.checkValidity === 'function' && !modalForm.checkValidity()) {
                            if (typeof modalForm.reportValidity === 'function') modalForm.reportValidity();
                            return;
                        }

                        setAuthOpen(false);
                        prevalidateModalFormAjax(modalForm).then(function (ok) {
                            if (!ok) return;
                            pendingAuthForm = modalForm;
                            setAuthOpen(true);
                            if (authPassword) authPassword.focus();
                        });
                    });

                    var cancelLinks = modalForm.querySelectorAll('a[href]');
                    Array.prototype.forEach.call(cancelLinks, function (a) {
                        var href = a.getAttribute('href') || '';
                        if (href.indexOf('#') === 0 || href.indexOf('users') !== -1) {
                            a.addEventListener('click', function (e) {
                                e.preventDefault();
                                setModalOpen(false);
                            });
                        }
                    });
                }

                function openModalFromUrl(url, fallbackTitle) {
                    if (!modal || !modalTitle || !modalBody) return;

                    setModalOpen(true);
                    modalTitle.textContent = fallbackTitle || 'Cargando…';
                    modalBody.innerHTML = '<div style="padding:18px; color:var(--text-muted); font-weight:700;">Cargando…</div>';

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function (r) { return r.text(); })
                        .then(function (htmlText) {
                            var parser = new DOMParser();
                            var doc = parser.parseFromString(htmlText, 'text/html');

                            var titleEl = doc.querySelector('.ph-title');
                            var titleText = titleEl ? titleEl.textContent : '';
                            modalTitle.textContent = (titleText || fallbackTitle || 'Usuario').trim();

                            var modalForm = doc.querySelector('form[action*="/users"]');
                            if (!modalForm) {
                                setModalOpen(false);
                                return;
                            }

                            var container = modalForm.closest('.neu-card') || modalForm;
                            var nextNode = document.importNode(container, true);
                            if (nextNode.classList && nextNode.classList.contains('neu-card')) {
                                nextNode.style.boxShadow = 'none';
                                nextNode.style.marginBottom = '0';
                            }

                            modalBody.innerHTML = '';
                            modalBody.appendChild(nextNode);

                            var injectedForm = modalBody.querySelector('form[action*="/users"]');
                            bindModalForm(injectedForm);
                        })
                        .catch(function () {
                            setModalOpen(false);
                        });
                }

                function openConfirmForForm(formEl) {
                    if (!confirmModal || !confirmTitle || !confirmMessage || !confirmOk) return;
                    pendingConfirmForm = formEl;

                    confirmTitle.textContent = (formEl.getAttribute('data-confirm-title') || 'Confirmación').trim();
                    confirmMessage.textContent = (formEl.getAttribute('data-confirm-message') || '¿Confirmar acción?').trim();

                    var btnText = (formEl.getAttribute('data-confirm-button') || 'Aceptar').trim();
                    confirmOk.textContent = btnText;

                    var btnClass = (formEl.getAttribute('data-confirm-button-class') || 'btn-danger').trim();
                    confirmOk.className = 'btn ' + btnClass;

                    setConfirmOpen(true);
                }

                function submitDebounced() {
                    if (timer) window.clearTimeout(timer);
                    timer = window.setTimeout(function () {
                        triggerFetch();
                    }, 200);
                }

                function bindPagination() {
                    var links = results.querySelectorAll('a[href]');
                    Array.prototype.forEach.call(links, function (a) {
                        if (!a.href) return;
                        a.addEventListener('click', function (e) {
                            if (a.target && a.target !== '_self') return;
                            e.preventDefault();
                            fetchResults(a.href, a.href);
                        });
                    });
                }

                function bindModalTriggers() {
                    var createLink = document.querySelector('a[data-users-modal="create"]');
                    if (createLink && !createLink.__usersModalBound) {
                        createLink.__usersModalBound = true;
                        createLink.addEventListener('click', function (e) {
                            e.preventDefault();
                            openModalFromUrl(createLink.href, 'Nuevo Usuario');
                        });
                    }

                    var editLinks = results.querySelectorAll('a[data-users-modal="edit"]');
                    Array.prototype.forEach.call(editLinks, function (a) {
                        if (a.__usersModalBound) return;
                        a.__usersModalBound = true;
                        a.addEventListener('click', function (e) {
                            e.preventDefault();
                            openModalFromUrl(a.href, 'Editar Usuario');
                        });
                    });
                }

                function bindConfirmForms() {
                    var forms = results.querySelectorAll('form[data-confirm-message]');
                    Array.prototype.forEach.call(forms, function (f) {
                        if (f.__usersConfirmBound) return;
                        f.__usersConfirmBound = true;
                        f.addEventListener('submit', function (e) {
                            if (f.__skipConfirmOnce) {
                                f.__skipConfirmOnce = false;
                                return;
                            }
                            e.preventDefault();
                            openConfirmForForm(f);
                        });
                    });
                }

                bindPagination();
                bindModalTriggers();
                bindConfirmForms();

                if (modalBackdrop) modalBackdrop.addEventListener('click', function () { setModalOpen(false); });
                if (modalClose) modalClose.addEventListener('click', function () { setModalOpen(false); });
                if (confirmBackdrop) confirmBackdrop.addEventListener('click', function () { setConfirmOpen(false); });
                if (confirmClose) confirmClose.addEventListener('click', function () { setConfirmOpen(false); });
                if (confirmCancel) confirmCancel.addEventListener('click', function () { setConfirmOpen(false); });
                if (confirmOk) confirmOk.addEventListener('click', function () {
                    if (!pendingConfirmForm) return;
                    var f = pendingConfirmForm;
                    setConfirmOpen(false);
                    f.__skipConfirmOnce = true;
                    f.submit();
                });
                if (authBackdrop) authBackdrop.addEventListener('click', function () { setAuthOpen(false); });
                if (authClose) authClose.addEventListener('click', function () { setAuthOpen(false); });
                if (authCancel) authCancel.addEventListener('click', function () { setAuthOpen(false); });
                if (authOk) authOk.addEventListener('click', function () {
                    if (!pendingAuthForm) return;
                    var pwd = authPassword ? authPassword.value : '';
                    if (!pwd) {
                        setAuthError('La contraseña es obligatoria.');
                        if (authPassword) authPassword.focus();
                        return;
                    }
                    submitModalFormAjax(pendingAuthForm, pwd);
                });
                if (authPassword) authPassword.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (authOk) authOk.click();
                    }
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        setAuthOpen(false);
                        setConfirmOpen(false);
                        setModalOpen(false);
                    }
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    triggerFetch();
                });

                if (search) search.addEventListener('input', submitDebounced);
            })();
        </script>
    @endpush
@endsection
