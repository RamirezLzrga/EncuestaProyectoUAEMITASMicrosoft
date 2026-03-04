<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta Finalizada - SIEI UAEMex</title>
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-uaemex { background-color: #0d5c41; }
        .text-uaemex { color: #0d5c41; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center border-t-4 border-uaemex">
        <div class="mb-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-4xl text-green-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">¡Gracias por contestar!</h1>
            <p class="text-gray-600">Tu participación es muy importante para nosotros. Hemos registrado tus respuestas correctamente.</p>
        </div>

        @php
            $settings = $survey->settings ?? [];
            $isAnonymous = !empty($settings['anonymous']);
            $isAuthenticated = auth()->check();
        @endphp

        <div class="space-y-3">
            @if($isAnonymous && !$isAuthenticated)
                <a href="{{ route('surveys.public', $survey->id) }}" class="block w-full bg-uaemex hover:bg-green-800 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-green-900/20">
                    <i class="fas fa-redo-alt mr-2"></i> Enviar otra respuesta
                </a>
                <a href="{{ url('/') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-lg transition">
                    Volver al inicio
                </a>
            @elseif($isAuthenticated)
                <p class="text-sm text-gray-500 mt-4">Gracias por su respuesta.</p>
            @else
                <a href="{{ url('/') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-lg transition">
                    Volver al inicio
                </a>
            @endif
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-100">
            <p class="text-xs text-gray-400">SIEI UAEMex &copy; {{ date('Y') }}</p>
        </div>
    </div>

</body>
</html>
