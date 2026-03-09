@extends('layouts.editor')

@section('content')

{{-- Page Header --}}
<div class="ph">
    <div>
        <div class="ph-label">Editor · {{ $mode === 'create' ? 'Nueva Encuesta' : 'Editar Encuesta' }}</div>
        <h1 class="ph-title">{{ $mode === 'create' ? 'Nueva Encuesta' : 'Editar Encuesta' }}</h1>
        <p class="ph-sub">Editor visual para construir y ajustar tu encuesta</p>
    </div>
    <div class="ph-actions">
        <a href="{{ route('surveys.index') }}" class="btn btn-neu btn-sm">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Mis encuestas
        </a>
        <button type="submit" form="builderForm" class="btn btn-solid">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
            Guardar cambios
        </button>
    </div>
</div>

@php
    $action = $mode === 'create'
        ? route('editor.encuestas.store')
        : route('editor.encuestas.update', $survey);
@endphp

<form action="{{ $action }}" method="POST" id="builderForm">
    @csrf
    @if($mode === 'edit')
        @method('PUT')
    @endif

    <input type="hidden" name="year" value="{{ $survey->year ?? date('Y') }}">
    <input type="hidden" name="start_date" value="{{ optional($survey->start_date)->format('Y-m-d') ?? date('Y-m-d') }}">
    <input type="hidden" name="end_date" value="{{ optional($survey->end_date)->format('Y-m-d') ?? date('Y-m-d', strtotime('+1 month')) }}">

    <div class="editor-layout">
        
        {{-- LEFT PANEL --}}
        <div class="editor-left">
            <div class="ed-panel">
                <div class="ed-panel-title">Tipos de pregunta</div>
                
                <button type="button" data-type="multiple_choice" class="q-type-btn add-question-type">
                    <div class="q-type-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg></div>
                    Opción múltiple
                    <div class="q-type-plus">+</div>
                </button>
                
                <button type="button" data-type="checkboxes" class="q-type-btn add-question-type">
                    <div class="q-type-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg></div>
                    Casillas
                    <div class="q-type-plus">+</div>
                </button>
                
                <button type="button" data-type="short_text" class="q-type-btn add-question-type">
                    <div class="q-type-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 7V4h16v3M9 20h6M12 4v16"/></svg></div>
                    Texto corto
                    <div class="q-type-plus">+</div>
                </button>
                
                <button type="button" data-type="paragraph" class="q-type-btn add-question-type">
                    <div class="q-type-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="21" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="3" y2="18"></line></svg></div>
                    Texto largo
                    <div class="q-type-plus">+</div>
                </button>

                <button type="button" data-type="linear_scale" class="q-type-btn add-question-type">
                    <div class="q-type-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></div>
                    Escala
                    <div class="q-type-plus">+</div>
                </button>
            </div>

            <div class="ed-panel">
                <div class="ed-panel-title">Acciones</div>
                <a href="{{ $mode === 'edit' ? route('editor.encuestas.configuracion', $survey) : '#' }}" class="btn btn-neu w-full {{ $mode === 'create' ? 'opacity-50 cursor-not-allowed' : '' }}" style="width:100%; justify-content:center;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"></path></svg>
                    Configuración general
                </a>
                <button type="submit" class="btn btn-solid w-full mt-3" style="width:100%; justify-content:center;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Guardar cambios
                </button>
            </div>
        </div>

        {{-- CENTER PANEL --}}
        <div class="editor-center">
            
            <div class="ed-form-header">
                <input type="text" name="title" id="input-title" value="{{ old('title', $survey->title) }}" placeholder="Encuesta sin título" class="ed-form-title-input" required>
                <input type="text" name="description" id="input-description" value="{{ old('description', $survey->description) }}" placeholder="Descripción de la encuesta" class="ed-form-desc-input">
            </div>

            <div id="questions-container" style="display:flex; flex-direction:column; gap:14px;">
                {{-- Questions will be injected here --}}
            </div>

            <button type="button" id="btn-add-question" class="add-q-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Agregar pregunta
            </button>
        </div>

        {{-- RIGHT PANEL (Preview) --}}
        <div class="editor-right">
            <div class="preview-panel">
                <div class="pv-header">
                    <div class="pv-label">VISTA PREVIA</div>
                    <div id="preview-title" class="pv-title">Sin título</div>
                    <div id="preview-description" class="pv-sub">Sin descripción</div>
                </div>
                <div class="pv-bar"><div class="pv-bar-fill"></div></div>
                <div id="preview-questions" class="pv-body">
                    <div class="text-center text-muted" style="padding:20px; font-size:12px; color:var(--text-muted);">
                        Agrega preguntas para visualizar
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

{{-- TEMPLATE FOR NEW QUESTION --}}
<template id="question-template">
    <div class="q-card question-item">
        <div class="q-top">
            <input type="text" class="q-input question-input-text" placeholder="Escribe la pregunta">
            
            <div style="position:relative; width:140px;">
                <select class="q-input question-input-type" style="width:100%;">
                    <option value="multiple_choice">Opción múltiple</option>
                    <option value="checkboxes">Casillas</option>
                    <option value="short_text">Texto corto</option>
                    <option value="paragraph">Texto largo</option>
                    <option value="linear_scale">Escala</option>
                    <option value="date">Fecha</option>
                </select>
            </div>
        </div>

        {{-- Options container (for multiple choice/checkboxes) --}}
        <div class="options-container" style="padding-left:10px;">
            <div class="option-item opt-row">
                <div class="opt-circle"></div>
                <input type="text" class="opt-input question-input-option" value="Opción 1">
                <div class="opt-del btn-remove-option">✕</div>
            </div>
            <div class="add-opt btn-add-option">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Agregar opción
            </div>
        </div>

        {{-- Scale Configuration --}}
        <div class="scale-config" style="display:none; margin-top:10px; padding-left:10px;">
            <div style="display:flex; gap:10px; align-items:center; margin-bottom:8px;">
                <label style="font-size:12px; color:#666;">Rango:</label>
                <select class="q-input question-input-scale-min" style="width:60px;">
                    <option value="0">0</option>
                    <option value="1" selected>1</option>
                </select>
                <span style="font-size:12px; color:#666;">a</span>
                <select class="q-input question-input-scale-max" style="width:60px;">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5" selected>5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>
            <div style="display:grid; grid-template-columns: auto 1fr; gap:8px; align-items:center;">
                <span class="scale-label-preview-min" style="font-size:12px; color:#666; width:20px; text-align:center;">1</span>
                <input type="text" class="q-input question-input-scale-min-label" placeholder="Etiqueta para el mínimo (opcional)" style="font-size:12px;">
                
                <span class="scale-label-preview-max" style="font-size:12px; color:#666; width:20px; text-align:center;">5</span>
                <input type="text" class="q-input question-input-scale-max-label" placeholder="Etiqueta para el máximo (opcional)" style="font-size:12px;">
            </div>
        </div>

        <div class="q-footer">
            <label class="chk-group">
                <div class="chk question-input-required-chk"></div>
                <input type="checkbox" class="question-input-required" style="display:none;">
                Obligatoria
            </label>
            <div style="display:flex; gap:10px;">
                <button type="button" class="btn-remove-question" style="background:none; border:none; color:var(--text-muted); cursor:pointer;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path></svg>
                </button>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    let questionIndex = 0;

    document.addEventListener('DOMContentLoaded', function () {
        // Quick add buttons (left panel)
        document.querySelectorAll('.add-question-type').forEach(function (btn) {
            btn.addEventListener('click', function () {
                addQuestion(btn.getAttribute('data-type'));
            });
        });

        // Main add button (bottom)
        const addButton = document.getElementById('btn-add-question');
        if (addButton) {
            addButton.addEventListener('click', function () {
                addQuestion('multiple_choice');
            });
        }

        const form = document.getElementById('builderForm');
        form.addEventListener('submit', function () {
            syncQuestionsToInputs();
        });

        // Live preview updates
        form.addEventListener('input', function () {
            updatePreview();
        });

        // Initial Load
        @if($survey->questions && count($survey->questions) > 0)
            @foreach($survey->questions as $q)
                addQuestion(@json($q['type']), @json($q));
            @endforeach
        @else
            addQuestion('multiple_choice');
        @endif

        updatePreview();
    });

    function addQuestion(type, existing) {
        const container = document.getElementById('questions-container');
        const template = document.getElementById('question-template');
        const node = template.content.cloneNode(true);
        const item = node.querySelector('.question-item');

        const textInput = item.querySelector('.question-input-text');
        const typeSelect = item.querySelector('.question-input-type');
        const requiredInput = item.querySelector('.question-input-required');
        const requiredChk = item.querySelector('.question-input-required-chk');

        // Required checkbox custom UI
        requiredChk.addEventListener('click', () => {
            requiredChk.classList.toggle('on');
            requiredChk.textContent = requiredChk.classList.contains('on') ? '✓' : '';
            requiredInput.checked = requiredChk.classList.contains('on');
            updatePreview();
        });

        if (existing) {
            textInput.value = existing.text || '';
            typeSelect.value = existing.type || type;
            if (existing.required) {
                requiredInput.checked = true;
                requiredChk.classList.add('on');
                requiredChk.textContent = '✓';
            }

            // Populate scale data if available
            if (existing.scale_min !== undefined) item.querySelector('.question-input-scale-min').value = existing.scale_min;
            if (existing.scale_max !== undefined) item.querySelector('.question-input-scale-max').value = existing.scale_max;
            if (existing.scale_min_label) item.querySelector('.question-input-scale-min-label').value = existing.scale_min_label;
            if (existing.scale_max_label) item.querySelector('.question-input-scale-max-label').value = existing.scale_max_label;

            // Restore options if applicable
            const optionsContainer = item.querySelector('.options-container');
            const baseOption = optionsContainer.querySelector('.option-item');
            
            // Remove initial dummy option
            optionsContainer.querySelectorAll('.option-item').forEach((opt, idx) => {
                 opt.remove(); 
            });

            if (existing.options && existing.options.length) {
                existing.options.forEach(function (optText) {
                    const clone = baseOption.cloneNode(true);
                    clone.querySelector('.question-input-option').value = optText;
                    setupOptionRemove(clone);
                    optionsContainer.insertBefore(clone, optionsContainer.querySelector('.btn-add-option'));
                });
            } else {
                 // If no options but type needs them, add one blank
                 if(['multiple_choice','checkboxes','dropdown'].includes(existing.type)){
                    const clone = baseOption.cloneNode(true);
                    clone.querySelector('.question-input-option').value = 'Opción 1';
                    setupOptionRemove(clone);
                    optionsContainer.insertBefore(clone, optionsContainer.querySelector('.btn-add-option'));
                 }
            }
        } else {
            typeSelect.value = type;
            // Setup initial option remove for new question
            const optionsContainer = item.querySelector('.options-container');
            setupOptionRemove(optionsContainer.querySelector('.option-item'));
        }

        setupTypeBehavior(item, typeSelect);

        // Remove question
        item.querySelector('.btn-remove-question').addEventListener('click', function () {
            if (document.querySelectorAll('.question-item').length > 1) {
                item.remove();
                updatePreview();
            }
        });

        // Add option
        const addOptionBtn = item.querySelector('.btn-add-option');
        addOptionBtn.addEventListener('click', function () {
            const optionsContainer = item.querySelector('.options-container');
            // We need a template for options. We can clone the first one found or create new
            // Easier: clone the structure from template or JS construction
            const row = document.createElement('div');
            row.className = 'option-item opt-row';
            row.innerHTML = `
                <div class="opt-circle"></div>
                <input type="text" class="opt-input question-input-option" value="Nueva opción">
                <div class="opt-del btn-remove-option">✕</div>
            `;
            setupOptionRemove(row);
            optionsContainer.insertBefore(row, addOptionBtn);
            updatePreview();
        });

        container.appendChild(item);
        questionIndex++;
        updatePreview();
    }

    function setupOptionRemove(row) {
        row.querySelector('.btn-remove-option').addEventListener('click', function () {
            const container = row.parentElement;
            if (container.querySelectorAll('.option-item').length > 1) {
                row.remove();
                updatePreview();
            }
        });
        // Also trigger preview update on input change
        row.querySelector('input').addEventListener('input', updatePreview);
    }

    function setupTypeBehavior(item, select) {
        const optionsContainer = item.querySelector('.options-container');
        const scaleConfig = item.querySelector('.scale-config');

        function apply() {
            const val = select.value;
            // Hide options for text/date/scale types
            const simpleTypes = ['short_text', 'paragraph', 'linear_scale', 'date', 'time'];
            
            if (simpleTypes.includes(val)) {
                if (optionsContainer) optionsContainer.style.display = 'none';
            } else {
                if (optionsContainer) {
                    optionsContainer.style.display = 'block';
                    // Update icons based on type (circle vs square)
                    const isCheck = (val === 'checkboxes');
                    optionsContainer.querySelectorAll('.opt-circle').forEach(circle => {
                        circle.style.borderRadius = isCheck ? '4px' : '50%';
                    });
                }
            }

            // Scale config visibility
            if (val === 'linear_scale') {
                if (scaleConfig) scaleConfig.style.display = 'block';
            } else {
                if (scaleConfig) scaleConfig.style.display = 'none';
            }
        }

        select.addEventListener('change', function () {
            apply();
            updatePreview();
        });

        // Listen for changes in scale config to update preview
        if (scaleConfig) {
            const minSelect = scaleConfig.querySelector('.question-input-scale-min');
            const maxSelect = scaleConfig.querySelector('.question-input-scale-max');
            const minLabelInput = scaleConfig.querySelector('.question-input-scale-min-label');
            const maxLabelInput = scaleConfig.querySelector('.question-input-scale-max-label');
            const minPreview = scaleConfig.querySelector('.scale-label-preview-min');
            const maxPreview = scaleConfig.querySelector('.scale-label-preview-max');

            function updateScaleLabels() {
                if (minPreview) minPreview.textContent = minSelect.value;
                if (maxPreview) maxPreview.textContent = maxSelect.value;
                updatePreview();
            }

            minSelect.addEventListener('change', updateScaleLabels);
            maxSelect.addEventListener('change', updateScaleLabels);
            minLabelInput.addEventListener('input', updatePreview);
            maxLabelInput.addEventListener('input', updatePreview);
        }

        apply();
    }

    function syncQuestionsToInputs() {
        const container = document.getElementById('questions-container');
        const items = container.querySelectorAll('.question-item');

        // Clear old hidden inputs if any (usually form submission handles this, but we rename attributes)
        // We actually just need to ensure the name attributes are correct before submit
        
        let index = 0;
        items.forEach(function (item) {
            const textInput = item.querySelector('.question-input-text');
            const typeSelect = item.querySelector('.question-input-type');
            const requiredInput = item.querySelector('.question-input-required');
            const options = item.querySelectorAll('.question-input-option');

            textInput.setAttribute('name', 'questions[' + index + '][text]');
            typeSelect.setAttribute('name', 'questions[' + index + '][type]');
            requiredInput.setAttribute('name', 'questions[' + index + '][required]');

            // Scale inputs
            const scaleMin = item.querySelector('.question-input-scale-min');
            const scaleMax = item.querySelector('.question-input-scale-max');
            const scaleMinLabel = item.querySelector('.question-input-scale-min-label');
            const scaleMaxLabel = item.querySelector('.question-input-scale-max-label');

            if (scaleMin) scaleMin.setAttribute('name', 'questions[' + index + '][scale_min]');
            if (scaleMax) scaleMax.setAttribute('name', 'questions[' + index + '][scale_max]');
            if (scaleMinLabel) scaleMinLabel.setAttribute('name', 'questions[' + index + '][scale_min_label]');
            if (scaleMaxLabel) scaleMaxLabel.setAttribute('name', 'questions[' + index + '][scale_max_label]');

            let optIndex = 0;
            options.forEach(function (opt) {
                opt.setAttribute('name', 'questions[' + index + '][options][' + optIndex + ']');
                optIndex++;
            });

            index++;
        });
    }

    function updatePreview() {
        const titleInput = document.getElementById('input-title');
        const descInput = document.getElementById('input-description');
        const previewTitle = document.getElementById('preview-title');
        const previewDescription = document.getElementById('preview-description');
        const previewQuestions = document.getElementById('preview-questions');

        previewTitle.textContent = titleInput.value || 'Sin título';
        previewDescription.textContent = descInput.value || 'Sin descripción';

        previewQuestions.innerHTML = '';

        const items = document.querySelectorAll('.question-item');
        if (items.length === 0) {
            previewQuestions.innerHTML = '<div class="text-center text-muted" style="padding:20px; font-size:12px;">Agrega preguntas...</div>';
            return;
        }

        let number = 1;
        items.forEach(function (item) {
            const text = item.querySelector('.question-input-text').value || 'Pregunta...';
            const type = item.querySelector('.question-input-type').value;
            const required = item.querySelector('.question-input-required').checked;

            const block = document.createElement('div');
            block.style.marginBottom = '16px';

            const label = document.createElement('div');
            label.className = 'pv-q';
            label.textContent = number + '. ' + text + (required ? ' *' : '');
            block.appendChild(label);

            if (['multiple_choice', 'checkboxes', 'dropdown'].includes(type)) {
                const options = item.querySelectorAll('.question-input-option');
                options.forEach(function (opt) {
                    const row = document.createElement('div');
                    row.className = 'pv-opt';
                    
                    const circle = document.createElement('div');
                    circle.className = 'pv-opt-circle';
                    if (type === 'checkboxes') circle.style.borderRadius = '3px';
                    
                    const span = document.createElement('span');
                    span.textContent = opt.value || 'Opción';
                    
                    row.appendChild(circle);
                    row.appendChild(span);
                    block.appendChild(row);
                });
            } else if (type === 'short_text') {
                const line = document.createElement('div');
                line.style.height = '24px';
                line.style.background = 'rgba(0,0,0,0.03)';
                line.style.borderRadius = '6px';
                line.style.marginTop = '6px';
                line.style.border = '1px solid rgba(0,0,0,0.05)';
                block.appendChild(line);
            } else if (type === 'paragraph') {
                const box = document.createElement('div');
                box.style.height = '60px';
                box.style.background = 'rgba(0,0,0,0.03)';
                box.style.borderRadius = '6px';
                box.style.marginTop = '6px';
                box.style.border = '1px solid rgba(0,0,0,0.05)';
                block.appendChild(box);
            } else if (type === 'linear_scale') {
                const min = parseInt(item.querySelector('.question-input-scale-min').value);
                const max = parseInt(item.querySelector('.question-input-scale-max').value);
                const minLabel = item.querySelector('.question-input-scale-min-label').value;
                const maxLabel = item.querySelector('.question-input-scale-max-label').value;

                const wrapper = document.createElement('div');
                wrapper.style.marginTop = '16px';
                wrapper.style.padding = '0 10px';
                
                // Circles row
                const circles = document.createElement('div');
                circles.style.display = 'flex';
                circles.style.justifyContent = 'space-between';
                circles.style.alignItems = 'flex-end';
                
                // Start label
                if (minLabel) {
                     const l = document.createElement('div');
                     l.textContent = minLabel;
                     l.style.fontSize = '12px';
                     l.style.color = '#64748b';
                     l.style.marginBottom = '6px';
                     l.style.marginRight = '12px';
                     l.style.maxWidth = '80px';
                     circles.appendChild(l);
                }

                const numbersContainer = document.createElement('div');
                numbersContainer.style.display = 'flex';
                numbersContainer.style.gap = '12px';
                numbersContainer.style.flex = '1';
                numbersContainer.style.justifyContent = 'space-around';

                for (let i = min; i <= max; i++) {
                    const col = document.createElement('div');
                    col.style.display = 'flex';
                    col.style.flexDirection = 'column';
                    col.style.alignItems = 'center';
                    col.style.gap = '8px';
                    
                    const num = document.createElement('span');
                    num.textContent = i;
                    num.style.fontSize = '12px';
                    num.style.color = '#64748b';
                    
                    const circle = document.createElement('div');
                    circle.style.width = '24px';
                    circle.style.height = '24px';
                    circle.style.borderRadius = '50%';
                    circle.style.border = '2px solid #cbd5e1';
                    circle.style.backgroundColor = '#fff';
                    
                    col.appendChild(num);
                    col.appendChild(circle);
                    numbersContainer.appendChild(col);
                }
                circles.appendChild(numbersContainer);

                // End label
                if (maxLabel) {
                     const l = document.createElement('div');
                     l.textContent = maxLabel;
                     l.style.fontSize = '12px';
                     l.style.color = '#64748b';
                     l.style.marginBottom = '6px';
                     l.style.marginLeft = '12px';
                     l.style.maxWidth = '80px';
                     l.style.textAlign = 'right';
                     circles.appendChild(l);
                }

                wrapper.appendChild(circles);
                block.appendChild(wrapper);
            } else if (type === 'date') {
                const dateInput = document.createElement('div');
                dateInput.style.borderBottom = '1px solid #e2e8f0';
                dateInput.style.color = '#94a3b8';
                dateInput.style.width = '160px';
                dateInput.style.padding = '8px 0';
                dateInput.style.marginTop = '16px';
                dateInput.style.fontSize = '14px';
                dateInput.innerHTML = '<span style="margin-right:8px">📅</span> dd/mm/aaaa';
                block.appendChild(dateInput);
            }

            previewQuestions.appendChild(block);
            number++;
        });
    }
</script>
@endpush
