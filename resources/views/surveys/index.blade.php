@extends('layouts.admin')

@section('title', 'Encuestas')

@section('content')
    <div style="margin-bottom:30px; text-align:center;">
        <h1 style="font-family:'Sora',sans-serif; font-size:32px; font-weight:700; color:var(--text-dark); margin-bottom:8px;">Encuestas</h1>
        <p style="color:var(--text-muted);">Administra y monitorea encuestas</p>
    </div>

    <div class="neu-card" style="padding:16px;">
        <form action="{{ route('surveys.index') }}" method="GET" id="filtersForm" style="display:flex; gap:16px; align-items:center; flex-wrap:wrap;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:13px; font-weight:700; color:var(--text-muted);">Usuario:</span>
                <select name="user_id" onchange="this.form.submit()" class="form-input" style="width:auto; min-width:240px; padding-right:34px;">
                    <option value="all" {{ request('user_id', 'all') == 'all' ? 'selected' : '' }}>Todos</option>
                    @foreach(($users ?? []) as $u)
                        @php
                            $userDisplay = trim(collect(preg_split('/\s+/', $u->name ?? ''))->filter()->take(2)->implode(' '));
                            if ($userDisplay === '') {
                                $userDisplay = 'Sin nombre';
                            }
                        @endphp
                        <option value="{{ (string) $u->id }}" {{ request('user_id') == (string) $u->id ? 'selected' : '' }}>
                            {{ $userDisplay }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:13px; font-weight:700; color:var(--text-muted);">Estado:</span>
                <select name="status" onchange="this.form.submit()" class="form-input" style="width:auto; min-width:160px; padding-right:34px;">
                    <option value="Todas" {{ request('status') == 'Todas' ? 'selected' : '' }}>Todas</option>
                    <option value="Pendientes" {{ request('status') == 'Pendientes' ? 'selected' : '' }}>Pendientes</option>
                    <option value="Activas" {{ request('status') == 'Activas' ? 'selected' : '' }}>Activas</option>
                    <option value="Inactivas" {{ request('status') == 'Inactivas' ? 'selected' : '' }}>Inactivas</option>
                </select>
            </div>

            <div style="flex:1; display:flex; align-items:center; gap:8px; background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm); padding:0 12px; min-width:260px;">
                <span style="font-size:16px;">🔍</span>
                <input type="text" name="search" id="survey-search" value="{{ request('search') }}" placeholder="Buscar encuesta..."
                       style="border:none; background:transparent; padding:12px 0; font-family:'Nunito',sans-serif; font-size:14px; width:100%; outline:none; color:var(--text);">
            </div>

            <a href="{{ route('surveys.create') }}" class="btn btn-solid">+ Nueva Encuesta</a>
        </form>
    </div>

    <div id="surveys-results">
        @php
            $toastMessage = session('success') ?? session('error');
            $toastType = session('success') ? 'success' : (session('error') ? 'error' : null);
        @endphp
        @if($toastMessage && $toastType)
            <div id="survey-toast"
                 class="survey-toast"
                 style="position:fixed; top:92px; right:24px; z-index:9999; max-width:380px; width:calc(100vw - 48px);
                        border-radius:16px; padding:12px 14px; box-shadow:var(--neu-out-lg);
                        background:{{ $toastType === 'success' ? 'var(--verde)' : 'var(--red)' }}; color:#fff;">
                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <div style="width:34px; height:34px; border-radius:12px; background:rgba(255,255,255,.18); display:grid; place-items:center; flex-shrink:0;">
                        @if($toastType === 'success')
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        @else
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        @endif
                    </div>
                    <div style="min-width:0;">
                        <div style="font-family:'Sora',sans-serif; font-size:12px; font-weight:800; letter-spacing:.3px; text-transform:uppercase; opacity:.9;">
                            {{ $toastType === 'success' ? 'Listo' : 'Atención' }}
                        </div>
                        <div style="margin-top:2px; font-size:13px; font-weight:700; line-height:1.25; word-break:break-word;">
                            {{ $toastMessage }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="neu-card" id="surveys-scroll" style="margin-bottom:0; padding:16px; height:60vh; min-height:360px; overflow:auto; overscroll-behavior:contain;">
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap:22px;">
                @php
                    $sortedSurveys = $surveys->getCollection()
                        ->sortBy(function ($s) {
                            $approval = $s->approval_status ?? 'approved';
                            $rank = $approval === 'pending' ? 0 : ($s->is_active ? 1 : 2);
                            $ts = $s->created_at ? $s->created_at->timestamp : 0;
                            return [$rank, -$ts];
                        })
                        ->values();
                @endphp
                @forelse ($sortedSurveys as $survey)
                    @php
                        $approval = $survey->approval_status ?? 'approved';
                        $isPending = $approval === 'pending';
                        $barColor = $isPending ? 'var(--oro)' : ($survey->is_active ? 'var(--verde)' : 'var(--red)');
                        $pillClass = $isPending ? 'status-pending' : ($survey->is_active ? 'status-approved' : 'status-rejected');
                        $pillText = $isPending ? 'Pendiente' : ($survey->is_active ? 'Activada' : 'Desactivada');
                    @endphp
                    <div class="neu-card" style="margin-bottom:0; padding:20px; position:relative; overflow:hidden; display:flex; flex-direction:column; gap:14px; height:270px;">
                        <div style="position:absolute; top:0; left:0; bottom:0; width:6px; background:{{ $barColor }};"></div>

                        <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; padding-left:6px;">
                            <div style="min-width:0; min-height:78px;">
                                <div style="font-family:'Sora',sans-serif; font-weight:700; font-size:16px; color:var(--text-dark); line-height:1.2; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                    {{ $survey->title }}
                                </div>
                                <div style="font-size:12px; color:var(--text-muted); margin-top:6px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; line-height:1.25; max-height:30px;">
                                    {{ $survey->description ?: 'Sin descripción' }}
                                </div>
                            </div>

                        <span class="status-pill {{ $pillClass }}" style="background:var(--bg); flex-shrink:0;">
                            {{ $pillText }}
                            </span>
                        </div>

                        <div style="display:flex; gap:12px; padding-left:6px;">
                            <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:10px; text-align:center; height:64px; display:flex; flex-direction:column; justify-content:center;">
                                <div style="font-size:16px; font-weight:800; color:var(--text-dark);">{{ $survey->responses()->count() }}</div>
                                <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Resp.</div>
                            </div>
                            <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:10px; text-align:center; height:64px; display:flex; flex-direction:column; justify-content:center;">
                                <div style="font-size:16px; font-weight:800; color:var(--text-dark);">{{ count($survey->questions ?? []) }}</div>
                                <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Preg.</div>
                            </div>
                            <div style="flex:1; background:var(--bg-light); border-radius:var(--radius-sm); padding:10px; text-align:center; height:64px; display:flex; flex-direction:column; justify-content:center;">
                                <div style="font-size:16px; font-weight:800; color:var(--text-dark);">
                                    {{ $survey->limit_responses ? intval(($survey->responses()->count() / $survey->limit_responses) * 100) : '—' }}@if($survey->limit_responses)%@endif
                                </div>
                                <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Comp.</div>
                            </div>
                        </div>

                        <div style="margin-top:auto; display:flex; align-items:center; justify-content:space-between; gap:12px; padding-left:6px; color:var(--text-muted);">
                            <div style="display:flex; align-items:center; gap:10px; min-width:0;">
                                <div style="width:34px; height:34px; border-radius:50%; background:var(--verde); color:var(--oro-bright); display:grid; place-items:center; font-family:'Sora',sans-serif; font-weight:700; box-shadow:var(--neu-out); flex-shrink:0;">
                                    {{ strtoupper(substr(optional($survey->user)->name ?? '?', 0, 1)) }}
                                </div>
                                <div style="font-size:12px; min-width:0;">
                                    @php
                                        $cardUserName = trim(collect(preg_split('/\s+/', optional($survey->user)->name ?? ''))->filter()->take(2)->implode(' '));
                                        if ($cardUserName === '') {
                                            $cardUserName = 'Desconocido';
                                        }
                                    @endphp
                                    <span style="font-weight:700; color:var(--text); display:inline-block; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; vertical-align:bottom;">{{ $cardUserName }}</span>
                                    <span style="white-space:nowrap;"> · {{ $survey->created_at ? $survey->created_at->format('d/m/Y') : 'N/A' }}</span>
                                </div>
                            </div>

                            <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
                                @if($isPending)
                                    <a href="{{ route('admin.aprobaciones', ['id' => $survey->id]) }}" class="btn btn-oro btn-sm" style="height:36px; display:inline-flex; align-items:center; justify-content:center; padding:8px 14px;">Revisar</a>
                                @else
                                    <form action="{{ route('surveys.toggle-status', $survey->id) }}" method="POST" style="margin:0;"
                                          data-survey-toggle="1"
                                          data-is-active="{{ $survey->is_active ? '1' : '0' }}"
                                          data-survey-title="{{ $survey->title }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn {{ $survey->is_active ? 'btn-danger' : 'btn-solid' }} btn-sm" title="{{ $survey->is_active ? 'Desactivar' : 'Activar' }}" style="height:36px; padding:8px 14px; display:inline-flex; align-items:center; gap:8px; background:{{ $survey->is_active ? 'var(--red)' : 'var(--verde)' }}; color:#fff; box-shadow:4px 4px 10px rgba(0,0,0,.18); white-space:nowrap;">
                                            @if($survey->is_active)
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:block;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Desactivar
                                            @else
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:block;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Activar
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="neu-card" style="margin-bottom:0; grid-column: 1 / -1; text-align:center; color:var(--text-muted);">
                        No se encontraron encuestas
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="survey-toggle-confirm" style="position:fixed; inset:0; z-index:10000; display:none; align-items:center; justify-content:center; padding:22px; background:rgba(0,0,0,.35);">
        <div style="width:min(460px, 100%); background:var(--bg); border-radius:18px; box-shadow:var(--neu-out-lg); padding:16px 16px 14px;">
            <div style="display:flex; align-items:flex-start; gap:12px;">
                <div id="survey-toggle-confirm-icon" style="width:42px; height:42px; border-radius:16px; display:grid; place-items:center; flex-shrink:0; background:var(--bg-light); color:var(--text); box-shadow:var(--neu-out);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v4"></path><path d="M12 17h.01"></path><path d="M10.29 3.86l-7.4 13.12A2 2 0 0 0 4.63 20h14.74a2 2 0 0 0 1.74-3.02l-7.4-13.12a2 2 0 0 0-3.42 0z"></path></svg>
                </div>
                <div style="min-width:0;">
                    <div id="survey-toggle-confirm-title" style="font-family:'Sora',sans-serif; font-size:14px; font-weight:800; color:var(--text-dark); line-height:1.2;">
                        Confirmación
                    </div>
                    <div id="survey-toggle-confirm-text" style="margin-top:6px; font-size:13px; color:var(--text); line-height:1.35; word-break:break-word;">
                        --
                    </div>
                </div>
            </div>
            <div style="margin-top:14px; display:flex; justify-content:flex-end; gap:10px; flex-wrap:wrap;">
                <button type="button" id="survey-toggle-cancel" class="btn btn-neu btn-sm" style="height:36px; padding:8px 14px;">Cancelar</button>
                <button type="button" id="survey-toggle-confirm-btn" class="btn btn-solid btn-sm" style="height:36px; padding:8px 14px; background:var(--verde); color:#fff;">Confirmar</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Personalización de Flatpickr */
        .flatpickr-day.has-survey {
            background: var(--verde-xpale);
            border-color: transparent;
            position: relative;
        }
        .flatpickr-day.has-survey::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background-color: var(--verde);
            border-radius: 50%;
        }
        .flatpickr-day.selected.has-survey {
            background: var(--verde);
            border-color: var(--verde);
            color: #fff;
        }
        .flatpickr-day.selected.has-survey::after {
            background-color: #fff;
        }

        .survey-toast {
            pointer-events: none;
            transform: translateX(120%);
            opacity: 0;
            animation: surveyToastInOut 5s ease both;
        }

        @keyframes surveyToastInOut {
            0% { transform: translateX(120%); opacity: 0; }
            12% { transform: translateX(0); opacity: 1; }
            82% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(120%); opacity: 0; }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        (function () {
            function resize() {
                var el = document.getElementById('surveys-scroll');
                if (!el) return;
                var rect = el.getBoundingClientRect();
                var bottomPadding = 18;
                var h = window.innerHeight - rect.top - bottomPadding;
                if (h < 280) h = 280;
                el.style.height = h + 'px';
            }

            window.__resizeSurveysScroll = resize;
            document.addEventListener('DOMContentLoaded', resize);
            window.addEventListener('resize', function () {
                window.requestAnimationFrame(resize);
            });
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fechas con encuestas pasadas desde el controlador
            const surveyDates = @json($surveyDates ?? []);

            const input = document.getElementById('datepicker');
            if (!input || typeof flatpickr === 'undefined') return;

            flatpickr(input, {
                locale: "es",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                allowInput: true,
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    // Formatear la fecha del día actual en el loop
                    const date = dayElem.dateObj.toISOString().slice(0, 10);
                    
                    // Si la fecha está en nuestra lista, agregar clase
                    if (surveyDates.includes(date)) {
                        dayElem.classList.add('has-survey');
                        dayElem.title = "Hay encuestas este día";
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    // Enviar el formulario al seleccionar fecha
                    document.getElementById('filtersForm').submit();
                }
            });
        });
    </script>
    <script>
        (function () {
            var form = document.getElementById('filtersForm');
            if (!form) return;
            var searchInput = form.querySelector('input[name="search"]');
            var results = document.getElementById('surveys-results');
            if (!searchInput || !results) return;

            var timer = null;
            var lastQuery = null;
            var activeController = null;

            function buildUrl() {
                var params = new URLSearchParams(new FormData(form));
                var query = params.toString();
                return {
                    url: form.action + (query ? ('?' + query) : ''),
                    query: query,
                };
            }

            function setLoading(isLoading) {
                results.style.opacity = isLoading ? '0.65' : '';
                results.style.pointerEvents = isLoading ? 'none' : '';
                results.setAttribute('aria-busy', isLoading ? 'true' : 'false');
            }

            function run() {
                var built = buildUrl();
                if (built.query === lastQuery) return;
                lastQuery = built.query;

                if (activeController) activeController.abort();
                activeController = new AbortController();

                setLoading(true);

                fetch(built.url, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    signal: activeController.signal,
                })
                    .then(function (r) { return r.text(); })
                    .then(function (html) {
                        var doc = new DOMParser().parseFromString(html, 'text/html');
                        var next = doc.getElementById('surveys-results');
                        if (next) {
                            results.innerHTML = next.innerHTML;
                            window.history.replaceState({}, '', built.url);
                            if (window.__resizeSurveysScroll) window.__resizeSurveysScroll();
                        }
                    })
                    .catch(function () {})
                    .finally(function () { setLoading(false); });
            }

            searchInput.addEventListener('input', function () {
                if (timer) window.clearTimeout(timer);
                timer = window.setTimeout(run, 260);
            });
        })();
    </script>
    <script>
        (function () {
            var overlay = document.getElementById('survey-toggle-confirm');
            if (!overlay) return;

            var textEl = document.getElementById('survey-toggle-confirm-text');
            var titleEl = document.getElementById('survey-toggle-confirm-title');
            var iconEl = document.getElementById('survey-toggle-confirm-icon');
            var btnCancel = document.getElementById('survey-toggle-cancel');
            var btnConfirm = document.getElementById('survey-toggle-confirm-btn');

            var pendingForm = null;

            function openModal(opts) {
                pendingForm = opts.form;
                titleEl.textContent = opts.isActive ? '¿Desactivar encuesta?' : '¿Activar encuesta?';
                textEl.textContent = (opts.isActive ? '¿Quieres dejar la encuesta desactivada "' : '¿Quieres dejar la encuesta activada "') + opts.title + '"?';
                btnConfirm.textContent = opts.isActive ? 'Sí, desactivar' : 'Sí, activar';
                btnConfirm.style.background = opts.isActive ? 'var(--red)' : 'var(--verde)';
                btnConfirm.style.color = '#fff';
                iconEl.style.background = opts.isActive ? 'rgba(255,82,82,.12)' : 'rgba(46,204,113,.12)';
                iconEl.style.color = opts.isActive ? 'var(--red)' : 'var(--verde)';
                overlay.style.display = 'flex';
            }

            function closeModal() {
                overlay.style.display = 'none';
                pendingForm = null;
                btnConfirm.disabled = false;
                btnCancel.disabled = false;
            }

            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal();
            });

            btnCancel.addEventListener('click', function () {
                closeModal();
            });

            btnConfirm.addEventListener('click', function () {
                if (!pendingForm) return;
                btnConfirm.disabled = true;
                btnCancel.disabled = true;
                pendingForm.dataset.confirming = '1';
                pendingForm.submit();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && overlay.style.display === 'flex') closeModal();
            });

            document.addEventListener('submit', function (e) {
                var form = e.target;
                if (!form || form.tagName !== 'FORM') return;
                if (form.getAttribute('data-survey-toggle') !== '1') return;
                if (form.dataset.confirming === '1') return;

                e.preventDefault();

                var isActive = form.getAttribute('data-is-active') === '1';
                var title = form.getAttribute('data-survey-title') || 'esta encuesta';
                openModal({ form: form, isActive: isActive, title: title });
            }, true);
        })();
    </script>
@endpush
