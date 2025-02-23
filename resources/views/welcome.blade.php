<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hypress Global</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/0e98857287.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans" style="background-color: #202433;">
<div class="relative min-h-screen flex flex-col items-center justify-center">
    <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
        <header class="fixed top-0 left-0 w-full bg-gray-800 text-white py-4 shadow-md z-50">
            <div class="flex justify-between items-center px-6">
                <div class="text-lg font-bold">Hypress</div>
                <nav>
                    @if (Route::has('login'))
                        <livewire:welcome.navigation />
                    @endif
                </nav>
            </div>
        </header>
        <main class="flex flex-col items-center justify-center mt-20">
            <h1 class="text-4xl font-bold text-white bg-[#48067a] px-2 py-1 rounded-md">Welcome to Hypress</h1>
            <p class="text-xl text-white mt-4">Subsea assets and pipelines</p>
        </main>
    </div>
</div>
</body>
</html>
