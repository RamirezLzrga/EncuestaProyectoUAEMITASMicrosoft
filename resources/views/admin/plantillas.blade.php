@extends('layouts.admin')

@section('title', 'Plantillas Globales')

@section('content')
<div class="ph">
    <div class="ph-left">
        <div class="ph-label">Administración</div>
        <div class="ph-title">Plantillas Globales</div>
        <div class="ph-sub">Gestiona las plantillas base que usarán los editores</div>
    </div>
    <div class="ph-actions" style="flex-wrap:wrap;">
        <form method="POST" action="{{ isset($editingTemplate) ? route('admin.plantillas.update', $editingTemplate) : route('admin.plantillas.store') }}" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
            @csrf
            @if(isset($editingTemplate))
                @method('PUT')
            @endif
            <input type="text" name="name" placeholder="Nombre de plantilla" value="{{ old('name', isset($editingTemplate) ? $editingTemplate->name : '') }}" class="form-input" style="width:auto; min-width:200px;">
            <select name="category" class="form-input" style="width:auto; min-width:180px; padding-right:34px;">
                @foreach($categories as $category)
                    <option value="{{ $category }}" @if(old('category', isset($editingTemplate) ? $editingTemplate->category : null) === $category) selected @endif>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:700; color:var(--text-muted);">
                <input type="checkbox" name="is_mandatory" value="1" @if(old('is_mandatory', isset($editingTemplate) ? $editingTemplate->is_mandatory : false)) checked @endif>
                Obligatoria
            </label>
            <button type="submit" class="btn btn-solid btn-sm">
                {{ isset($editingTemplate) ? 'Actualizar' : 'Nueva' }}
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="neu-card" style="margin-bottom:0; grid-column: span 2; padding:22px;">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-layer-group text-uaemex"></i>
                Lista de plantillas
            </h2>
            <div class="flex gap-2">
                @foreach($categories as $category)
                    <button class="btn btn-neu btn-sm" type="button" style="padding:6px 12px;">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="space-y-3">
            @forelse($templates as $template)
                <div style="background:var(--bg); border-radius:var(--radius); box-shadow:var(--neu-in-sm); padding:16px; display:flex; align-items:center; justify-content:space-between; gap:14px;">
                    <div>
                        <p style="font-weight:800; color:var(--text-dark);">{{ $template->name }}</p>
                        <p style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ $template->category }}</p>
                        @if($template->is_mandatory)
                            <span class="status-pill status-pending" style="background:var(--bg); margin-top:8px;">
                                Obligatoria
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <a
                            href="{{ route('admin.plantillas.edit', $template) }}"
                            class="btn btn-neu btn-sm"
                        >
                            Editar
                        </a>
                        <form method="POST" action="{{ route('admin.plantillas.destroy', $template) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                            >
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align:center; color:var(--text-muted); padding:24px;">Aún no hay plantillas creadas.</div>
            @endforelse
        </div>
    </div>

    <div class="neu-card" style="margin-bottom:0; padding:22px;">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-uaemex"></i>
            Preview de plantilla
        </h2>
        <p class="text-sm text-gray-600 mb-3">
            Aquí se mostrará una previsualización interactiva de la plantilla seleccionada: estructura de secciones, tipo de preguntas y lógica básica.
        </p>
        <div style="background:var(--bg-light); border-radius:var(--radius); padding:14px; box-shadow:var(--neu-in-sm); font-size:12px; color:var(--text-muted); display:flex; flex-direction:column; gap:6px;">
            <p style="font-weight:800; color:var(--text);">Ejemplo:</p>
            <p>Título: Encuesta de Satisfacción General</p>
            <p>Secciones: Datos generales, Satisfacción, Comentarios.</p>
            <p>Preguntas tipo: escala Likert, opción múltiple y campo abierto.</p>
        </div>
        <div class="mt-4">
            <label style="display:flex; align-items:center; gap:10px; font-size:12px; color:var(--text-muted);">
                <input type="checkbox" class="rounded border-gray-300 text-uaemex focus:ring-uaemex">
                Marcar como obligatoria para los editores
            </label>
        </div>
    </div>
</div>
@endsection
