@extends('layouts.editor')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">SIEI UAEMex</div>
        <h1 class="ph-title">{{ $mode === 'create' ? 'Nueva Encuesta' : 'Editar Encuesta' }}</h1>
        <div class="ph-sub">Editor visual para construir y ajustar tu encuesta</div>
    </div>
    <div class="ph-actions">
        @if($mode === 'edit')
            <a href="{{ route('surveys.public', $survey->id) }}" target="_blank" class="btn btn-neu btn-sm">
                <i class="fas fa-eye"></i>
                Vista previa
            </a>
        @endif
        <a href="{{ route('editor.dashboard') }}" class="btn btn-neu btn-sm">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
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

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
        <!-- Sidebar Tools (Left) -->
        <div class="space-y-6 xl:col-span-3 sticky top-24">
            <div class="nc space-y-4">
                <p class="text-[11px] uppercase tracking-widest text-[var(--text-muted)] font-bold">Tipos de pregunta</p>
                
                <button type="button" data-type="multiple_choice" class="w-full btn btn-neu btn-sm justify-between add-question-type hover:translate-x-1 transition-transform">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-list-ul text-[var(--verde)]"></i>
                        Opción múltiple
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                
                <button type="button" data-type="checkboxes" class="w-full btn btn-neu btn-sm justify-between add-question-type hover:translate-x-1 transition-transform">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-check-square text-[var(--verde)]"></i>
                        Casillas
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                
                <button type="button" data-type="short_text" class="w-full btn btn-neu btn-sm justify-between add-question-type hover:translate-x-1 transition-transform">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-font text-[var(--verde)]"></i>
                        Texto corto
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                
                <button type="button" data-type="paragraph" class="w-full btn btn-neu btn-sm justify-between add-question-type hover:translate-x-1 transition-transform">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-align-left text-[var(--verde)]"></i>
                        Texto largo
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>

                <button type="button" data-type="dropdown" class="w-full btn btn-neu btn-sm justify-between add-question-type hover:translate-x-1 transition-transform">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-chevron-circle-down text-[var(--verde)]"></i>
                        Desplegable
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                
                <div class="pt-4 border-t border-[var(--neu-dark)]/20">
                    <p class="text-[11px] uppercase tracking-widest text-[var(--text-muted)] font-bold mb-3">Acciones</p>
                    
                    <div class="space-y-3">
                        <a href="{{ $mode === 'edit' ? route('editor.encuestas.configuracion', $survey) : '#' }}" class="w-full btn btn-neu btn-sm justify-between {{ $mode === 'create' ? 'opacity-60 cursor-not-allowed' : '' }}" title="{{ $mode === 'create' ? 'Guarda la encuesta primero' : 'Configuración general' }}">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-sliders-h text-[var(--blue)]"></i>
                                Configuración
                            </span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                        
                        <button type="submit" class="w-full btn btn-solid btn-sm justify-center py-3 shadow-lg hover:shadow-xl transition-shadow">
                            <i class="fas fa-save mr-2"></i>
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Builder Area (Center) -->
        <div class="space-y-6 xl:col-span-6">
            <div class="nc space-y-4 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                <input type="text" name="title" id="input-title" value="{{ old('title', $survey->title) }}" placeholder="Encuesta sin título" class="w-full bg-transparent border-b border-dashed border-gray-300 pb-2 text-2xl font-bold text-[var(--text-dark)] placeholder-[var(--text-muted)] focus:outline-none focus:border-[var(--verde)] transition-colors font-[Sora]" required>
                <textarea name="description" id="input-description" rows="2" placeholder="Descripción de la encuesta" class="w-full bg-transparent border-none text-sm text-[var(--text)] placeholder-[var(--text-muted)] focus:outline-none focus:ring-0 font-[Nunito] resize-none">{{ old('description', $survey->description) }}</textarea>
            </div>

            <div class="flex items-center justify-between px-2">
                <h2 class="text-sm font-bold text-[var(--text-dark)] flex items-center gap-2">
                    <i class="fas fa-layer-group text-[var(--text-muted)]"></i>
                    Preguntas
                </h2>
                <div class="text-xs text-[var(--text-muted)]" id="question-count-badge">0 preguntas</div>
            </div>

            <div id="questions-container" class="space-y-6 min-h-[200px]">
                <!-- Questions will be injected here -->
            </div>
            
            <div class="flex justify-center py-8 border-2 border-dashed border-[var(--neu-dark)] rounded-xl cursor-pointer hover:bg-[var(--bg-light)] transition-colors" id="btn-add-question-large">
                <div class="text-center">
                    <div class="w-10 h-10 rounded-full bg-[var(--verde)]/10 text-[var(--verde)] flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="text-sm font-bold text-[var(--text-dark)]">Agregar nueva pregunta</span>
                </div>
            </div>
        </div>

        <!-- Preview Area (Right) -->
        <div class="space-y-6 xl:col-span-3">
            <div class="nc h-full flex flex-col sticky top-24 max-h-[calc(100vh-120px)]">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] uppercase tracking-widest text-[var(--text-muted)] font-bold">Vista previa</p>
                    <span class="text-[10px] bg-[var(--bg-dark)] px-2 py-1 rounded text-[var(--text-muted)]">Live</span>
                </div>
                
                <div id="preview-container" class="nc-inset flex-1 overflow-y-auto p-4 bg-[var(--bg-light)] rounded-xl border border-[var(--neu-dark)]/50 custom-scrollbar">
                    <div class="w-full max-w-[320px] mx-auto bg-white min-h-[400px] shadow-sm rounded-lg overflow-hidden flex flex-col">
                        <div class="h-1.5 w-full bg-[var(--verde)]"></div>
                        <div class="p-6 space-y-6 flex-1">
                            <div class="border-b border-gray-100 pb-4">
                                <h2 id="preview-title" class="text-lg font-bold text-[var(--text-dark)] font-[Sora] leading-tight">Sin título</h2>
                                <p id="preview-description" class="text-xs text-[var(--text-muted)] mt-2">Sin descripción</p>
                            </div>
                            <div id="preview-questions" class="space-y-6 text-xs text-[var(--text)]">
                                <p class="text-center text-[var(--text-muted)] py-8 italic">
                                    Agrega preguntas para visualizar
                                </p>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                            <button type="button" class="btn btn-solid btn-xs w-full justify-center pointer-events-none opacity-80">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<template id="question-template">
    <div class="question-item nc p-4 relative group transition-all hover:shadow-md border border-transparent hover:border-[var(--neu-dark)]/30">
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-[var(--verde)] rounded-l-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        
        <div class="flex items-start gap-4">
            <div class="flex-1 space-y-4">
                <div class="flex gap-4">
                    <input type="text" class="question-input-text flex-1 nc-inset px-4 py-3 text-sm text-[var(--text-dark)] placeholder-[var(--text-muted)] focus:outline-none border-none bg-[var(--bg)] font-bold" placeholder="Escribe la pregunta aquí">
                    
                    <select class="question-input-type w-1/3 nc-inset px-3 py-2 text-xs text-[var(--text)] focus:outline-none border-none bg-[var(--bg)] appearance-none cursor-pointer">
                        <option value="short_text">Texto corto</option>
                        <option value="paragraph">Párrafo</option>
                        <option value="multiple_choice">Opción múltiple</option>
                        <option value="checkboxes">Casillas</option>
                        <option value="dropdown">Desplegable</option>
                    </select>
                </div>
                
                <div class="options-container space-y-2 pl-4 border-l-2 border-[var(--bg-dark)]" style="display: none;">
                    <div class="option-item flex items-center gap-2">
                        <i class="far fa-circle text-[var(--text-muted)] text-[10px]"></i>
                        <input type="text" class="question-input-option flex-1 bg-transparent border-b border-[var(--neu-dark)] py-1 text-xs text-[var(--text)] placeholder-[var(--text-muted)] focus:outline-none focus:border-[var(--verde)] transition-colors" value="Opción 1">
                        <button type="button" class="btn-remove-option text-[var(--text-muted)] hover:text-[var(--red)] text-[10px] p-1 w-6 h-6 flex items-center justify-center rounded-full hover:bg-red-50 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button type="button" class="btn-add-option text-[11px] text-[var(--verde)] hover:text-[var(--verde-mid)] flex items-center gap-1 font-bold mt-2 px-2 py-1 rounded hover:bg-green-50 transition-colors">
                        <i class="fas fa-plus-circle"></i>
                        Agregar opción
                    </button>
                </div>

                <div class="flex items-center justify-end gap-4 pt-2 border-t border-gray-100">
                    <label class="flex items-center gap-2 text-[11px] text-[var(--text-muted)] cursor-pointer select-none hover:text-[var(--text-dark)] transition-colors">
                        <input type="checkbox" class="question-input-required w-3 h-3 rounded border-[var(--neu-dark)] text-[var(--verde)] focus:ring-[var(--verde)]">
                        Obligatoria
                    </label>
                    
                    <div class="h-4 w-px bg-gray-200"></div>

                    <button type="button" class="btn-remove-question text-[var(--text-muted)] hover:text-[var(--red)] text-[11px] flex items-center gap-1 transition-colors" title="Eliminar pregunta">
                        <i class="fas fa-trash-alt"></i>
                        <span class="hidden group-hover:inline">Eliminar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('builderForm');
        const container = document.getElementById('questions-container');
        const template = document.getElementById('question-template');
        const largeAddBtn = document.getElementById('btn-add-question-large');

        // Initial setup
        @if(old('questions'))
            @foreach(old('questions') as $q)
                addQuestion(@json($q['type']), @json($q));
            @endforeach
        @elseif(isset($survey) && $survey->questions && count($survey->questions) > 0)
            @foreach($survey->questions as $q)
                addQuestion(@json($q['type']), @json($q));
            @endforeach
        @else
            addQuestion('short_text');
        @endif

        updatePreview();

        // Global Event Listeners
        document.querySelectorAll('.add-question-type').forEach(btn => {
            btn.addEventListener('click', () => addQuestion(btn.dataset.type));
        });

        if(largeAddBtn) {
            largeAddBtn.addEventListener('click', () => addQuestion('short_text'));
        }

        document.getElementById('input-title').addEventListener('input', updatePreview);
        document.getElementById('input-description').addEventListener('input', updatePreview);

        form.addEventListener('submit', function () {
            syncQuestionsToInputs();
        });

        function addQuestion(type, existing = null) {
            const clone = template.content.cloneNode(true);
            const item = clone.querySelector('.question-item');
            
            // Elements
            const textInput = item.querySelector('.question-input-text');
            const typeSelect = item.querySelector('.question-input-type');
            const requiredInput = item.querySelector('.question-input-required');
            const optionsContainer = item.querySelector('.options-container');
            const addOptionBtn = item.querySelector('.btn-add-option');
            const removeBtn = item.querySelector('.btn-remove-question');

            // Set Values
            typeSelect.value = existing ? (existing.type || type) : type;
            textInput.value = existing ? (existing.text || '') : '';
            requiredInput.checked = existing ? !!existing.required : false;

            // Handle Options Display
            toggleOptions(typeSelect.value, optionsContainer);

            // Populate Options if existing
            if (existing && ['multiple_choice', 'checkboxes', 'dropdown'].includes(typeSelect.value)) {
                const baseOption = optionsContainer.querySelector('.option-item');
                // Clear existing clones if any (though template has only 1)
                const currentOptions = optionsContainer.querySelectorAll('.option-item');
                currentOptions.forEach((opt, idx) => { if(idx > 0) opt.remove(); });

                if (existing.options && existing.options.length > 0) {
                    existing.options.forEach((optVal, idx) => {
                        if (idx === 0) {
                            baseOption.querySelector('.question-input-option').value = optVal;
                        } else {
                            addOptionToContainer(optionsContainer, addOptionBtn, optVal);
                        }
                    });
                }
            }

            // Event Listeners for this item
            typeSelect.addEventListener('change', function() {
                toggleOptions(this.value, optionsContainer);
                updatePreview();
            });

            textInput.addEventListener('input', updatePreview);
            requiredInput.addEventListener('change', updatePreview);
            
            removeBtn.addEventListener('click', function() {
                if (container.children.length > 1) {
                    item.remove();
                    updatePreview();
                    updateCount();
                } else {
                    alert('La encuesta debe tener al menos una pregunta.');
                }
            });

            addOptionBtn.addEventListener('click', function() {
                addOptionToContainer(optionsContainer, addOptionBtn);
                updatePreview();
            });

            // Delegate option input and remove events
            optionsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-option')) {
                    const optItem = e.target.closest('.option-item');
                    if (optionsContainer.querySelectorAll('.option-item').length > 1) {
                        optItem.remove();
                        updatePreview();
                    }
                }
            });

            optionsContainer.addEventListener('input', function(e) {
                if (e.target.classList.contains('question-input-option')) {
                    updatePreview();
                }
            });

            container.appendChild(item);
            updateCount();
            updatePreview();
            
            // Scroll to new question
            if (!existing) {
                item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                textInput.focus();
            }
        }

        function toggleOptions(type, container) {
            if (['multiple_choice', 'checkboxes', 'dropdown'].includes(type)) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        function addOptionToContainer(container, beforeElement, value = '') {
            const base = container.querySelector('.option-item');
            const clone = base.cloneNode(true);
            clone.querySelector('.question-input-option').value = value;
            container.insertBefore(clone, beforeElement);
        }

        function updateCount() {
            const count = container.children.length;
            document.getElementById('question-count-badge').textContent = count + (count === 1 ? ' pregunta' : ' preguntas');
        }

        function syncQuestionsToInputs() {
            const items = container.querySelectorAll('.question-item');
            items.forEach((item, index) => {
                const textInput = item.querySelector('.question-input-text');
                const typeSelect = item.querySelector('.question-input-type');
                const requiredInput = item.querySelector('.question-input-required');
                
                textInput.name = `questions[${index}][text]`;
                typeSelect.name = `questions[${index}][type]`;
                
                if (requiredInput.checked) {
                    requiredInput.name = `questions[${index}][required]`;
                    requiredInput.value = '1';
                } else {
                    requiredInput.removeAttribute('name');
                }

                if (['multiple_choice', 'checkboxes', 'dropdown'].includes(typeSelect.value)) {
                    const options = item.querySelectorAll('.question-input-option');
                    options.forEach((opt, optIndex) => {
                        opt.name = `questions[${index}][options][${optIndex}]`;
                    });
                }
            });
        }

        function updatePreview() {
            const title = document.getElementById('input-title').value || 'Sin título';
            const desc = document.getElementById('input-description').value || 'Sin descripción';
            
            document.getElementById('preview-title').textContent = title;
            document.getElementById('preview-description').textContent = desc;

            const previewContainer = document.getElementById('preview-questions');
            previewContainer.innerHTML = '';

            const items = container.querySelectorAll('.question-item');
            
            if (items.length === 0) {
                previewContainer.innerHTML = '<p class="text-center text-[var(--text-muted)] py-8 italic">Agrega preguntas para visualizar</p>';
                return;
            }

            items.forEach((item, idx) => {
                const text = item.querySelector('.question-input-text').value || 'Pregunta ' + (idx + 1);
                const type = item.querySelector('.question-input-type').value;
                const required = item.querySelector('.question-input-required').checked;
                const options = item.querySelectorAll('.question-input-option');

                const wrapper = document.createElement('div');
                wrapper.className = 'mb-4';
                
                const label = document.createElement('p');
                label.className = 'font-bold text-[var(--text-dark)] text-sm mb-2';
                label.textContent = (idx + 1) + '. ' + text + (required ? ' *' : '');
                wrapper.appendChild(label);

                if (['multiple_choice', 'checkboxes'].includes(type)) {
                    options.forEach(opt => {
                        const row = document.createElement('div');
                        row.className = 'flex items-center gap-2 mb-1 pl-1';
                        const icon = document.createElement('i');
                        icon.className = type === 'multiple_choice' ? 'far fa-circle text-[10px] text-gray-400' : 'far fa-square text-[10px] text-gray-400';
                        const val = document.createElement('span');
                        val.className = 'text-xs text-gray-600';
                        val.textContent = opt.value || 'Opción';
                        row.appendChild(icon);
                        row.appendChild(val);
                        wrapper.appendChild(row);
                    });
                } else if (type === 'dropdown') {
                    const select = document.createElement('div');
                    select.className = 'w-full border border-gray-200 rounded px-2 py-1 text-xs text-gray-400 flex justify-between items-center';
                    select.textContent = 'Seleccionar opción';
                    const chevron = document.createElement('i');
                    chevron.className = 'fas fa-chevron-down text-[10px]';
                    select.appendChild(chevron);
                    wrapper.appendChild(select);
                } else if (type === 'paragraph') {
                    const area = document.createElement('div');
                    area.className = 'w-full h-16 border-b border-gray-200 bg-gray-50';
                    wrapper.appendChild(area);
                } else {
                    // Short text
                    const input = document.createElement('div');
                    input.className = 'w-full h-8 border-b border-gray-200 bg-gray-50';
                    wrapper.appendChild(input);
                }

                previewContainer.appendChild(wrapper);
            });
        }
    });
</script>
@endpush
