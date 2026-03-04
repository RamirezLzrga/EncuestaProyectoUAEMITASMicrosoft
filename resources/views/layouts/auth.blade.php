<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <style>
        :root {
            --uaemex-green: #1a5c2a;
            --uaemex-green-dark: #12411d;
            --uaemex-gold: #c9a227;
        }
        .bg-uaemex {
            background-color: var(--uaemex-green);
        }
        .text-uaemex {
            color: var(--uaemex-green);
        }
        .btn-uaemex {
            background-color: var(--uaemex-green);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-uaemex:hover {
            background-color: var(--uaemex-green-dark);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans">
    @yield('content')
</body>
</html>
