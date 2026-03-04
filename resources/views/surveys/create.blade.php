@extends('layouts.admin')

@section('title', 'Crear Nueva Encuesta')

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <div>
            <h1 class="page-title">Crear Nueva Encuesta</h1>
            <p class="page-subtitle">Diseña tu formulario al estilo Google Forms</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('surveys.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancelar
            </a>
        </div>
    </div>
</div>

<div id="builder-root" class="mt-2 rounded-[32px] bg-white py-10">
        <form action="{{ route('surveys.store') }}" method="POST" id="surveyForm" class="max-w-3xl mx-auto relative space-y-4">
            @csrf
            <input type="hidden" name="header_image" id="header-image-input">
            <input type="hidden" name="year" value="{{ date('Y') }}">
            <div class="px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-2">
                <div class="flex flex-wrap gap-4 items-center text-xs text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="far fa-calendar text-[#006838]"></i>
                        <div class="flex items-center gap-2">
                            <span>Inicio:</span>
                            <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="border border-gray-300 rounded px-2 py-1 text-xs focus:outline-none focus:border-[#006838]">
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Cierre automático:</span>
                        <input type="date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 month')) }}" class="border border-gray-300 rounded px-2 py-1 text-xs focus:outline-none focus:border-[#006838]">
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Límite de respuestas:</span>
                        <input type="number" name="settings[max_responses]" min="1" class="w-20 border border-gray-300 rounded px-2 py-1 text-xs focus:outline-none focus:border-[#006838]" placeholder="100">
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 items-center text-xs text-gray-600">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="settings[allow_multiple]" value="1" class="w-4 h-4 text-[#006838] rounded focus:ring-[#006838]">
                        <span>Permitir múltiples respuestas</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="settings[one_response_per_ip]" value="1" class="w-4 h-4 text-[#006838] rounded focus:ring-[#006838]">
                        <span>Una respuesta por usuario</span>
                    </label>
                </div>
            </div>

            <div id="question-toolbar" class="absolute -right-16 hidden lg:flex flex-col gap-3">
                <button type="button" onclick="addQuestion()" class="btn-add-question w-10 h-10 rounded-full bg-[#006838] text-white shadow-lg flex items-center justify-center hover:bg-[#004d28] transition" title="Añadir pregunta">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" onclick="focusSurveyTitle()" class="w-10 h-10 rounded-full bg-white text-gray-700 border border-gray-200 shadow flex items-center justify-center hover:bg-gray-50 transition text-xs font-bold" title="Editar título">
                    Tt
                </button>
                <button type="button" onclick="addImageToActiveQuestion()" class="w-10 h-10 rounded-full bg-white text-gray-700 border border-gray-200 shadow flex items-center justify-center hover:bg-gray-50 transition" title="Añadir imagen">
                    <i class="far fa-image"></i>
                </button>
                <button type="button" onclick="addVideoToActiveQuestion()" class="w-10 h-10 rounded-full bg-white text-gray-700 border border-gray-200 shadow flex items-center justify-center hover:bg-gray-50 transition" title="Añadir video">
                    <i class="fab fa-youtube"></i>
                </button>
                <button type="button" onclick="addSection()" class="w-10 h-10 rounded-full bg-white text-gray-700 border border-gray-200 shadow flex items-center justify-center hover:bg-gray-50 transition" title="Añadir sección">
                    <i class="fas fa-indent"></i>
                </button>
            </div>

            <div id="header-image-container" class="max-w-3xl mx-auto -mt-4 mb-4 hidden">
                <img id="header-image-preview" src="" alt="Imagen de encabezado" class="w-full h-48 object-cover rounded-t-2xl">
            </div>

            <div data-header-card class="bg-white rounded-2xl shadow-md border border-gray-100 border-t-8" style="border-top-color: #006838;">
                <div class="border-b border-gray-200 px-8 pt-6 pb-4">
                    <input type="text" name="title" id="input-title" placeholder="Formulario sin título" class="w-full text-3xl font-normal border-b border-transparent focus:border-[#006838] focus:outline-none pb-2 placeholder-gray-500" required>
                    <textarea name="description" id="input-description" placeholder="Descripción del formulario" class="w-full mt-2 text-sm text-gray-700 border-b border-transparent focus:border-gray-300 focus:outline-none pb-2 resize-none placeholder-gray-500"></textarea>
                </div>
            </div>

            <div id="questions-container" class="space-y-4"></div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn-save-form bg-[#006838] text-white px-6 py-2 rounded-md text-sm font-semibold shadow hover:bg-[#004d28] transition">
                    Guardar encuesta
                </button>
                <a href="{{ route('surveys.index') }}" class="text-sm text-gray-700 font-semibold hover:underline">
                    Cancelar
                </a>
            </div>
        </form>

        <button type="button" onclick="toggleThemePanel()" class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full bg-white text-gray-700 border border-gray-200 shadow-xl flex items-center justify-center hover:bg-gray-50">
            <i class="fas fa-palette"></i>
        </button>

        <div id="theme-panel" class="hidden fixed top-0 right-0 h-full w-72 bg-white shadow-2xl border-l border-gray-200 z-50 flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-semibold">Tema</p>
                    <p class="text-sm font-bold text-gray-800">Formulario</p>
                </div>
                <button type="button" onclick="toggleThemePanel()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4 space-y-6">
                <div class="space-y-3">
                    <p class="text-xs font-semibold text-gray-500">Estilo del texto</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-gray-500">Encabezado</span>
                            <div class="flex items-center gap-1">
                                <select id="theme-header-font" class="border border-gray-200 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-[#006838]">
                                    <option value="'DM Sans', sans-serif">DM Sans</option>
                                    <option value="'Playfair Display', serif">Playfair</option>
                                    <option value="'DM Mono', monospace">Mono</option>
                                </select>
                                <select id="theme-header-size" class="border border-gray-200 rounded-lg px-1.5 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-[#006838]">
                                    <option value="24">24</option>
                                    <option value="28">28</option>
                                    <option value="32" selected>32</option>
                                    <option value="36">36</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-gray-500">Pregunta</span>
                            <div class="flex items-center gap-1">
                                <select id="theme-question-font" class="border border-gray-200 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-[#006838]">
                                    <option value="'DM Sans', sans-serif">DM Sans</option>
                                    <option value="'Playfair Display', serif">Playfair</option>
                                    <option value="'DM Mono', monospace">Mono</option>
                                </select>
                                <select id="theme-question-size" class="border border-gray-200 rounded-lg px-1.5 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-[#006838]">
                                    <option value="12">12</option>
                                    <option value="14" selected>14</option>
                                    <option value="16">16</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-gray-500">Texto</span>
                            <div class="flex items-center gap-1">
                                <select id="theme-text-font" class="border border-gray-200 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-[#006838]">
                                    <option value="'DM Sans', sans-serif">DM Sans</option>
                                    <option value="'Playfair Display', serif">Playfair</option>
                                    <option value="'DM Mono', monospace">Mono</option>
                                </select>
                                <select id="theme-text-size" class="border border-gray-200 rounded-lg px-1.5 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-[#006838]">
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="14" selected>14</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-xs font-semibold text-gray-500">Encabezado</p>
                    <button type="button" onclick="openImageDialog('header')" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-600 flex items-center justify-center gap-2 hover:bg-gray-50">
                        <i class="far fa-image text-gray-400"></i>
                        Elegir imagen
                    </button>
                </div>

                <div class="space-y-3">
                    <p class="text-xs font-semibold text-gray-500">Color</p>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="w-7 h-7 rounded-full border-2 border-black/60 bg-[#006838]" data-theme-primary="#006838"></button>
                        <button type="button" class="w-7 h-7 rounded-full border-2 border-transparent bg-[#C9A961]" data-theme-primary="#C9A961"></button>
                        <button type="button" class="w-7 h-7 rounded-full border-2 border-transparent bg-[#22c55e]" data-theme-primary="#22c55e"></button>
                        <button type="button" class="w-7 h-7 rounded-full border-2 border-transparent bg-[#0f172a]" data-theme-primary="#0f172a"></button>
                        <button type="button" class="w-7 h-7 rounded-full border-2 border-transparent bg-[#9e9e9e]" data-theme-primary="#9e9e9e"></button>
                    </div>

                    <p class="text-xs font-semibold text-gray-500 mt-3">Fondo</p>
                    <div class="flex gap-2">
                        <button type="button" class="w-6 h-6 rounded-full border border-gray-300 bg-white" data-theme-bg="#ffffff"></button>
                        <button type="button" class="w-6 h-6 rounded-full border border-gray-300 bg-[#f0fdf4]" data-theme-bg="#f0fdf4"></button>
                        <button type="button" class="w-6 h-6 rounded-full border border-gray-300 bg-[#fefce8]" data-theme-bg="#fefce8"></button>
                        <button type="button" class="w-6 h-6 rounded-full border border-gray-300 bg-[#ecfeff]" data-theme-bg="#ecfeff"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="image-dialog" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-sm font-semibold text-gray-800">Insertar imagen</h2>
            <button type="button" onclick="closeImageDialog()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="border-b border-gray-200 px-6 pt-3">
            <div class="flex gap-6 text-xs font-semibold text-gray-500">
                <span class="text-[#006838] border-b-2 border-[#006838] pb-2">Subir</span>
                <span class="pb-2 text-gray-400">Cámara web</span>
                <span class="pb-2 text-gray-400">Por URL</span>
                <span class="pb-2 text-gray-400">Fotos</span>
                <span class="pb-2 text-gray-400">Google Drive</span>
                <span class="pb-2 text-gray-400">Google Imágenes</span>
            </div>
        </div>
        <div class="px-6 py-8">
            <div class="border-2 border-dashed border-gray-300 rounded-xl py-10 flex flex-col items-center justify-center gap-3 bg-gray-50">
                <div class="w-20 h-12 bg-gray-200 rounded-md"></div>
                <p class="text-xs text-gray-500">Esta versión permite insertar imágenes usando una URL pública.</p>
                <input id="image-dialog-url" type="text" class="mt-2 w-full max-w-md border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006838]" placeholder="Pega aquí la URL de la imagen">
            </div>
        </div>
        <div class="px-6 py-3 border-t border-gray-200 flex justify-end gap-2">
            <button type="button" onclick="closeImageDialog()" class="px-4 py-2 text-xs font-semibold text-gray-700 rounded-lg hover:bg-gray-100">
                Cancelar
            </button>
            <button type="button" onclick="confirmImageDialog()" class="px-4 py-2 text-xs font-semibold text-white bg-[#006838] rounded-lg hover:bg-[#004d28]">
                Insertar
            </button>
        </div>
    </div>
</div>

<template id="question-template">
    <div class="question-item bg-white rounded-2xl shadow-md border border-gray-200 hover:shadow-lg transition relative overflow-hidden">
        <div class="accent-bar absolute left-0 top-0 h-full w-1 bg-[#006838]"></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3 px-6 pt-6">
            <div class="md:col-span-2">
                <input type="text" name="questions[INDEX][text]" placeholder="Escribe tu pregunta" class="question-input-text w-full border-b border-gray-300 focus:border-[#006838] focus:outline-none pb-2 text-gray-800" required>
            </div>
            <div>
                <select name="questions[INDEX][type]" onchange="toggleOptions(this)" class="question-input-type w-full bg-white border border-gray-300 rounded px-3 py-2 text-gray-700 text-sm focus:outline-none focus:border-[#006838] cursor-pointer">
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
        </div>

        <div class="question-control-preview px-6 pb-3 text-sm text-gray-600"></div>

        <div class="options-container space-y-2 px-6 pb-4">
            <div class="option-item flex items-center gap-3">
                <i class="far fa-circle text-gray-500"></i>
                <input type="text" name="questions[INDEX][options][]" value="Opción 1" class="question-input-option flex-1 border-b border-dotted border-gray-400 focus:border-[#006838] focus:outline-none text-sm text-gray-700" placeholder="Opción">
                <button type="button" onclick="removeOption(this)" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fas fa-close text-xs"></i>
                </button>
            </div>
            <button type="button" onclick="addOption(this, 'INDEX')" class="text-[#006838] text-sm font-semibold hover:underline flex items-center gap-2 mt-1">
                <i class="fas fa-plus"></i> Agregar opción
            </button>
        </div>

        <div class="flex justify-between items-center border-t border-gray-100 px-6 py-3 text-sm text-gray-600">
            <label class="flex items-center gap-2 cursor-pointer">
                <span>Obligatoria</span>
                <input type="checkbox" name="questions[INDEX][required]" class="question-input-required w-4 h-4 text-[#006838] rounded focus:ring-[#006838]">
            </label>
            <div class="flex items-center gap-2 text-gray-500">
                <button type="button" onclick="duplicateQuestion(this)" class="p-1 rounded-full hover:bg-gray-100" title="Duplicar">
                    <i class="far fa-copy"></i>
                </button>
                <button type="button" onclick="removeQuestion(this)" class="p-1 rounded-full hover:bg-gray-100" title="Eliminar">
                    <i class="far fa-trash-alt"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<template id="section-template">
    <div class="question-item bg-[#f0fdf4] rounded-2xl shadow-md border border-gray-200 hover:shadow-lg transition relative overflow-hidden" data-section="true">
        <div class="px-6 pt-4 pb-3 bg-[#f0fdf4] border-b border-gray-200">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-[#166534] bg-white section-label">
                Sección
            </span>
        </div>
        <div class="px-6 pt-4 pb-4 bg-white">
            <input type="hidden" name="questions[INDEX][type]" value="section">
            <input type="text" name="questions[INDEX][text]" placeholder="Sección sin título" class="question-input-text w-full border-b border-gray-300 focus:border-[#006838] focus:outline-none pb-2 text-gray-800 mb-2" required>
            <textarea name="questions[INDEX][description]" placeholder="Descripción (opcional)" class="question-input-description w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-[#006838] resize-none"></textarea>
        </div>
        <div class="flex justify-end items-center border-t border-gray-100 px-6 py-3 text-sm text-gray-500 bg-white">
            <span>Después de esta sección: Ir a la siguiente sección</span>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    let questionCount = 0;
    let themePrimaryColor = '#006838';
    let themeBackgroundColor = '#ffffff';
    let activeQuestion = null;
    let imageDialogContext = null;

    document.addEventListener('DOMContentLoaded', () => {
        addQuestion();
        initThemePanel();
        window.addEventListener('resize', positionQuestionToolbar);
        updateSectionLabels();
    });

    function addQuestion() {
        const container = document.getElementById('questions-container');
        const template = document.getElementById('question-template');
        const clone = template.content.cloneNode(true);
        const html = clone.firstElementChild.outerHTML.replace(/INDEX/g, questionCount);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        const newQuestion = tempDiv.firstElementChild;
        container.appendChild(newQuestion);
        questionCount++;
        attachQuestionEvents(newQuestion);
        applyThemeTypography();
        applyThemeColors();
        setActiveQuestion(newQuestion);
    }

    function removeQuestion(btn) {
        if (document.querySelectorAll('.question-item').length > 1) {
            const questionItem = btn.closest('.question-item');
            questionItem.remove();
            updateSectionLabels();
        } else {
            alert("La encuesta debe tener al menos una pregunta.");
        }
    }

    function duplicateQuestion(btn) {
        const original = btn.closest('.question-item');
        const clone = original.cloneNode(true);
        const inputs = clone.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.startsWith('questions[')) {
                input.setAttribute('name', name.replace(/\[\d+\]/, '[' + questionCount + ']'));
            }
            if (input.type === 'text') {
                if (name && name.includes('[options]')) {
                    input.value = '';
                }
            }
        });
        document.getElementById('questions-container').appendChild(clone);
        questionCount++;
        attachQuestionEvents(clone);
        applyThemeTypography();
        applyThemeColors();
        setActiveQuestion(clone);
    }

    function attachQuestionEvents(questionEl) {
        questionEl.addEventListener('click', () => {
            setActiveQuestion(questionEl);
        });

        const typeSelect = questionEl.querySelector('.question-input-type');
        if (typeSelect) {
            typeSelect.addEventListener('change', () => {
                renderQuestionPreview(questionEl);
            });
        }

        const inputs = questionEl.querySelectorAll('.question-input-text, .question-input-option');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                renderQuestionPreview(questionEl);
            });
        });

        renderQuestionPreview(questionEl);
    }

    function setActiveQuestion(questionEl) {
        activeQuestion = questionEl;
        const toolbar = document.getElementById('question-toolbar');
        if (toolbar) {
            toolbar.classList.remove('hidden');
        }
        positionQuestionToolbar();
    }

    function positionQuestionToolbar() {
        const toolbar = document.getElementById('question-toolbar');
        const form = document.getElementById('surveyForm');
        if (!toolbar || !form || !activeQuestion) {
            return;
        }
        const formRect = form.getBoundingClientRect();
        const questionRect = activeQuestion.getBoundingClientRect();
        const offset = questionRect.top - formRect.top + questionRect.height / 2 - toolbar.offsetHeight / 2;
        toolbar.style.top = offset + 'px';
    }

    function getQuestionRealIndex(questionEl) {
        const nameInput = questionEl.querySelector('input[name^="questions"][name$="[text]"]');
        if (!nameInput) {
            return null;
        }
        const match = nameInput.name.match(/\[(\d+)\]/);
        return match ? match[1] : null;
    }

    function addImageToActiveQuestion() {
        if (!activeQuestion) {
            alert("Selecciona una pregunta primero.");
            return;
        }
        imageDialogContext = 'question';
        const dialog = document.getElementById('image-dialog');
        const urlInput = document.getElementById('image-dialog-url');
        if (!dialog || !urlInput) {
            return;
        }
        const realIndex = getQuestionRealIndex(activeQuestion);
        if (realIndex !== null) {
            const existingBlock = activeQuestion.querySelector('.question-media-image');
            const existingInput = existingBlock ? existingBlock.querySelector('input') : null;
            urlInput.value = existingInput ? existingInput.value : '';
        } else {
            urlInput.value = '';
        }
        dialog.classList.remove('hidden');
    }

    function addVideoToActiveQuestion() {
        if (!activeQuestion) {
            alert("Selecciona una pregunta primero.");
            return;
        }
        const realIndex = getQuestionRealIndex(activeQuestion);
        if (realIndex === null) {
            return;
        }
        let block = activeQuestion.querySelector('.question-media-video');
        if (!block) {
            block = document.createElement('div');
            block.className = 'question-media-video flex items-center gap-3 px-6 pb-3';
            block.innerHTML = `
                <i class="fab fa-youtube text-red-500"></i>
                <div class="flex-1">
                    <input type="text" name="questions[${realIndex}][video_url]" class="question-input-video w-full border-b border-gray-300 focus:border-[#006838] focus:outline-none text-sm text-gray-700" placeholder="URL del video (YouTube)">
                </div>
            `;
            const reference = activeQuestion.querySelector('.question-media-image') || activeQuestion.querySelector('.grid');
            if (reference) {
                reference.insertAdjacentElement('afterend', block);
            } else {
                activeQuestion.appendChild(block);
            }
        } else {
            const input = block.querySelector('input');
            input.name = `questions[${realIndex}][video_url]`;
        }
        const input = block.querySelector('input');
        const url = prompt("Pega la URL del video", input.value || "");
        if (url !== null && url.trim() !== "") {
            input.value = url.trim();
        }
    }

    function addSection() {
        const container = document.getElementById('questions-container');
        const template = document.getElementById('section-template');
        if (!container || !template) {
            return;
        }
        const clone = template.content.cloneNode(true);
        const html = clone.firstElementChild.outerHTML.replace(/INDEX/g, questionCount);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        const newSection = tempDiv.firstElementChild;
        if (activeQuestion && activeQuestion.parentElement === container) {
            activeQuestion.insertAdjacentElement('afterend', newSection);
        } else {
            container.appendChild(newSection);
        }
        questionCount++;
        attachQuestionEvents(newSection);
        applyThemeTypography();
        applyThemeColors();
        setActiveQuestion(newSection);
        updateSectionLabels();
    }

    function toggleOptions(select) {
        const questionItem = select.closest('.question-item');
        const optionsContainer = questionItem.querySelector('.options-container');
        const simpleTypes = ['short_text', 'paragraph', 'linear_scale', 'rating', 'date', 'time'];
        if (simpleTypes.includes(select.value)) {
            optionsContainer.style.display = 'none';
        } else {
            optionsContainer.style.display = 'block';
            const icons = optionsContainer.querySelectorAll('i.far');
            icons.forEach(icon => {
                icon.className = select.value === 'checkboxes' ? 'far fa-square text-gray-400' : 'far fa-circle text-gray-400';
            });
        }
    }

    function renderQuestionPreview(questionItem) {
        const preview = questionItem.querySelector('.question-control-preview');
        if (!preview) {
            return;
        }

        const typeSelect = questionItem.querySelector('.question-input-type');
        const type = typeSelect ? typeSelect.value : 'short_text';

        const simpleTypes = ['short_text', 'paragraph', 'linear_scale', 'rating', 'date', 'time'];
        if (!simpleTypes.includes(type)) {
            preview.innerHTML = '';
            return;
        }

        let html = '';

        if (type === 'short_text') {
            html = `
                <div class="border-b border-gray-300 py-2 text-gray-400 text-sm">
                    Escribe tu respuesta
                </div>
            `;
        } else if (type === 'paragraph') {
            html = `
                <div class="border border-gray-300 rounded-lg px-3 py-2 text-gray-400 text-sm">
                    Escribe una respuesta larga
                </div>
            `;
        } else if (type === 'linear_scale') {
            let scaleHtml = '<div class="flex items-center gap-4">';
            for (let i = 1; i <= 5; i++) {
                scaleHtml += `
                    <div class="flex flex-col items-center gap-1 text-xs text-gray-500">
                        <span class="w-3 h-3 rounded-full border border-gray-400"></span>
                        <span>${i}</span>
                    </div>
                `;
            }
            scaleHtml += '</div>';
            html = scaleHtml;
        } else if (type === 'rating') {
            html = `
                <div class="flex items-center gap-1 text-yellow-400">
                    <span class="text-lg">★</span>
                    <span class="text-lg">★</span>
                    <span class="text-lg">★</span>
                    <span class="text-lg">★</span>
                    <span class="text-lg">★</span>
                </div>
            `;
        } else if (type === 'date') {
            html = `
                <div class="inline-flex items-center border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-500 bg-white">
                    dd/mm/aaaa
                </div>
            `;
        } else if (type === 'time') {
            html = `
                <div class="inline-flex items-center border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-500 bg-white">
                    hh:mm
                </div>
            `;
        }

        preview.innerHTML = html;
    }

    function addOption(btn, indexPlaceholder) {
        const optionsContainer = btn.closest('.options-container');
        const questionItem = btn.closest('.question-item');
        const nameAttr = questionItem.querySelector('input[name^="questions"]').name;
        const realIndex = nameAttr.match(/\[(\d+)\]/)[1];
        const newOption = document.createElement('div');
        newOption.className = 'option-item flex items-center gap-3';
        const typeSelect = questionItem.querySelector('select');
        const iconClass = typeSelect.value === 'checkboxes' ? 'far fa-square' : 'far fa-circle';

        newOption.innerHTML = `
            <i class="${iconClass} text-gray-500"></i>
            <input type="text" name="questions[${realIndex}][options][]" class="question-input-option flex-1 border-b border-dotted border-gray-400 focus:border-[#006838] focus:outline-none text-sm text-gray-700" placeholder="Opción">
            <button type="button" onclick="removeOption(this)" class="text-gray-400 hover:text-red-500 transition">
                <i class="fas fa-close text-xs"></i>
            </button>
        `;
        optionsContainer.insertBefore(newOption, btn);
    }

    function removeOption(btn) {
        const container = btn.closest('.options-container');
        if (container.querySelectorAll('.option-item').length > 1) {
            btn.closest('.option-item').remove();
        }
    }

    function updateSectionLabels() {
        const sections = document.querySelectorAll('.question-item[data-section="true"]');
        const total = sections.length;
        sections.forEach((section, index) => {
            const label = section.querySelector('.section-label');
            if (label) {
                label.textContent = `Sección ${index + 1} de ${total}`;
            }
        });
    }

    function openImageDialog(context) {
        imageDialogContext = context;
        const dialog = document.getElementById('image-dialog');
        const urlInput = document.getElementById('image-dialog-url');
        if (!dialog || !urlInput) {
            return;
        }
        urlInput.value = '';
        dialog.classList.remove('hidden');
    }

    function closeImageDialog() {
        const dialog = document.getElementById('image-dialog');
        if (dialog) {
            dialog.classList.add('hidden');
        }
        imageDialogContext = null;
    }

    function confirmImageDialog() {
        const urlInput = document.getElementById('image-dialog-url');
        if (!urlInput || !urlInput.value.trim()) {
            alert('Escribe la URL de la imagen.');
            return;
        }
        const url = urlInput.value.trim();
        if (imageDialogContext === 'header') {
            const hiddenInput = document.getElementById('header-image-input');
            const headerContainer = document.getElementById('header-image-container');
            const headerPreview = document.getElementById('header-image-preview');
            if (hiddenInput && headerContainer && headerPreview) {
                hiddenInput.value = url;
                headerPreview.src = url;
                headerContainer.classList.remove('hidden');
            }
        } else if (imageDialogContext === 'question') {
            if (!activeQuestion) {
                alert('Selecciona una pregunta primero.');
                return;
            }
            const realIndex = getQuestionRealIndex(activeQuestion);
            if (realIndex === null) {
                return;
            }
            let block = activeQuestion.querySelector('.question-media-image');
            if (!block) {
                block = document.createElement('div');
                block.className = 'question-media-image flex items-center gap-3 px-6 pb-3';
                block.innerHTML = `
                    <i class="far fa-image text-gray-400"></i>
                    <div class="flex-1">
                        <input type="text" name="questions[${realIndex}][image_url]" class="question-input-image w-full border-b border-gray-300 focus:border-[#006838] focus:outline-none text-sm text-gray-700" placeholder="URL de la imagen">
                    </div>
                `;
                const gridRow = activeQuestion.querySelector('.grid');
                if (gridRow) {
                    gridRow.insertAdjacentElement('afterend', block);
                } else {
                    activeQuestion.appendChild(block);
                }
            } else {
                const inputExisting = block.querySelector('input');
                inputExisting.name = `questions[${realIndex}][image_url]`;
            }
            const input = block.querySelector('input');
            input.value = url;
        }
        closeImageDialog();
    }

    function toggleThemePanel() {
        const panel = document.getElementById('theme-panel');
        if (panel) {
            panel.classList.toggle('hidden');
        }
    }

    function initThemePanel() {
        const headerFontSelect = document.getElementById('theme-header-font');
        const questionFontSelect = document.getElementById('theme-question-font');
        const textFontSelect = document.getElementById('theme-text-font');
        const headerSizeSelect = document.getElementById('theme-header-size');
        const questionSizeSelect = document.getElementById('theme-question-size');
        const textSizeSelect = document.getElementById('theme-text-size');

        [headerFontSelect, questionFontSelect, textFontSelect, headerSizeSelect, questionSizeSelect, textSizeSelect].forEach(el => {
            if (el) {
                el.addEventListener('change', applyThemeTypography);
            }
        });

        document.querySelectorAll('[data-theme-primary]').forEach(btn => {
            btn.addEventListener('click', () => {
                themePrimaryColor = btn.getAttribute('data-theme-primary');
                applyThemeColors();
            });
        });

        document.querySelectorAll('[data-theme-bg]').forEach(btn => {
            btn.addEventListener('click', () => {
                themeBackgroundColor = btn.getAttribute('data-theme-bg');
                applyThemeBackground();
            });
        });

        applyThemeTypography();
        applyThemeColors();
        applyThemeBackground();
    }

    function applyThemeColors() {
        const headerCard = document.querySelector('[data-header-card]');
        if (headerCard) {
            headerCard.style.borderTopColor = themePrimaryColor;
        }
        const addButton = document.querySelector('.btn-add-question');
        if (addButton) {
            addButton.style.backgroundColor = themePrimaryColor;
        }
        const saveButton = document.querySelector('.btn-save-form');
        if (saveButton) {
            saveButton.style.backgroundColor = themePrimaryColor;
        }
        document.querySelectorAll('.accent-bar').forEach(bar => {
            bar.style.backgroundColor = themePrimaryColor;
        });
        document.querySelectorAll('[data-theme-primary]').forEach(btn => {
            const value = btn.getAttribute('data-theme-primary');
            btn.style.borderColor = value === themePrimaryColor ? 'rgba(0,0,0,0.6)' : 'transparent';
        });
    }

    function applyThemeBackground() {
        const root = document.getElementById('builder-root');
        if (root) {
            root.style.backgroundColor = themeBackgroundColor;
        }
    }

    function applyThemeTypography() {
        const headerFont = document.getElementById('theme-header-font')?.value || '';
        const questionFont = document.getElementById('theme-question-font')?.value || '';
        const textFont = document.getElementById('theme-text-font')?.value || '';
        const headerSize = document.getElementById('theme-header-size')?.value || '32';
        const questionSize = document.getElementById('theme-question-size')?.value || '14';
        const textSize = document.getElementById('theme-text-size')?.value || '14';

        const title = document.getElementById('input-title');
        const desc = document.getElementById('input-description');
        if (title) {
            title.style.fontFamily = headerFont;
            title.style.fontSize = headerSize + 'px';
        }
        if (desc) {
            desc.style.fontFamily = textFont;
            desc.style.fontSize = textSize + 'px';
        }
        document.querySelectorAll('.question-input-text').forEach(el => {
            el.style.fontFamily = questionFont;
            el.style.fontSize = questionSize + 'px';
        });
        document.querySelectorAll('.question-item .question-input-option').forEach(el => {
            el.style.fontFamily = textFont;
            el.style.fontSize = textSize + 'px';
        });
    }

    function focusSurveyTitle() {
        const titleInput = document.getElementById('input-title');
        if (titleInput) {
            titleInput.focus();
        }
    }
</script>
@endpush
