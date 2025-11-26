<!DOCTYPE html>
<html lang="id" class="no-scrollbar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/slot-assets/slot.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-korpri-event min-h-screen flex flex-col items-center justify-center p-4 pt-24 text-slate-800">
    <div id="mainNavbar" class="w-full fixed top-0 z-50 transition-transform duration-300">
        <x-reward-system.navbar />
    </div>

    {{ $slot }}
</body>

</html>