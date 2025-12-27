<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- TailwindCSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Навигация --}}
    <nav class="bg-gray-800 text-white px-4 py-3">
        <div class="container mx-auto flex justify-between items-center">
            <span class="font-bold text-lg">Админ-панель</span>
            <div>
                <a href="{{ route('admin.tickets.index') }}" class="mr-4 hover:underline">Заявки</a>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="mr-4 hover:underline">Выйти</button>
</form>

            </div>
        </div>
    </nav>

    {{-- Контент --}}
    <main class="flex-1 container mx-auto p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    {{-- Футер --}}
    <footer class="bg-gray-800 text-white text-center py-2">
        &copy; {{ date('Y') }} CRM
    </footer>

</body>
</html>
