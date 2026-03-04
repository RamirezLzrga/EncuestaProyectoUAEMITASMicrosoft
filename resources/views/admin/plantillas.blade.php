@extends('layouts.admin')

@section('title', 'Plantillas Globales')

@section('content')
<div class="ph">
    <div class="ph-left">
        <div class="ph-label">CONFIGURACIÓN</div>
        <h1 class="ph-title">Plantillas Globales</h1>
        <div class="ph-sub">Gestiona las plantillas base para encuestas</div>
    </div>
</div>

<div class="dash-grid">
    <!-- TOP BAR: CREATE/EDIT FORM -->
    <div style="grid-column: span 12;">
        <form method="POST" action="{{ isset($editingTemplate) ? route('admin.plantillas.update', $editingTemplate) : route('admin.plantillas.store') }}" class="filter-neu">
            @csrf
            @if(isset($editingTemplate)) @method('PUT') @endif
            
            <div class="fn-label">
                {{ isset($editingTemplate) ? 'EDITANDO PLANTILLA:' : 'NUEVA PLANTILLA:' }}
            </div>

            <div class="fn-search">
                <input type="text" name="name" class="fn-input" placeholder="Nombre de la plantilla..." value="{{ old('name', isset($editingTemplate) ? $editingTemplate->name : '') }}" style="width:100%;">
            </div>

            <select name="category" class="fn-input">
                @foreach($categories as $category)
                <option value="{{ $category }}" {{ old('category', isset($editingTemplate) ? $editingTemplate->category : null) === $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
                @endforeach
            </select>

            <label class="badge-neu bn-muted" style="cursor:pointer; background:transparent; box-shadow:none;">
                <input type="checkbox" name="is_mandatory" value="1" {{ old('is_mandatory', isset($editingTemplate) ? $editingTemplate->is_mandatory : false) ? 'checked' : '' }} style="margin-right:6px;">
                Obligatoria
            </label>

            <button type="submit" class="btn btn-solid btn-sm">
                <i class="fas fa-plus"></i> {{ isset($editingTemplate) ? 'Actualizar' : 'Crear' }}
            </button>
        </form>
    </div>

    <!-- LEFT COLUMN: LIST -->
    <div style="grid-column: span 8;">
        <div class="nc">
            <div class="cc-header">
                <div class="cc-title">Lista de Plantillas</div>
                <div class="tab-group">
                    @foreach($categories as $category)
                    <div class="tg-tab">{{ $category }}</div>
                    @endforeach
                </div>
            </div>

            <div class="rc-list">
                @forelse($templates as $template)
                <div class="rc-item">
                    <div class="rc-top">
                        <div class="rc-name">{{ $template->name }}</div>
                        <div class="rc-num" style="display:flex; gap:8px;">
                            <a href="{{ route('admin.plantillas.edit', $template) }}" style="color:var(--text-muted);"><i class="fas fa-pen"></i></a>
                            
                            <form method="POST" action="{{ route('admin.plantillas.destroy', $template) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="border:none; background:none; color:var(--red); cursor:pointer;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="rc-bar-wrap" style="justify-content:space-between;">
                        <span class="badge-neu bn-muted" style="font-size:9px;">{{ $template->category }}</span>
                        @if($template->is_mandatory)
                        <span class="badge-neu bn-gold" style="font-size:9px;"><i class="fas fa-star"></i> OBLIGATORIA</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="nc-inset" style="text-align:center; color:var(--text-muted);">
                    No hay plantillas registradas.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: PREVIEW -->
    <div style="grid-column: span 4;">
        <div class="nc">
            <div class="cc-header">
                <div class="cc-title">Vista Previa</div>
            </div>
            
            <div class="nc-inset" style="font-size:12px; color:var(--text-muted); line-height:1.6;">
                <strong style="color:var(--text-dark);">Estructura Base:</strong><br>
                1. Título y Descripción<br>
                2. Datos Demográficos<br>
                3. Preguntas de la Categoría<br>
                4. Comentarios Finales
            </div>

            <div class="uc-stats" style="margin-top:16px;">
                <div class="uc-stat">
                    <div class="uc-stat-val">4</div>
                    <div class="uc-stat-label">Secciones</div>
                </div>
                <div class="uc-stat">
                    <div class="uc-stat-val">12</div>
                    <div class="uc-stat-label">Preguntas</div>
                </div>
            </div>

            <div class="fg" style="margin-top:16px;">
                <label>Configuración Rápida</label>
                <div class="fg-row" style="grid-template-columns:1fr;">
                    <div class="badge-neu bn-muted" style="justify-content:space-between;">
                        <span>Requiere Login</span>
                        <i class="fas fa-check" style="color:var(--verde);"></i>
                    </div>
                    <div class="badge-neu bn-muted" style="justify-content:space-between;">
                        <span>Anónima</span>
                        <i class="fas fa-times" style="color:var(--red);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
