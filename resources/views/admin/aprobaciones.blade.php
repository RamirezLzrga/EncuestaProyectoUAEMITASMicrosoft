@extends('layouts.admin')

@section('title', 'Sistema de Aprobaciones')

@section('content')
    {{-- HEADER --}}
    <div style="margin-bottom:30px;">
        <div style="font-size:11px; font-weight:800; color:var(--oro); letter-spacing:1px; text-transform:uppercase; margin-bottom:6px;">FLUJO EDITORIAL</div>
        <h1 style="font-family:'Sora',sans-serif; font-size:32px; font-weight:700; color:var(--uaemex); margin-bottom:8px;">Sistema de Aprobaciones</h1>
        <p style="color:var(--text-muted);">Revisa y gestiona las encuestas pendientes de publicación</p>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 340px; gap:30px; align-items:start;">
        
        {{-- LEFT COLUMN: ACTIVE SURVEY CARD --}}
        <div>
            @php
                $activeSurvey = null;
                if(request()->has('id')) {
                    $activeSurvey = $pendingSurveys->where('id', request('id'))->first();
                    // If not found in pending, check history just in case (though actions might be disabled)
                    if(!$activeSurvey) $activeSurvey = $history->where('id', request('id'))->first();
                } else {
                    $activeSurvey = $pendingSurveys->first();
                }
            @endphp

            @if($activeSurvey)
                <div class="neu-card" style="padding:32px; min-height:500px; display:flex; flex-direction:column; justify-content:space-between;">
                    
                    {{-- Card Header --}}
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px;">
                        <div>
                            <h2 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:var(--text-dark); margin-bottom:6px;">
                                {{ $activeSurvey->title }}
                            </h2>
                            <div style="font-family:'JetBrains Mono', monospace; font-size:12px; color:var(--text-muted);">
                                Propietario: {{ optional($activeSurvey->user)->name ?? 'Desconocido' }} · Creada {{ $activeSurvey->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="status-pill {{ $activeSurvey->approval_status === 'pending' ? 'status-pending' : ($activeSurvey->approval_status === 'approved' ? 'status-active' : 'status-inactive') }}">
                            @if($activeSurvey->approval_status === 'pending') Pendiente
                            @elseif($activeSurvey->approval_status === 'approved') Aprobada
                            @else Rechazada
                            @endif
                        </div>
                    </div>

                    {{-- Preview Section --}}
                    <div style="background:var(--bg-light); border-radius:16px; padding:24px; margin-bottom:24px; box-shadow:inset 2px 2px 6px rgba(0,0,0,0.05);">
                        <div style="font-size:10px; font-weight:800; letter-spacing:1px; color:var(--text-light); text-transform:uppercase; margin-bottom:12px;">
                            PREVIEW DE LA ENCUESTA
                        </div>
                        
                        <div style="display:flex; gap:20px; font-size:13px; color:var(--text-muted); margin-bottom:16px; padding-bottom:16px; border-bottom:1px dashed rgba(0,0,0,0.1);">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:16px;">🗓️</span>
                                {{ optional($activeSurvey->start_date)->format('d/m/Y') }} – {{ optional($activeSurvey->end_date)->format('d/m/Y') }}
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:16px;">📄</span>
                                {{ is_array($activeSurvey->questions) ? count($activeSurvey->questions) : 0 }} preguntas
                            </div>
                        </div>

                        {{-- First Question Preview --}}
                        @if(is_array($activeSurvey->questions) && count($activeSurvey->questions) > 0)
                            @php $q1 = $activeSurvey->questions[0]; @endphp
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <div style="font-weight:600; color:var(--text-dark);">
                                    1. {{ $q1['text'] ?? 'Sin texto' }}
                                </div>
                                <div style="font-size:10px; font-weight:700; background:var(--bg); padding:4px 8px; border-radius:6px; color:var(--text-muted); text-transform:uppercase; box-shadow:1px 1px 3px rgba(0,0,0,0.05);">
                                    {{ str_replace('_', ' ', $q1['type'] ?? 'TEXTO') }}
                                </div>
                            </div>
                        @else
                            <div style="font-style:italic; color:var(--text-muted);">Sin preguntas configuradas</div>
                        @endif
                    </div>

                    {{-- Actions Form --}}
                    @if($activeSurvey->approval_status === 'pending')
                        <form method="POST" action="{{ route('admin.aprobaciones.update', $activeSurvey->id) }}">
                            @csrf
                            <div style="margin-bottom:24px;">
                                <input type="text" name="comment" placeholder="Comentario para el editor (opcional)..." 
                                    style="width:100%; padding:16px; border-radius:16px; border:none; background:var(--bg); box-shadow:inset 3px 3px 8px rgba(0,0,0,0.06), inset -2px -2px 6px rgba(255,255,255,0.5); outline:none; color:var(--text-dark);">
                            </div>

                            <div style="display:flex; gap:16px;">
                                <button type="submit" name="decision" value="reject" 
                                    style="flex:1; padding:14px; border-radius:12px; border:none; background:var(--bg); color:var(--red); font-weight:700; cursor:pointer; box-shadow:6px 6px 12px rgba(0,0,0,0.08), -6px -6px 12px rgba(255,255,255,0.8); transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    Rechazar
                                </button>
                                <button type="submit" name="decision" value="approve" 
                                    style="flex:1; padding:14px; border-radius:12px; border:none; background:var(--uaemex); color:white; font-weight:700; cursor:pointer; box-shadow:4px 4px 10px rgba(45,80,22,0.3); transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Aprobar
                                </button>
                            </div>
                        </form>
                    @else
                        <div style="padding:20px; text-align:center; background:var(--bg); border-radius:12px; color:var(--text-muted); font-style:italic;">
                            Esta encuesta ya fue {{ $activeSurvey->approval_status === 'approved' ? 'aprobada' : 'rechazada' }}.
                        </div>
                    @endif

                </div>
            @else
                {{-- Empty State --}}
                <div class="neu-card" style="padding:60px; text-align:center; min-height:400px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                    <div style="font-size:48px; margin-bottom:16px;">✨</div>
                    <h3 style="font-size:20px; font-weight:700; color:var(--text-dark); margin-bottom:8px;">¡Todo al día!</h3>
                    <p style="color:var(--text-muted);">No hay encuestas pendientes de aprobación en este momento.</p>
                </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: HISTORY & TABS --}}
        <div>
            <div class="neu-card" style="padding:20px;">
                <h3 style="font-size:16px; font-weight:700; color:var(--text-dark); margin-bottom:16px;">Historial de aprobaciones</h3>
                
                {{-- Tabs --}}
                <div style="display:flex; gap:4px; background:var(--bg); padding:4px; border-radius:12px; margin-bottom:20px; box-shadow:inset 2px 2px 5px rgba(0,0,0,0.05);">
                    <button onclick="switchTab('pending')" id="tab-pending" class="tab-btn active" style="flex:1; padding:8px; border-radius:8px; border:none; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.2s;">Pendientes</button>
                    <button onclick="switchTab('approved')" id="tab-approved" class="tab-btn" style="flex:1; padding:8px; border-radius:8px; border:none; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.2s;">Aprobadas</button>
                    <button onclick="switchTab('rejected')" id="tab-rejected" class="tab-btn" style="flex:1; padding:8px; border-radius:8px; border:none; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.2s;">Rechazadas</button>
                </div>

                {{-- List Container --}}
                <div style="display:flex; flex-direction:column; gap:12px; max-height:600px; overflow-y:auto;">
                    
                    {{-- PENDING LIST --}}
                    <div id="list-pending" class="tab-content">
                        @forelse($pendingSurveys as $survey)
                            <a href="?id={{ $survey->id }}" style="text-decoration:none; display:block;">
                                <div class="list-card {{ $activeSurvey && $activeSurvey->id == $survey->id ? 'active' : '' }}">
                                    <div style="font-weight:700; font-size:13px; color:var(--text-dark); margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $survey->title }}
                                    </div>
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <div class="badge badge-pending">Pendiente</div>
                                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase;">
                                            {{ optional($survey->user)->name ?? 'User' }} · {{ $survey->created_at->diffForHumans(null, true, true) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="empty-list">No hay más pendientes</div>
                        @endforelse
                    </div>

                    {{-- APPROVED LIST --}}
                    <div id="list-approved" class="tab-content" style="display:none;">
                        @forelse($history->where('approval_status', 'approved') as $survey)
                            <a href="?id={{ $survey->id }}" style="text-decoration:none; display:block;">
                                <div class="list-card {{ $activeSurvey && $activeSurvey->id == $survey->id ? 'active' : '' }}">
                                    <div style="font-weight:700; font-size:13px; color:var(--text-dark); margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $survey->title }}
                                    </div>
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <div class="badge badge-approved">✓ Aprobada</div>
                                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase;">
                                            {{ optional($survey->user)->name ?? 'User' }} · {{ optional($survey->approved_at)->diffForHumans(null, true, true) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="empty-list">Sin historial de aprobadas</div>
                        @endforelse
                    </div>

                    {{-- REJECTED LIST --}}
                    <div id="list-rejected" class="tab-content" style="display:none;">
                        @forelse($history->where('approval_status', 'rejected') as $survey)
                            <a href="?id={{ $survey->id }}" style="text-decoration:none; display:block;">
                                <div class="list-card {{ $activeSurvey && $activeSurvey->id == $survey->id ? 'active' : '' }}">
                                    <div style="font-weight:700; font-size:13px; color:var(--text-dark); margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $survey->title }}
                                    </div>
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <div class="badge badge-rejected">✕ Rechazada</div>
                                        <div style="font-size:10px; color:var(--text-muted); text-transform:uppercase;">
                                            {{ optional($survey->user)->name ?? 'User' }} · {{ optional($survey->approved_at)->diffForHumans(null, true, true) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="empty-list">Sin historial de rechazadas</div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        /* TAB STYLES */
        .tab-btn { background: transparent; color: var(--text-muted); }
        .tab-btn:hover { color: var(--text-dark); background: rgba(0,0,0,0.03); }
        .tab-btn.active { background: var(--uaemex); color: white; box-shadow: 2px 2px 6px rgba(0,0,0,0.2); }

        /* LIST CARD STYLES */
        .list-card {
            background: var(--bg-light);
            padding: 14px;
            border-radius: 12px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.03);
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .list-card:hover { transform: translateY(-2px); box-shadow: 4px 4px 8px rgba(0,0,0,0.06); }
        .list-card.active { border-color: var(--uaemex); background: white; }

        /* BADGES */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; }
        .badge-pending { background: var(--oro-pale); color: #8a6a00; }
        .badge-approved { background: var(--verde-pale); color: var(--uaemex); }
        .badge-rejected { background: var(--red-pale); color: var(--red); }

        .empty-list { text-align: center; font-size: 12px; color: var(--text-muted); padding: 20px; font-style: italic; }
    </style>

    <script>
        function switchTab(tabName) {
            // Hide all lists
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            // Show target list
            document.getElementById('list-' + tabName).style.display = 'block';
            
            // Reset tabs
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            // Activate target tab
            document.getElementById('tab-' + tabName).classList.add('active');
        }
    </script>
@endsection
