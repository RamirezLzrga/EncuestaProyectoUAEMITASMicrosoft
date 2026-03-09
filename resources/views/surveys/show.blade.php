@extends('layouts.admin')

@section('title', $survey->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="ph">
            <div class="ph-left">
                <div class="ph-label">Administración</div>
                <div class="ph-title">{{ $survey->title }}</div>
                <div class="ph-sub">Detalle de la encuesta seleccionada</div>
            </div>
            <div class="ph-actions" style="flex-wrap:wrap;">
                <a href="{{ route('surveys.index') }}" class="btn btn-neu">← Volver</a>
                <a href="{{ route('surveys.public', $survey->id) }}" target="_blank" class="btn btn-oro">↗ Enlace público</a>
                <a href="{{ route('surveys.edit', $survey->id) }}" class="btn btn-solid">✏ Editar</a>
            </div>
        </div>

        <!-- Survey Info -->
        <div class="neu-card" style="padding:0; overflow:hidden;">
            <div style="height:6px; background:var(--verde); width:100%;"></div>
            <div style="padding:28px;">
                <h1 style="font-family:'Sora',sans-serif; font-weight:800; font-size:28px; color:var(--text-dark);">{{ $survey->title }}</h1>
                <p style="color:var(--text-muted); margin-top:8px;">{{ $survey->description }}</p>
                
                <div style="display:flex; flex-wrap:wrap; gap:14px; margin-top:18px; padding-top:18px; border-top:1px solid rgba(0,0,0,.06); font-size:12.5px; color:var(--text-muted);">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-weight:800; color:var(--text);">Autor:</span>
                        <span>{{ $survey->user->name ?? 'Desconocido' }}</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-weight:800; color:var(--text);">Creada:</span>
                        <span>{{ $survey->created_at->format('d/m/Y h:i A') }}</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-weight:800; color:var(--text);">Vigencia:</span>
                        <span>{{ \Carbon\Carbon::parse($survey->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($survey->end_date)->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="status-pill {{ $survey->is_active ? 'status-approved' : 'status-rejected' }}" style="background:var(--bg);">
                            {{ $survey->is_active ? '● Activa' : '○ Inactiva' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions -->
        <div class="space-y-6">
            <div style="display:flex; align-items:baseline; justify-content:space-between; gap:12px; margin-top:22px;">
                <div style="font-family:'Sora',sans-serif; font-weight:800; font-size:16px; color:var(--text-dark);">
                    Preguntas ({{ count($survey->questions ?? []) }})
                </div>
            </div>
            
            @php
                $totalSections = 0;
                foreach(($survey->questions ?? []) as $q) {
                    if (($q['type'] ?? null) === 'section') {
                        $totalSections++;
                    }
                }
                $currentSection = 0;
            @endphp

            @if(isset($survey->questions) && count($survey->questions) > 0)
                @foreach($survey->questions as $index => $question)
                    @if(($question['type'] ?? null) === 'section')
                        @php $currentSection++; @endphp
                        <div class="neu-card" style="margin-bottom:0; background:var(--blue-pale); padding:18px;">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-[#1967d2] bg-white">
                                        Sección {{ $currentSection }} de {{ $totalSections }}
                                    </span>
                                </div>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-1">
                                {{ $question['text'] }}
                            </h4>
                            @if(!empty($question['description']))
                                <p class="text-gray-600 text-sm">{{ $question['description'] }}</p>
                            @endif
                        </div>
                        @continue
                    @endif

                    <div class="neu-card" style="margin-bottom:0; padding:18px;">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="text-lg font-bold text-gray-800">
                                {{ $index + 1 }}. {{ $question['text'] }}
                                @if(isset($question['required']) && $question['required'])
                                    <span class="text-red-500 text-sm">*</span>
                                @endif
                            </h4>
                            <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-1 rounded uppercase">
                                {{ $question['type'] }}
                            </span>
                        </div>

                        <div class="pl-4 border-l-2 border-gray-100 space-y-3">
                            @if(!empty($question['image_url']))
                                <div>
                                    <span class="text-xs text-gray-500 uppercase tracking-wide">Imagen</span>
                                    <div class="mt-1">
                                        <img src="{{ $question['image_url'] }}" alt="Imagen de la pregunta {{ $index + 1 }}" class="max-h-40 rounded-lg object-contain border border-dashed border-gray-200">
                                    </div>
                                </div>
                            @endif

                            @if(!empty($question['video_url']))
                                <div>
                                    <span class="text-xs text-gray-500 uppercase tracking-wide">Video</span>
                                    <div class="mt-1">
                                        <a href="{{ $question['video_url'] }}" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 text-sm">
                                            <i class="fab fa-youtube"></i>
                                            Ver video asociado
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($question['type'] === 'short_text')
                                <div class="border-b border-gray-300 border-dashed py-2 text-gray-400 text-sm italic w-1/2">Respuesta corta...</div>
                            @elseif($question['type'] === 'paragraph')
                                <div class="border-b border-gray-300 border-dashed py-2 text-gray-400 text-sm italic w-full">Respuesta larga...</div>
                                <div class="border-b border-gray-300 border-dashed py-2 w-full"></div>
                            @elseif(in_array($question['type'], ['multiple_choice', 'checkboxes', 'dropdown']))
                                @if(isset($question['options']) && is_array($question['options']))
                                    <div class="space-y-2">
                                        @foreach($question['options'] as $option)
                                            <div class="flex items-center gap-2">
                                                @if($question['type'] === 'checkboxes')
                                                    <i class="far fa-square text-gray-400"></i>
                                                @elseif($question['type'] === 'dropdown')
                                                    <span class="text-gray-400 text-xs">▼</span>
                                                @else
                                                    <i class="far fa-circle text-gray-400"></i>
                                                @endif
                                                <span class="text-gray-700">{{ $option }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @elseif($question['type'] === 'date')
                                <div class="border-b border-gray-300 border-dashed py-2 text-gray-400 text-sm italic w-1/3">dd/mm/aaaa</div>
                            @elseif($question['type'] === 'time')
                                <div class="border-b border-gray-300 border-dashed py-2 text-gray-400 text-sm italic w-1/4">hh:mm</div>
                            @elseif($question['type'] === 'linear_scale')
                                <div class="flex items-center gap-4 text-gray-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="flex flex-col items-center text-xs">
                                            <i class="far fa-circle mb-1"></i>
                                            <span>{{ $i }}</span>
                                        </div>
                                    @endfor
                                </div>
                            @elseif($question['type'] === 'rating')
                                <div class="flex items-center gap-1 text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star text-xl"></i>
                                    @endfor
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="neu-card" style="margin-bottom:0; text-align:center; color:var(--text-muted);">
                    Esta encuesta no tiene preguntas configuradas.
                </div>
            @endif
        </div>
    </div>
@endsection
