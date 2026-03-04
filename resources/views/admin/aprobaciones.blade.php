@extends('layouts.admin')

@section('title', 'Aprobaciones')

@section('content')
<div class="ph">
    <div class="ph-left">
        <div class="ph-label">ADMINISTRACIÓN</div>
        <h1 class="ph-title">Aprobaciones</h1>
        <div class="ph-sub">Gestiona las encuestas pendientes de publicación</div>
    </div>
</div>

<div class="approvals-layout">
    <!-- LEFT COLUMN: PENDING FEED -->
    <div>
        @if($pendingSurveys->isEmpty())
            <div class="nc" style="text-align:center; color:var(--text-muted);">
                <p>No hay encuestas pendientes de aprobación en este momento.</p>
            </div>
        @else
            @foreach($pendingSurveys as $survey)
            <div class="approval-item-card">
                <div class="ai-top">
                    <div>
                        <div class="ai-title">{{ $survey->title }}</div>
                        <div class="ai-meta">
                            Por {{ optional($survey->user)->name ?? 'Sin asignar' }} · Creada {{ optional($survey->created_at)->diffForHumans() }}
                        </div>
                    </div>
                    <div class="badge-neu bn-gold">PENDIENTE</div>
                </div>

                <div class="ai-preview">
                    <div class="aip-label">DETALLES DE LA ENCUESTA</div>
                    <div class="aip-dates">
                        Vigencia: {{ optional($survey->start_date)->format('d/m/Y') ?? 'N/A' }} — {{ optional($survey->end_date)->format('d/m/Y') ?? 'N/A' }}
                        @if(isset($survey->settings) && isset($survey->settings['max_responses']))
                         · Límite: {{ $survey->settings['max_responses'] }} resp.
                        @endif
                    </div>
                    
                    @if(is_array($survey->questions) && count($survey->questions) > 0)
                        @foreach(array_slice($survey->questions, 0, 3) as $index => $question)
                        <div class="aip-q">
                            <span>{{ $index + 1 }}. {{ $question['text'] ?? 'Sin texto' }}</span>
                            @if(!empty($question['type']))
                            <span class="badge-neu bn-muted" style="font-size:9px; padding:2px 6px;">{{ strtoupper(str_replace('_', ' ', $question['type'])) }}</span>
                            @endif
                        </div>
                        @endforeach
                        @if(count($survey->questions) > 3)
                        <div class="aip-q" style="color:var(--text-light); justify-content:center; margin-top:6px;">
                            + {{ count($survey->questions) - 3 }} preguntas más
                        </div>
                        @endif
                    @else
                        <div class="aip-q" style="color:var(--text-muted); font-style:italic;">Sin preguntas configuradas</div>
                    @endif
                </div>

                <form method="POST" action="{{ route('admin.aprobaciones.update', $survey) }}">
                    @csrf
                    <input type="text" name="comment" class="ai-comment" placeholder="Añadir comentario para el editor (opcional)..." value="{{ old('comment') }}">
                    
                    <div class="ai-btns">
                        <button type="submit" name="decision" value="approve" class="btn btn-solid">
                            <i class="fas fa-check"></i> Aprobar
                        </button>
                        <button type="submit" name="decision" value="reject" class="btn btn-neu" style="color:var(--red);">
                            <i class="fas fa-times"></i> Rechazar
                        </button>
                    </div>
                </form>
            </div>
            @endforeach
        @endif
    </div>

    <!-- RIGHT COLUMN: HISTORY SIDEBAR -->
    <div>
        <div class="hist-neu">
            <div class="hn-head">
                <div class="hn-title">Historial Reciente</div>
            </div>
            <div class="hn-tabs">
                <div class="hn-tab active">Todo</div>
                <!-- Future implementation: Filter functionality -->
            </div>
            <div class="hn-list">
                @forelse($history as $item)
                <div class="hn-item">
                    <div class="hn-name">{{ $item->title }}</div>
                    <div class="hn-meta">
                        <span style="color: {{ $item->approval_status === 'approved' ? 'var(--green)' : 'var(--red)' }}; font-weight:700;">
                            {{ $item->approval_status === 'approved' ? 'APROBADA' : 'RECHAZADA' }}
                        </span>
                        <span>{{ optional($item->updated_at)->diffForHumans() }}</span>
                    </div>
                    @if($item->approval_comment)
                    <div class="hn-meta" style="margin-top:4px; color:var(--text); font-style:italic;">
                        "{{ $item->approval_comment }}"
                    </div>
                    @endif
                </div>
                @empty
                <div class="hn-item" style="text-align:center; color:var(--text-muted);">
                    Sin historial reciente
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
