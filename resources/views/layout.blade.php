<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Manrope:wght@200..800&display=swap"
    rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-manrope">
    <div x-data="libraryApp()" x-init="init()" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300"
     :class="sidebarOpen && window.innerWidth < 1024 ? 'ml-64' : ''">
            <!-- Header -->
            @include('partials.header')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-3 bg-gray-50">
                <!-- Dashboard Content -->

                @yield('content')
                <!-- Other Menu Content -->
                {{-- <div x-show="activeMenu !== 'Dashboard' || activeMenu !== 'Buku'" class="text-center py-16">
                    <i class="fas fa-cog text-6xl text-gray-300 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-600 mb-2" x-text="`Halaman ${activeMenu}`"></h2>
                    <p class="text-gray-500">Konten untuk halaman ini sedang dalam pengembangan.</p>
                </div> --}}
            </main>
        </div>

    </div>
</body>
</html>
