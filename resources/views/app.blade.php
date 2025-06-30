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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
     <div x-data="libraryApp()" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-blue-900 shadow-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-blue-900 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">DigiLib</h1>
                        <p class="text-blue-200 text-xs">Perpustakaan Digital</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4 space-y-2">
                <template x-for="item in navigation" :key="item.name">
                    <div>
                        <a href="#"
                           @click.prevent="setActiveMenu(item.name)"
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-blue-700 hover:shadow-md transform hover:scale-105"
                           :class="activeMenu === item.name ? 'bg-blue-700 text-white shadow-lg' : 'text-blue-200 hover:text-white'">
                            <i :class="item.icon" class="w-5 h-5 mr-3"></i>
                            <span x-text="item.name"></span>
                            <span x-show="item.badge"
                                  class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1"
                                  x-text="item.badge"></span>
                        </a>

                        <!-- Submenu -->
                        <div x-show="item.submenu && activeMenu === item.name"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="ml-8 mt-2 space-y-1">
                            <template x-for="subitem in item.submenu" :key="subitem.name">
                                <a href="#"
                                   @click.prevent="setActiveSubmenu(subitem.name)"
                                   class="block px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-700 rounded-lg transition-colors duration-200"
                                   :class="activeSubmenu === subitem.name ? 'bg-blue-700 text-white' : ''"
                                   x-text="subitem.name"></a>
                            </template>
                        </div>
                    </div>
                </template>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 left-0 right-0 p-4 bg-blue-900">
                <div class="flex items-center space-x-3 p-3 bg-blue-800 rounded-lg">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=3B82F6&color=fff"
                         alt="Avatar" class="w-10 h-10 rounded-full">
                    <div class="flex-1">
                        <p class="text-white font-medium text-sm">Admin User</p>
                        <p class="text-blue-200 text-xs">administrator</p>
                    </div>
                    <button class="text-blue-200 hover:text-white transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-800" x-text="pageTitle"></h1>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text"
                                   placeholder="Cari buku, pengarang..."
                                   class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-bell text-gray-600"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer">
                                        <p class="text-sm font-medium text-gray-800">Buku baru ditambahkan</p>
                                        <p class="text-xs text-gray-500 mt-1">"JavaScript: The Good Parts" telah tersedia</p>
                                        <p class="text-xs text-blue-500 mt-1">2 menit yang lalu</p>
                                    </div>
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer">
                                        <p class="text-sm font-medium text-gray-800">Pengembalian terlambat</p>
                                        <p class="text-xs text-gray-500 mt-1">John Doe terlambat mengembalikan buku</p>
                                        <p class="text-xs text-blue-500 mt-1">1 jam yang lalu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <!-- Dashboard Content -->
                <div x-show="activeMenu === 'Dashboard'">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm">Total Buku</p>
                                    <p class="text-3xl font-bold">1,234</p>
                                </div>
                                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                                    <i class="fas fa-book text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm">Dipinjam Hari Ini</p>
                                    <p class="text-3xl font-bold">45</p>
                                </div>
                                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                                    <i class="fas fa-hand-holding-heart text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm">Anggota Aktif</p>
                                    <p class="text-3xl font-bold">892</p>
                                </div>
                                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white transform hover:scale-105 transition-transform duration-200 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-orange-100 text-sm">Terlambat</p>
                                    <p class="text-3xl font-bold">12</p>
                                </div>
                                <div class="bg-orange-400 bg-opacity-30 rounded-full p-3">
                                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Book Carousel -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Buku Terpopuler</h2>
                            <div class="flex space-x-2">
                                <button @click="prevSlide()" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-left text-gray-600"></i>
                                </button>
                                <button @click="nextSlide()" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-right text-gray-600"></i>
                                </button>
                            </div>
                        </div>

                        <div class="relative overflow-hidden">
                            <div class="flex transition-transform duration-500 ease-in-out"
                                 :style="`transform: translateX(-${currentSlide * 100}%)`">
                                <template x-for="(book, index) in popularBooks" :key="index">
                                    <div class="w-full flex-shrink-0 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                        <template x-for="item in book" :key="item.id">
                                            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                                                <img :src="item.cover" :alt="item.title" class="w-full h-48 object-cover rounded-lg mb-3">
                                                <h3 class="font-semibold text-gray-800 text-sm mb-1" x-text="item.title"></h3>
                                                <p class="text-gray-600 text-xs mb-2" x-text="item.author"></p>
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-1">
                                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                        <span class="text-xs text-gray-600" x-text="item.rating"></span>
                                                    </div>
                                                    <span class="text-xs text-blue-600 font-medium" x-text="`${item.borrowed} dipinjam`"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Activity -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Activity Chart -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Peminjaman</h3>
                            <div class="h-64 bg-gradient-to-t from-blue-100 to-transparent rounded-lg flex items-end justify-center">
                                <div class="text-center">
                                    <i class="fas fa-chart-line text-4xl text-blue-500 mb-2"></i>
                                    <p class="text-gray-600">Grafik Aktivitas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Top Users -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Top 10 Anggota Aktif</h3>
                            <div class="space-y-3">
                                <template x-for="(user, index) in topUsers" :key="user.id">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                                 x-text="index + 1"></div>
                                            <div>
                                                <p class="font-medium text-gray-800 text-sm" x-text="user.name"></p>
                                                <p class="text-gray-500 text-xs" x-text="`${user.books} buku dipinjam`"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-bold text-yellow-500" x-text="`${user.points} pts`"></span>
                                            <i class="fas fa-trophy text-yellow-400"></i>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Menu Content -->
                <div x-show="activeMenu !== 'Dashboard'" class="text-center py-16">
                    <i class="fas fa-cog text-6xl text-gray-300 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-600 mb-2" x-text="`Halaman ${activeMenu}`"></h2>
                    <p class="text-gray-500">Konten untuk halaman ini sedang dalam pengembangan.</p>
                </div>
            </main>
        </div>
    </div>

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
