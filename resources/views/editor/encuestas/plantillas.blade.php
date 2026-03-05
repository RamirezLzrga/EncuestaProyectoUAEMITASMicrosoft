@extends('layouts.editor')

@section('content')
<div class="ph">
    <div>
        <div class="ph-label">SIEI UAEMex</div>
        <h1 class="ph-title">Crear a partir de plantillas</h1>
        <div class="ph-sub">Elige un escenario y comienza con una plantilla preconfigurada</div>
    </div>
    <div class="ph-actions">
        <a href="{{ route('editor.dashboard') }}" class="btn btn-neu btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Volver al panel
        </a>
    </div>
</div>

<div class="nc mb-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-[var(--text-dark)] mb-1">Tipo de formulario</h3>
            <p class="text-xs text-[var(--text-muted)]">Selecciona el tipo de experiencia que quieres crear</p>
        </div>
        <div class="flex flex-wrap gap-2" id="template-category-tabs">
            <button
                type="button"
                class="category-tab btn btn-sm btn-solid"
                data-category="all"
            >
                <span>Todas</span>
            </button>
            @foreach($categories as $key => $label)
                <button
                    type="button"
                    class="category-tab btn btn-sm btn-neu"
                    data-category="{{ $key }}"
                >
                    <span>{{ $label }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="templates-grid">
    @foreach($templates as $key => $template)
        <div
            class="template-card nc flex flex-col justify-between cursor-pointer transition-transform hover:-translate-y-1"
            data-category="{{ $template['category'] }}"
            data-template-key="{{ $key }}"
        >
            <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-[var(--bg-dark)] shadow-[var(--neu-in)] flex items-center justify-center text-2xl text-[var(--verde)]">
                    <span>{{ $template['icon'] ?? '📝' }}</span>
                </div>
                <div class="space-y-1 flex-1">
                    <h3 class="text-base font-bold text-[var(--text-dark)] leading-snug font-[Sora]">
                        {{ $template['title'] }}
                    </h3>
                    <p class="text-xs text-[var(--text-muted)] leading-relaxed">
                        {{ $template['description'] }}
                    </p>
                </div>
            </div>

            <div class="mt-auto pt-4 border-t border-[var(--bg-dark)] flex items-center justify-between">
                <span class="badge-neu bn-muted text-[10px] uppercase tracking-wider">
                    {{ ucfirst($template['category']) }}
                </span>
                <a
                    href="{{ route('editor.encuestas.nueva', ['template' => $key]) }}"
                    class="btn btn-oro btn-sm"
                    style="padding: 6px 14px; font-size: 11px;"
                >
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    Usar plantilla
                </a>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tabs = document.querySelectorAll('.category-tab');
        var cards = document.querySelectorAll('.template-card');

        function activateCategory(category) {
            tabs.forEach(function (tab) {
                if (tab.getAttribute('data-category') === category) {
                    tab.classList.remove('btn-neu');
                    tab.classList.add('btn-solid');
                } else {
                    tab.classList.remove('btn-solid');
                    tab.classList.add('btn-neu');
                }
            });

            cards.forEach(function (card) {
                var cardCategory = card.getAttribute('data-category');
                card.style.display = (category === 'all' || cardCategory === category) ? 'flex' : 'none';
            });
        }

        if (tabs.length > 0) {
            activateCategory('all');
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var category = tab.getAttribute('data-category');
                activateCategory(category);
            });
        });

        cards.forEach(function (card) {
            card.addEventListener('click', function (event) {
                if (event.target.closest('a')) {
                    return;
                }
                var key = card.getAttribute('data-template-key');
                if (key) {
                    window.location.href = "{{ route('editor.encuestas.nueva') }}" + '?template=' + encodeURIComponent(key);
                }
            });
        });
    });
</script>
@endsection
