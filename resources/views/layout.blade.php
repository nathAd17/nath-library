<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital - Dashboard</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Manrope:wght@200..800&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 font-manrope">
    <div x-data="libraryApp()" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Header -->
            @include('partials.header')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <!-- Dashboard Content -->

                @yield('content')
                <!-- Other Menu Content -->
                <div x-show="activeMenu !== 'Dashboard'" class="text-center py-16">
                    <i class="fas fa-cog text-6xl text-gray-300 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-600 mb-2" x-text="`Halaman ${activeMenu}`"></h2>
                    <p class="text-gray-500">Konten untuk halaman ini sedang dalam pengembangan.</p>
                </div>
            </main>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"></div>

    <script>
        function libraryApp() {
            return {
                sidebarOpen: false,
                activeMenu: 'Dashboard',
                activeSubmenu: '',
                pageTitle: 'Dashboard',
                currentSlide: 0,

                navigation: [
                    {
                        name: 'Dashboard',
                        icon: 'fas fa-home',
                        submenu: null
                    },
                    {
                        name: 'Buku',
                        icon: 'fas fa-book',
                        submenu: [
                            { name: 'Daftar Buku' },
                            { name: 'Tambah Buku' },
                            { name: 'Kategori Buku' }
                        ]
                    },
                    {
                        name: 'Transaksi',
                        icon: 'fas fa-exchange-alt',
                        submenu: [
                            { name: 'Peminjaman' },
                            { name: 'Pengembalian' },
                            { name: 'Riwayat Transaksi' }
                        ]
                    },
                    {
                        name: 'Anggota',
                        icon: 'fas fa-users',
                        submenu: [
                            { name: 'Daftar Anggota' },
                            { name: 'Tambah Anggota' }
                        ]
                    },
                    {
                        name: 'Laporan',
                        icon: 'fas fa-chart-bar',
                        submenu: [
                            { name: 'Laporan Peminjaman' },
                            { name: 'Laporan Anggota' },
                            { name: 'Statistik' }
                        ]
                    },
                    {
                        name: 'Notifikasi',
                        icon: 'fas fa-bell',
                        badge: '3'
                    },
                    {
                        name: 'Pengaturan',
                        icon: 'fas fa-cog',
                        submenu: [
                            { name: 'Profil' },
                            { name: 'Sistem' }
                        ]
                    }
                ],

                popularBooks: [
                    [
                        { id: 1, title: 'JavaScript: The Good Parts', author: 'Douglas Crockford', cover: 'https://via.placeholder.com/200x300/3B82F6/FFFFFF?text=JS+Book', rating: 4.8, borrowed: 45 },
                        { id: 2, title: 'Clean Code', author: 'Robert C. Martin', cover: 'https://via.placeholder.com/200x300/10B981/FFFFFF?text=Clean+Code', rating: 4.9, borrowed: 38 },
                        { id: 3, title: 'Design Patterns', author: 'Gang of Four', cover: 'https://via.placeholder.com/200x300/8B5CF6/FFFFFF?text=Design+Patterns', rating: 4.7, borrowed: 32 },
                        { id: 4, title: 'Refactoring', author: 'Martin Fowler', cover: 'https://via.placeholder.com/200x300/F59E0B/FFFFFF?text=Refactoring', rating: 4.6, borrowed: 28 }
                    ],
                    [
                        { id: 5, title: 'The Pragmatic Programmer', author: 'David Thomas', cover: 'https://via.placeholder.com/200x300/EF4444/FFFFFF?text=Pragmatic', rating: 4.8, borrowed: 25 },
                        { id: 6, title: 'Code Complete', author: 'Steve McConnell', cover: 'https://via.placeholder.com/200x300/06B6D4/FFFFFF?text=Code+Complete', rating: 4.7, borrowed: 22 },
                        { id: 7, title: 'Effective Java', author: 'Joshua Bloch', cover: 'https://via.placeholder.com/200x300/84CC16/FFFFFF?text=Effective+Java', rating: 4.9, borrowed: 20 },
                        { id: 8, title: 'System Design', author: 'Alex Xu', cover: 'https://via.placeholder.com/200x300/F97316/FFFFFF?text=System+Design', rating: 4.5, borrowed: 18 }
                    ]
                ],

                topUsers: [
                    { id: 1, name: 'Ahmad Fauzi', books: 15, points: 1250 },
                    { id: 2, name: 'Siti Nurhaliza', books: 12, points: 1100 },
                    { id: 3, name: 'Budi Santoso', books: 10, points: 950 },
                    { id: 4, name: 'Rina Wati', books: 9, points: 850 },
                    { id: 5, name: 'Doni Pratama', books: 8, points: 750 },
                    { id: 6, name: 'Maya Sari', books: 7, points: 650 },
                    { id: 7, name: 'Rizki Ramadhan', books: 6, points: 550 },
                    { id: 8, name: 'Dewi Anggraini', books: 5, points: 450 }
                ],

                setActiveMenu(menu) {
                    this.activeMenu = menu;
                    this.activeSubmenu = '';
                    this.pageTitle = menu;
                },

                setActiveSubmenu(submenu) {
                    this.activeSubmenu = submenu;
                    this.pageTitle = submenu;
                },

                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.popularBooks.length;
                },

                prevSlide() {
                    this.currentSlide = this.currentSlide === 0 ? this.popularBooks.length - 1 : this.currentSlide - 1;
                },

                init() {
                    // Auto-slide carousel
                    setInterval(() => {
                        if (this.activeMenu === 'Dashboard') {
                            this.nextSlide();
                        }
                    }, 5000);
                }
            }
        }
    </script>
</body>
</html>
