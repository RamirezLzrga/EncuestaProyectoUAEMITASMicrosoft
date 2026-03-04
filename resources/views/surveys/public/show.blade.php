<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survey->title }} - SIEI UAEMex</title>
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-uaemex { background-color: #0d5c41; }
        .text-uaemex { color: #0d5c41; }
        .btn-uaemex { background-color: #0d5c41; }
        .bg-gold { background-color: #d4af37; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen py-10">

    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            @if(!empty($survey->header_image))
                <div class="w-full h-48 overflow-hidden">
                    <img src="{{ $survey->header_image }}" alt="Imagen de encabezado" class="w-full h-full object-cover">
                </div>
            @else
                <div class="h-3 bg-uaemex w-full"></div>
            @endif
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $survey->title }}</h1>
                <p class="text-gray-600">{{ $survey->description }}</p>
                <div class="mt-4 text-sm text-gray-500 italic">
                    <span class="text-red-500">* Obligatorio</span>
                </div>
            </div>
        </div>

        <form action="{{ route('surveys.store-answer', $survey->id) }}" method="POST">
            @csrf
            
            @php
                $settings = $survey->settings ?? [];
            @endphp

            @if((!empty($settings['collect_names']) || !empty($settings['collect_emails'])) && empty($settings['anonymous']))
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-circle text-uaemex"></i>
                    Datos del participante
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if(!empty($settings['collect_names']))
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="answers[Nombre]" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-uaemex focus:bg-white transition" placeholder="Escribe tu nombre">
                    </div>
                    @endif
                    @if(!empty($settings['collect_emails']))
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" name="answers[Correo electrónico]" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-uaemex focus:bg-white transition" placeholder="tucorreo@ejemplo.com">
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @php
                $totalSections = 0;
                foreach(($survey->questions ?? []) as $q) {
                    if (($q['type'] ?? null) === 'section') {
                        $totalSections++;
                    }
                }
                $currentSection = 0;
            @endphp

            <div class="space-y-4">
                @foreach($survey->questions as $index => $question)
                    @if(($question['type'] ?? null) === 'section')
                        @php $currentSection++; @endphp
                        <div class="bg-[#e8f5fe] p-6 rounded-2xl shadow-sm border border-gray-200">
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-[#1967d2] bg-white">
                                    Sección {{ $currentSection }} de {{ $totalSections }}
                                </span>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $question['text'] }}</h2>
                            @if(!empty($question['description']))
                                <p class="text-gray-600 text-sm">{{ $question['description'] }}</p>
                            @endif
                        </div>
                        @continue
                    @endif

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        @if(!empty($question['image_url']))
                            <div class="mb-4">
                                <img src="{{ $question['image_url'] }}" alt="Imagen de la pregunta {{ $index + 1 }}" class="max-h-56 mx-auto rounded-lg object-contain">
                            </div>
                        @endif

                        @if(!empty($question['video_url']))
                            <div class="mb-4">
                                <a href="{{ $question['video_url'] }}" target="_blank" class="inline-flex items-center gap-2 text-uaemex underline text-sm">
                                    <i class="fab fa-youtube"></i>
                                    Ver video asociado
                                </a>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="font-bold text-gray-800 text-lg block">
                                {{ $question['text'] }}
                                @if(isset($question['required']) && $question['required'])
                                    <span class="text-red-500 ml-1">*</span>
                                @endif
                            </label>
                        </div>

                        <div class="text-gray-700">
                            @if($question['type'] === 'short_text')
                                <input type="text" name="answers[{{ $question['text'] }}]" 
                                    class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-uaemex focus:bg-white transition" 
                                    placeholder="Tu respuesta"
                                    {{ isset($question['required']) && $question['required'] ? 'required' : '' }}>
                            
                            @elseif($question['type'] === 'paragraph')
                                <textarea name="answers[{{ $question['text'] }}]" 
                                    class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-uaemex focus:bg-white transition resize-none" 
                                    rows="4"
                                    placeholder="Tu respuesta"
                                    {{ isset($question['required']) && $question['required'] ? 'required' : '' }}></textarea>
                            
                            @elseif($question['type'] === 'multiple_choice')
                                <div class="space-y-3">
                                    @if(isset($question['options']) && is_array($question['options']))
                                        @foreach($question['options'] as $option)
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="radio" name="answers[{{ $question['text'] }}]" value="{{ $option }}" 
                                                    class="w-5 h-5 text-uaemex border-gray-300 focus:ring-uaemex"
                                                    {{ isset($question['required']) && $question['required'] ? 'required' : '' }}>
                                                <span class="group-hover:text-uaemex transition">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>

                            @elseif($question['type'] === 'dropdown')
                                <select name="answers[{{ $question['text'] }}]" 
                                    class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-uaemex focus:bg-white transition"
                                    {{ isset($question['required']) && $question['required'] ? 'required' : '' }}>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    @if(isset($question['options']) && is_array($question['options']))
                                        @foreach($question['options'] as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @endif
                                </select>

                            @elseif($question['type'] === 'checkboxes')
                                <div class="space-y-3">
                                    @if(isset($question['options']) && is_array($question['options']))
                                        @foreach($question['options'] as $option)
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="answers[{{ $question['text'] }}][]" value="{{ $option }}" 
                                                    class="w-5 h-5 text-uaemex border-gray-300 rounded focus:ring-uaemex">
                                                <span class="group-hover:text-uaemex transition">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            
                            @elseif($question['type'] === 'date')
                                <input type="date" name="answers[{{ $question['text'] }}]"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-uaemex focus:bg-white transition"
                                    {{ isset($question['required']) && $question['required'] ? 'required' : '' }}>

                            @elseif($question['type'] === 'time')
                                <input type="time" name="answers[{{ $question['text'] }}]"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-uaemex focus:bg-white transition"
                                    {{ isset($question['required']) && $question['required'] ? 'required' : '' }}>

                            @elseif($question['type'] === 'linear_scale')
                                <div class="flex items-center justify-between gap-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="flex flex-col items-center text-xs text-gray-600">
                                            <input type="radio" name="answers[{{ $question['text'] }}]" value="{{ $i }}"
                                                class="mb-1 text-uaemex border-gray-300 focus:ring-uaemex"
                                                {{ isset($question['required']) && $question['required'] ? 'required' : '' }}>
                                            <span>{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>

                            @elseif($question['type'] === 'rating')
                                <div class="flex items-center gap-3 rating-group">
                                    <div class="flex items-center gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer rating-option" data-value="{{ $i }}">
                                                <input type="radio" name="answers[{{ $question['text'] }}]" value="{{ $i }}" class="hidden"
                                                    {{ isset($question['required']) && $question['required'] ? 'required' : '' }}>
                                                <i class="far fa-star text-2xl text-gray-300 hover:text-yellow-400 transform hover:scale-110 transition"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Calificación seleccionada:
                                        <span class="font-semibold rating-selected-value">Ninguna</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer con Botón Enviar -->
            <div class="mt-8 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt text-uaemex"></i> Tus datos están protegidos.
                </div>
                <button type="submit" class="bg-uaemex text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-green-900/20 hover:bg-green-800 transition transform hover:-translate-y-1">
                    Enviar Respuesta
                </button>
            </div>
        </form>
    </div>
    
    <div class="text-center mt-10 mb-6 text-gray-400 text-sm">
        &copy; {{ date('Y') }} SIEI UAEMex - Sistema Integral de Evaluación Institucional
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var groups = document.querySelectorAll('.rating-group');
            groups.forEach(function (group) {
                var options = group.querySelectorAll('.rating-option');
                var display = group.querySelector('.rating-selected-value');

                function updateStars(selectedValue) {
                    options.forEach(function (option) {
                        var value = parseInt(option.getAttribute('data-value'), 10);
                        var star = option.querySelector('i');
                        var input = option.querySelector('input[type="radio"]');

                        if (selectedValue !== null && value <= selectedValue) {
                            star.classList.remove('far', 'text-gray-300');
                            star.classList.add('fas', 'text-yellow-400');
                        } else {
                            star.classList.add('far', 'text-gray-300');
                            star.classList.remove('fas', 'text-yellow-400');
                        }

                        if (input) {
                            if (selectedValue !== null && value === selectedValue) {
                                input.checked = true;
                            }
                        }
                    });

                    if (display) {
                        display.textContent = selectedValue !== null ? selectedValue : 'Ninguna';
                    }
                }

                options.forEach(function (option) {
                    option.addEventListener('click', function (event) {
                        event.preventDefault();
                        var value = parseInt(option.getAttribute('data-value'), 10);
                        updateStars(value);
                    });
                });

                var initialSelected = null;
                options.forEach(function (option) {
                    var input = option.querySelector('input[type="radio"]');
                    if (input && input.checked) {
                        var value = parseInt(option.getAttribute('data-value'), 10);
                        if (!isNaN(value)) {
                            initialSelected = value;
                        }
                    }
                });
                updateStars(initialSelected);
            });
        });
    </script>
</body>
</html>
