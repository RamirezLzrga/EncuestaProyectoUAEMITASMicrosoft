@extends('layouts.app')

@section('title', 'Crear desde plantillas')

@section('content')
<div class="dashboard-wrap">
    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">SIEI UAEMex</div>
            <h2 class="dash-title">Crear a partir de plantillas</h2>
            <p class="dash-subtitle">Elige un escenario y comienza con una plantilla preconfigurada</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('editor.dashboard') }}" class="px-4 py-2 rounded-full border border-gray-500/40 text-gray-300 text-xs font-semibold hover:bg-white/5 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Volver al panel
            </a>
        </div>
    </div>

    <div class="bg-slate-900/70 border border-white/10 rounded-3xl p-6 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-100 mb-1">Tipo de formulario</h3>
                <p class="text-xs text-gray-400">Selecciona el tipo de experiencia que quieres crear</p>
            </div>
            <div class="flex flex-wrap gap-2" id="template-category-tabs">
                @foreach($categories as $key => $label)
                    <button
                        type="button"
                        class="category-tab inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold border border-white/10 text-gray-300 hover:bg-white/10 transition {{ $loop->first ? 'bg-emerald-500/20 border-emerald-400/60 text-emerald-100' : '' }}"
                        data-category="{{ $key }}"
                    >
                        <span>{{ $label }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="templates-grid">
        @foreach($templates as $key => $template)
            <div
                class="template-card bg-slate-900/70 border border-white/10 rounded-2xl p-4 flex flex-col justify-between hover:border-emerald-400/70 hover:-translate-y-1 transition transform cursor-pointer"
                data-category="{{ $template['category'] }}"
                data-template-key="{{ $key }}"
            >
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-xl">
                        <span>{{ $template['icon'] ?? '📝' }}</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-semibold text-gray-100 leading-snug">
                            {{ $template['title'] }}
                        </h3>
                        <p class="text-xs text-gray-400 leading-snug">
                            {{ $template['description'] }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between text-[11px] text-gray-400">
                    <span>Plantilla {{ ucfirst($template['category']) }}</span>
                    <a
                        href="{{ route('editor.encuestas.nueva', ['template' => $key]) }}"
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-emerald-500 text-[11px] font-semibold text-white hover:bg-emerald-600 transition"
                    >
                        <i class="fas fa-magic"></i>
                        Usar plantilla
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tabs = document.querySelectorAll('.category-tab');
        var cards = document.querySelectorAll('.template-card');

        function activateCategory(category) {
            tabs.forEach(function (tab) {
                if (tab.getAttribute('data-category') === category) {
                    tab.classList.add('bg-emerald-500/20', 'border-emerald-400/60', 'text-emerald-100');
                } else {
                    tab.classList.remove('bg-emerald-500/20', 'border-emerald-400/60', 'text-emerald-100');
                }
            });

            cards.forEach(function (card) {
                var cardCategory = card.getAttribute('data-category');
                card.style.display = (category === null || cardCategory === category) ? 'flex' : 'none';
            });
        }

        if (tabs.length > 0) {
            var defaultCategory = tabs[0].getAttribute('data-category');
            activateCategory(defaultCategory);
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
@endpush

