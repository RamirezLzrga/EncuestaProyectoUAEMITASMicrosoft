@extends('layouts.editor')

@section('title', 'Respuestas de Encuesta')

@section('content')
<div class="welcome-section" style="margin-bottom: 1.5rem;">
    <div class="welcome-content flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="greeting-eyebrow">Respuestas de encuesta</p>
            <h2 class="greeting">{{ $survey->title }}</h2>
            <p class="greeting-subtitle">Resumen por pregunta de las respuestas recibidas</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('editor.encuestas.editar', $survey) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                <i class="fas fa-pen"></i>
                Volver al editor
            </a>
            <a href="{{ route('editor.encuestas.compartir', $survey) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-uaemex text-white text-xs font-semibold hover:bg-green-800 transition">
                <i class="fas fa-share-alt"></i>
                Compartir encuesta
            </a>
        </div>
    </div>
</div>

<div class="flex items-center justify-between mb-4" style="display:none;">
    <div>
        <p class="text-xs uppercase tracking-widest text-gray-400 font-semibold">Respuestas</p>
        <h1 class="text-2xl font-bold text-gray-100 mt-1">{{ $survey->title }}</h1>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('editor.encuestas.editar', $survey) }}" class="px-4 py-2 rounded-full border border-gray-500/40 text-gray-300 text-xs font-semibold hover:bg-white/5 transition flex items-center gap-2">
            <i class="fas fa-pen"></i>
            Editor
        </a>
        <a href="{{ route('editor.encuestas.compartir', $survey) }}" class="px-4 py-2 rounded-full border border-emerald-500/40 text-emerald-300 text-xs font-semibold hover:bg-emerald-500/10 transition flex items-center gap-2">
            <i class="fas fa-share-alt"></i>
            Compartir
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-5">
    <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">Total respuestas</span>
            <i class="fas fa-inbox text-emerald-400"></i>
        </div>
        <p class="text-2xl font-bold text-gray-100 mt-2">{{ $totalResponses }}</p>
    </div>
    <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">Tasa de completado</span>
            <i class="fas fa-percentage text-sky-400"></i>
        </div>
        <p class="text-2xl font-bold text-gray-100 mt-2">{{ $completionRate }}%</p>
    </div>
    <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">Tiempo promedio</span>
            <i class="fas fa-clock text-amber-400"></i>
        </div>
        <p class="text-2xl font-bold text-gray-100 mt-2">
            @if($avgTimeSeconds)
                {{ $avgTimeSeconds }} s
            @else
                N/D
            @endif
        </p>
    </div>
    <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">Exportar</span>
            <i class="fas fa-file-export text-fuchsia-400"></i>
        </div>
        <p class="text-xs text-gray-400 mt-2">Puedes exportar los datos a CSV desde esta vista en una iteración posterior.</p>
    </div>
</div>

<div class="bg-slate-900/60 border border-white/10 rounded-2xl p-4">
    <div class="flex border-b border-white/10 mb-4 text-xs">
        <button class="px-3 py-2 text-emerald-300 border-b-2 border-emerald-400">Resumen</button>
        <button class="px-3 py-2 text-gray-400 cursor-not-allowed">Individuales</button>
        <button class="px-3 py-2 text-gray-400 cursor-not-allowed">Análisis</button>
    </div>

    <div class="space-y-4">
        <p class="text-xs text-gray-400">Resumen simple por pregunta basado en las respuestas almacenadas.</p>
        @if($totalResponses === 0)
            <p class="text-sm text-gray-500">Aún no hay respuestas para esta encuesta.</p>
        @else
            @foreach($survey->questions as $index => $question)
                <div class="border border-white/10 rounded-xl p-3 text-xs">
                    <p class="font-semibold text-gray-100 mb-2">{{ $index + 1 }}. {{ $question['text'] }}</p>
                    @if(in_array($question['type'], ['multiple_choice', 'checkboxes']) && !empty($question['options']))
                        @php
                            $counts = [];
                            foreach ($question['options'] as $opt) {
                                $counts[$opt] = 0;
                            }
                            foreach ($responses as $response) {
                                $answers = $response->answers[$question['text']] ?? null;
                                if (is_array($answers)) {
                                    foreach ($answers as $ans) {
                                        if (isset($counts[$ans])) {
                                            $counts[$ans]++;
                                        }
                                    }
                                } else {
                                    if ($answers !== null && isset($counts[$answers])) {
                                        $counts[$answers]++;
                                    }
                                }
                            }
                        @endphp
                        @foreach($counts as $opt => $count)
                            @php
                                $percent = $totalResponses > 0 ? round(($count / $totalResponses) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-2 mb-1">
                                <div class="flex-1">
                                    <div class="flex justify-between text-[11px] text-gray-300">
                                        <span>{{ $opt }}</span>
                                        <span>{{ $count }} ({{ $percent }}%)</span>
                                    </div>
                                    <div class="w-full h-1.5 rounded-full bg-slate-800 mt-1">
                                        <div class="h-full rounded-full bg-emerald-500" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-400 text-[11px]">Pregunta abierta o de texto. El detalle de respuestas se puede explorar en la pestaña Individuales.</p>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
