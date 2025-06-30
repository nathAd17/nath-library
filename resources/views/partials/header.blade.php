@php
    $routeName = Route::currentRouteName();
    $pageTitle = match($routeName) {
        'dashboard' => 'Dashboard',
        'books.index' => 'Buku',
        'books.create' => 'Tambah Buku',
        'members.index' => 'Daftar Anggota',
        default => 'Halaman'
    };
@endphp

<header class="bg-white my-2 mx-3 rounded-xl shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="lg:hidden  p-2 rounded-lg hover:bg-gray-100 transition-colors">

                                <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $pageTitle }}</h1>
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
