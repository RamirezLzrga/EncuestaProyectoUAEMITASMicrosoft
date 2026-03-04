@extends('layouts.app')

@section('title', $mode === 'create' ? 'Nueva Encuesta' : 'Editar Encuesta')

@section('content')
<div class="dashboard-wrap">
<div class="dash-header">
    <div>
        <div class="dash-eyebrow">SIEI UAEMex</div>
        <h2 class="dash-title">{{ $mode === 'create' ? 'Nueva Encuesta' : 'Editar Encuesta' }}</h2>
        <p class="dash-subtitle">Editor visual para construir y ajustar tu encuesta</p>
    </div>
    <div class="flex gap-2">
        @if($mode === 'edit')
            <a href="{{ route('surveys.public', $survey->id) }}" target="_blank" class="px-4 py-2 rounded-full border border-emerald-500/40 text-emerald-300 text-xs font-semibold hover:bg-emerald-500/10 transition flex items-center gap-2">
                <i class="fas fa-eye"></i>
                Vista previa pública
            </a>
        @endif
        <a href="{{ route('surveys.index') }}" class="px-4 py-2 rounded-full border border-gray-500/40 text-gray-300 text-xs font-semibold hover:bg-white/5 transition flex items-center gap-2">
            <i class="fas fa-list"></i>
            Mis encuestas
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

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-5">
        <div class="space-y-4 xl:col-span-1">
            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4 space-y-3">
                <p class="text-[11px] uppercase tracking-widest text-gray-400 font-semibold">Tipos de pregunta</p>
                <button type="button" data-type="multiple_choice" class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-white/5 hover:bg-emerald-500/15 border border-white/10 text-xs text-gray-100 transition add-question-type">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-list-ul text-emerald-400"></i>
                        Opción múltiple
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                <button type="button" data-type="checkboxes" class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-white/5 hover:bg-emerald-500/15 border border-white/10 text-xs text-gray-100 transition add-question-type">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-check-square text-emerald-400"></i>
                        Casillas
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                <button type="button" data-type="short_text" class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-white/5 hover:bg-emerald-500/15 border border-white/10 text-xs text-gray-100 transition add-question-type">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-i-cursor text-emerald-400"></i>
                        Texto corto
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                <button type="button" data-type="paragraph" class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-white/5 hover:bg-emerald-500/15 border border-white/10 text-xs text-gray-100 transition add-question-type">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-align-left text-emerald-400"></i>
                        Texto largo
                    </span>
                    <i class="fas fa-plus text-[10px]"></i>
                </button>
                <p class="text-[11px] text-gray-500 pt-1">
                    Otros tipos como escala Likert, matriz, fecha o archivo se pueden añadir en una iteración posterior.
                </p>
            </div>

            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4 space-y-3">
                <p class="text-[11px] uppercase tracking-widest text-gray-400 font-semibold">Acciones</p>
                <a href="{{ $mode === 'edit' ? route('editor.encuestas.configuracion', $survey) : '#' }}" class="w-full inline-flex items-center justify-between px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs text-gray-100 transition {{ $mode === 'create' ? 'opacity-50 cursor-not-allowed' : '' }}">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-sliders-h text-sky-400"></i>
                        Configuración general
                    </span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-emerald-500 text-xs font-semibold text-white hover:bg-emerald-600 transition">
                    <i class="fas fa-save"></i>
                    Guardar cambios
                </button>
            </div>
        </div>

        <div class="space-y-4 xl:col-span-2">
            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-3">
                <input type="text" name="title" id="input-title" value="{{ old('title', $survey->title) }}" placeholder="Encuesta sin título" class="w-full bg-transparent border-none text-2xl font-bold text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-0" required>
                <textarea name="description" id="input-description" rows="2" placeholder="Descripción de la encuesta" class="w-full bg-transparent border-none text-sm text-gray-400 placeholder-gray-600 focus:outline-none focus:ring-0">{{ old('description', $survey->description) }}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-200 flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-gray-400"></i>
                    Preguntas
                </h2>
                <button type="button" id="btn-add-question" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-500 text-xs font-semibold text-white hover:bg-emerald-600 transition">
                    <i class="fas fa-plus"></i>
                    Agregar pregunta
                </button>
            </div>

            <div id="questions-container" class="space-y-4">
            </div>
        </div>

        <div class="space-y-4 xl:col-span-1">
            <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4">
                <p class="text-[11px] uppercase tracking-widest text-gray-400 font-semibold mb-3">Vista previa</p>
                <div id="preview-container" class="bg-slate-950/70 border border-white/5 rounded-2xl p-4 max-h-[70vh] overflow-y-auto">
                    <div class="h-1.5 w-full rounded-full bg-emerald-500 mb-4"></div>
                    <div class="space-y-4">
                        <div class="border-b border-white/10 pb-3">
                            <h2 id="preview-title" class="text-lg font-bold text-gray-100">Sin título</h2>
                            <p id="preview-description" class="text-xs text-gray-400 mt-1">Sin descripción</p>
                        </div>
                        <div id="preview-questions" class="space-y-4 text-xs text-gray-200">
                            <p class="text-center text-gray-500 py-8">
                                Comienza a agregar preguntas para ver la vista previa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>

<template id="question-template">
    <div class="question-item bg-slate-900/80 border border-white/10 rounded-2xl p-4 space-y-3">
        <div class="flex items-start gap-3">
            <div class="flex-1 space-y-2">
                <input type="text" class="question-input-text w-full bg-slate-950/60 border border-white/5 rounded-xl px-3 py-2 text-xs text-gray-100 placeholder-gray-500 focus:outline-none focus:border-emerald-500" placeholder="Escribe la pregunta">
                <select class="question-input-type w-full bg-slate-950/60 border border-white/5 rounded-xl px-3 py-2 text-xs text-gray-200 focus:outline-none focus:border-emerald-500">
                    <option value="multiple_choice">Opción múltiple</option>
                    <option value="checkboxes">Casillas de verificación</option>
                    <option value="short_text">Texto corto</option>
                    <option value="paragraph">Párrafo</option>
                    <option value="dropdown">Desplegable</option>
                    <option value="linear_scale">Escala lineal</option>
                    <option value="rating">Calificación</option>
                    <option value="date">Fecha</option>
                    <option value="time">Hora</option>
                </select>
            </div>
            <div class="flex flex-col items-end gap-2">
                <button type="button" class="text-gray-400 hover:text-emerald-400 text-xs px-2 py-1 rounded-lg border border-white/5">
                    <i class="fas fa-arrows-alt"></i>
                </button>
                <button type="button" class="btn-remove-question text-gray-400 hover:text-red-400 text-xs px-2 py-1 rounded-lg border border-white/5">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="options-container space-y-2 pl-3 border-l border-white/10 mt-2">
            <div class="option-item flex items-center gap-2">
                <i class="far fa-circle text-gray-500"></i>
                <input type="text" class="question-input-option flex-1 bg-transparent border-b border-white/5 text-xs text-gray-200 placeholder-gray-500 focus:outline-none focus:border-emerald-500" value="Opción 1">
                <button type="button" class="btn-remove-option text-gray-500 hover:text-red-400 text-[10px]">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <button type="button" class="btn-add-option text-[11px] text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                <i class="fas fa-plus"></i>
                Agregar opción
            </button>
        </div>
        <div class="flex items-center justify-between pt-2 border-t border-white/5 mt-2">
            <label class="flex items-center gap-2 text-[11px] text-gray-400">
                <input type="checkbox" class="question-input-required w-3 h-3 rounded border-gray-500 text-emerald-500 focus:ring-emerald-500">
                Obligatoria
            </label>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    let questionIndex = 0;

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-question-type').forEach(function (btn) {
            btn.addEventListener('click', function () {
                addQuestion(btn.getAttribute('data-type'));
            });
        });

        const addButton = document.getElementById('btn-add-question');
        if (addButton) {
            addButton.addEventListener('click', function () {
                addQuestion('short_text');
            });
        }

        const form = document.getElementById('builderForm');
        form.addEventListener('submit', function () {
            syncQuestionsToInputs();
        });

        form.addEventListener('input', function () {
            updatePreview();
        });

        @if($survey->questions && count($survey->questions) > 0)
            @foreach($survey->questions as $q)
                addQuestion(@json($q['type']), @json($q));
            @endforeach
        @else
            addQuestion('short_text');
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

        if (existing) {
            textInput.value = existing.text || '';
            typeSelect.value = existing.type || type;
            requiredInput.checked = !!existing.required;

            const optionsContainer = item.querySelector('.options-container');
            const baseOption = optionsContainer.querySelector('.option-item');
            optionsContainer.querySelectorAll('.option-item').forEach(function (opt, index) {
                if (index > 0) opt.remove();
            });
            if (existing.options && existing.options.length) {
                existing.options.forEach(function (opt, idx) {
                    let optionNode = baseOption;
                    if (idx > 0) {
                        optionNode = baseOption.cloneNode(true);
                        optionsContainer.insertBefore(optionNode, optionsContainer.querySelector('.btn-add-option'));
                    }
                    optionNode.querySelector('.question-input-option').value = opt;
                });
            }
        } else {
            typeSelect.value = type;
        }

        setupTypeBehavior(item, typeSelect);

        item.querySelector('.btn-remove-question').addEventListener('click', function () {
            if (document.querySelectorAll('.question-item').length > 1) {
                item.remove();
                updatePreview();
            }
        });

        const addOptionBtn = item.querySelector('.btn-add-option');
        addOptionBtn.addEventListener('click', function () {
            const optionsContainer = item.querySelector('.options-container');
            const base = optionsContainer.querySelector('.option-item');
            const clone = base.cloneNode(true);
            clone.querySelector('.question-input-option').value = '';
            clone.querySelector('.btn-remove-option').addEventListener('click', function () {
                clone.remove();
                updatePreview();
            });
            optionsContainer.insertBefore(clone, addOptionBtn);
        });

        item.querySelectorAll('.btn-remove-option').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const options = item.querySelectorAll('.option-item');
                if (options.length > 1) {
                    btn.closest('.option-item').remove();
                    updatePreview();
                }
            });
        });

        container.appendChild(item);
        questionIndex++;
        updatePreview();
    }

    function syncQuestionsToInputs() {
        const container = document.getElementById('questions-container');
        const items = container.querySelectorAll('.question-item');

        container.querySelectorAll('input[name^="questions["], select[name^="questions["]').forEach(function (el) {
            el.removeAttribute('name');
        });

        let index = 0;
        items.forEach(function (item) {
            const textInput = item.querySelector('.question-input-text');
            const typeSelect = item.querySelector('.question-input-type');
            const requiredInput = item.querySelector('.question-input-required');
            const options = item.querySelectorAll('.question-input-option');

            textInput.setAttribute('name', 'questions[' + index + '][text]');
            typeSelect.setAttribute('name', 'questions[' + index + '][type]');
            requiredInput.setAttribute('name', 'questions[' + index + '][required]');

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
            const p = document.createElement('p');
            p.className = 'text-center text-gray-500 py-8';
            p.textContent = 'Comienza a agregar preguntas para ver la vista previa.';
            previewQuestions.appendChild(p);
            return;
        }

        let number = 1;
        items.forEach(function (item) {
            const text = item.querySelector('.question-input-text').value || 'Pregunta sin texto';
            const type = item.querySelector('.question-input-type').value;
            const required = item.querySelector('.question-input-required').checked;

            const block = document.createElement('div');
            block.className = 'space-y-1';

            const label = document.createElement('p');
            label.className = 'font-semibold text-gray-100';
            label.textContent = number + '. ' + text + (required ? ' *' : '');
            block.appendChild(label);

            const control = document.createElement('div');
            control.className = 'mt-1';

            if (type === 'multiple_choice' || type === 'checkboxes') {
                const options = item.querySelectorAll('.question-input-option');
                options.forEach(function (opt) {
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-2 text-[11px] text-gray-300';
                    const icon = document.createElement('span');
                    icon.className = type === 'checkboxes'
                        ? 'w-3 h-3 border border-gray-500 rounded-sm'
                        : 'w-3 h-3 rounded-full border border-gray-500';
                    row.appendChild(icon);
                    const span = document.createElement('span');
                    span.textContent = opt.value || 'Opción';
                    row.appendChild(span);
                    control.appendChild(row);
                });
            } else if (type === 'short_text') {
                const input = document.createElement('div');
                input.className = 'h-7 rounded-lg border border-gray-600 bg-slate-900/80';
                control.appendChild(input);
            } else if (type === 'paragraph') {
                const textarea = document.createElement('div');
                textarea.className = 'h-16 rounded-lg border border-gray-600 bg-slate-900/80';
                control.appendChild(textarea);
            } else if (type === 'dropdown') {
                const selectMock = document.createElement('div');
                selectMock.className = 'h-7 rounded-lg border border-gray-600 bg-slate-900/80 px-3 flex items-center justify-between text-[11px] text-gray-400';
                selectMock.textContent = 'Selecciona una opción';
                const chevron = document.createElement('span');
                chevron.className = 'ml-2 text-[9px]';
                chevron.textContent = '▾';
                selectMock.appendChild(chevron);
                control.appendChild(selectMock);
            } else if (type === 'linear_scale') {
                const scaleRow = document.createElement('div');
                scaleRow.className = 'flex items-center gap-3';
                for (let i = 1; i <= 5; i++) {
                    const col = document.createElement('div');
                    col.className = 'flex flex-col items-center gap-1 text-[11px] text-gray-300';
                    const circle = document.createElement('div');
                    circle.className = 'w-3 h-3 rounded-full border border-gray-500';
                    const labelNum = document.createElement('span');
                    labelNum.textContent = i;
                    col.appendChild(circle);
                    col.appendChild(labelNum);
                    scaleRow.appendChild(col);
                }
                control.appendChild(scaleRow);
            } else if (type === 'rating') {
                const starsRow = document.createElement('div');
                starsRow.className = 'flex items-center gap-1';
                for (let i = 0; i < 5; i++) {
                    const star = document.createElement('span');
                    star.className = 'text-yellow-400 text-lg';
                    star.textContent = '★';
                    starsRow.appendChild(star);
                }
                control.appendChild(starsRow);
            } else if (type === 'date') {
                const dateMock = document.createElement('div');
                dateMock.className = 'h-7 rounded-lg border border-gray-600 bg-slate-900/80 px-3 flex items-center text-[11px] text-gray-400';
                dateMock.textContent = 'dd/mm/aaaa';
                control.appendChild(dateMock);
            } else if (type === 'time') {
                const timeMock = document.createElement('div');
                timeMock.className = 'h-7 rounded-lg border border-gray-600 bg-slate-900/80 px-3 flex items-center text-[11px] text-gray-400';
                timeMock.textContent = 'hh:mm';
                control.appendChild(timeMock);
            } else {
                const generic = document.createElement('div');
                generic.className = 'h-7 rounded-lg border border-gray-600 bg-slate-900/80';
                control.appendChild(generic);
            }

            block.appendChild(control);
            previewQuestions.appendChild(block);
            number++;
        });
    }

    function setupTypeBehavior(item, select) {
        const optionsContainer = item.querySelector('.options-container');

        function apply() {
            const simpleTypes = ['short_text', 'paragraph', 'linear_scale', 'rating', 'date', 'time'];
            if (simpleTypes.indexOf(select.value) !== -1) {
                if (optionsContainer) {
                    optionsContainer.style.display = 'none';
                }
            } else {
                if (optionsContainer) {
                    optionsContainer.style.display = 'block';
                    const icon = optionsContainer.querySelector('.option-item i');
                    if (icon) {
                        icon.className = select.value === 'checkboxes'
                            ? 'far fa-square text-gray-500'
                            : 'far fa-circle text-gray-500';
                    }
                }
            }
        }

        select.addEventListener('change', function () {
            apply();
            updatePreview();
        });

        apply();
    }
</script>
@endpush
