@props(['item', 'sidebarOpen',])
<div class="fixed inset-y-0 left-0 z-50 w-64 p-1 shadow-lg shadow-lighthover my-2 mx-2 rounded-2xl bg-gradient-to-b from-blue-900 via-info to-blue-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <!-- Logo -->
    <a href="/"
        class="flex items-center justify-center hover:-translate-y-1 ease-in-out transition-transform h-16 m-2 p-3 bg-light/10 backdrop-blur-lg rounded-xl shadow-blue-950/50 shadow-lg">
        <div class="flex items-center space-x-3 justify-around">
            <div class="w-10 h-10 bg-light rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-blue-900 text-xl"></i>
            </div>
            <div>
                <h1 class="text-light font-bold text-lg">DigiLib</h1>
                <p class="text-blue-200 text-xs">Perpustakaan Digital</p>
            </div>
        </div>
    </a>

    <!-- Navigation -->
    <nav class="mt-6 px-4 space-y-2">
        <template x-for="item in navigation" :key="item.name">
            <div>
                <a :href="item.route"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-infodark hover:shadow-md transform hover:scale-105"
                    :class="item.active ? 'bg-blue-700 text-light shadow-lg' : 'text-blue-200 hover:text-light'">
                    <i :class="item.icon" class="w-5 h-5 mr-3"></i>
                    <span x-text="item.name"></span>
                    <span x-show="item.badge" class="ml-auto bg-danger text-light text-xs rounded-full px-2 py-1"
                        x-text="item.badge"></span>
                </a>

                <!-- Submenu -->
                <div x-show="item.submenu && item.active" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0" class="ml-8 mt-2 space-y-1">
                    <template x-for="subitem in item.submenu" :key="subitem.name">
                        <a :href="subitem.route"
                            class="block px-4 py-2 text-sm text-blue-200 hover:text-light hover:bg-infodark rounded-lg transition-colors duration-200"
                            :class="subitem.active ? 'bg-blue-700 text-light' : ''" x-text="subitem.name"></a>
                    </template>
                </div>
            </div>
        </template>
    </nav>

    <!-- User Profile -->
    <div class="absolute bottom-0 left-0 right-0 p-3">
        <div
            class="flex items-center space-x-3 hover:-translate-y-1 ease-in-out transition-transform h-16 p-4 bg-light/10 backdrop-blur-lg rounded-xl shadow-blue-950/50 shadow-lg">
            <img src="https://ui-avatars.com/api/?name=Admin&background=3B82F6&color=fff" alt="Avatar"
                class="w-10 h-10 rounded-full">

            <div class="flex-1">
                <p class="text-light font-medium text-sm">{{ Auth::user()->name}}</p>
                <p class="text-blue-200 text-xs">{{ Auth::user()->role }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="text-blue-200 hover:text-light transition-colors">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </form>
        </div>
    </div>
</div>
<!-- Overlay for mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"></div>
<script>
    function libraryApp() {
        return {
            sidebarOpen: false,
            currentSlide: 0,

            navigation: [
                {
                    name: 'Dashboard',
                    route: '/dashboard',
                    icon: 'fas fa-home',
                    active: window.location.pathname.startsWith('/dashboard'),
                    submenu: null
                },
                {
                    name: 'Buku',
                    route: 'buku',
                    icon: 'fas fa-book',
                    active: window.location.pathname.startsWith('/buku'),
                    submenu: [
                        { name: 'Daftar Buku', route: 'buku', active: window.location.pathname.startsWith('/buku'), },
                        { name: 'Tambah Buku', route: 'buku.create', active: window.location.pathname.startsWith('/buku/create'), },
                        { name: 'Kategori Buku', route: 'kategori', active: window.location.pathname.startsWith('/kategori'), },
                    ]
                },
                {
                    name: 'Transaksi',
                    route: 'transaksi',
                    icon: 'fas fa-exchange-alt',
                    active: window.location.pathname.startsWith('/transaksi'),
                    submenu: [
                        { name: 'Peminjaman', route: 'dashboard', active: window.location.pathname.startsWith('/transaksi'), },
                        { name: 'Pengembalian', route: 'dashboard', active: window.location.pathname.startsWith('/transaksi'), },
                        { name: 'Riwayat Transaksi', route: 'dashboard', active: window.location.pathname.startsWith('/transaksi'), }
                    ]
                },
                {
                    name: 'Anggota',
                    route: 'anggota',
                    icon: 'fas fa-user-group',
                    active: window.location.pathname.startsWith('/anggota'),
                },
                {
                    name: 'Pengguna',
                    route: 'pengguna',
                    icon: 'fas fa-users',
                    active: window.location.pathname.startsWith('/pengguna'),
                },
                {
                    name: 'Laporan',
                    route: 'laporan',
                    icon: 'fas fa-chart-bar',
                    active: window.location.pathname.startsWith('/laporan'),
                    submenu: [
                        { name: 'Laporan Peminjaman', route: 'laporan', active: window.location.pathname.startsWith('/laporan'), },
                        { name: 'Laporan Anggota', route: 'laporan', active: window.location.pathname.startsWith('/laporan'), },
                        { name: 'Statistik', route: 'laporan', active: window.location.pathname.startsWith('/laporan'), }
                    ]
                },
                {
                    name: 'Notifikasi',
                    route: 'notifikasi',
                    icon: 'fas fa-bell',
                    active: window.location.pathname.startsWith('/notifikasi'),
                    badge: '3'
                },
                {
                    name: 'Pengaturan',
                    route: 'pengaturan',
                    icon: 'fas fa-cog',
                    active: window.location.pathname.startsWith('/pengaturan'),
                    submenu: [
                        { name: 'Profil', route: 'pengaturan', active: window.location.pathname.startsWith('/pengaturan'), },
                        { name: 'Sistem', route: 'pengaturan', active: window.location.pathname.startsWith('/pengaturan'), }
                    ]
                }
            ],

            popularBooks: [
                [
                    { id: 1, title: 'JavaScript: The Good Parts', author: 'Douglas Crockford', cover: 'https://images.unsplash.com/photo-1592496431122-2349e0fbc666?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Ym9vayUyMGNvdmVyfGVufDB8fDB8fHww', rating: 4.8, borrowed: 45 },
                    { id: 2, title: 'Clean Code', author: 'Robert C. Martin', cover: 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Ym9vayUyMGNvdmVyfGVufDB8fDB8fHww', rating: 4.9, borrowed: 38 },
                    { id: 3, title: 'Design Patterns', author: 'Gang of Four', cover: 'https://images.unsplash.com/photo-1641154748135-8032a61a3f80?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8Ym9vayUyMGNvdmVyfGVufDB8fDB8fHww', rating: 4.7, borrowed: 32 },
                    { id: 4, title: 'Refactoring', author: 'Martin Fowler', cover: 'https://images.unsplash.com/photo-1629992101753-56d196c8aabb?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGJvb2slMjBjb3ZlcnxlbnwwfHwwfHx8MA%3D%3D', rating: 4.6, borrowed: 28 }
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
