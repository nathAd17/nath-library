@extends('layout')
@section('content')
    <!-- Content -->
    <div x-data="anggotaApp()">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="shadow-lg shadow-lighthover bg-gradient-to-r from-cyan-50 from-40% to-cyan-200 to-100% p-6 rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium">Total Pengguna</h3>
                        <p class="text-3xl font-bold text-gray-900">1,234</p>
                    </div>
                    <div class="w-12 h-12 bg-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-light text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="shadow-lg shadow-lighthover bg-gradient-to-r from-green-50 from-40% to-green-200 to-100% p-6 rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium">Anggota</h3>
                        <p class="text-3xl font-bold text-gray-900">892</p>
                    </div>
                    <div class="w-12 h-12 bg-success rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-light text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="shadow-lg shadow-lighthover bg-gradient-to-r from-purple-50 from-40% to-purple-200 to-100% p-6 rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium">Dipinjam</h3>
                        <p class="text-3xl font-bold text-gray-900">342</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-reader text-light text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="shadow-lg shadow-lighthover bg-gradient-to-r from-orange-50 from-40% to-orange-200 to-100% p-6 rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium">Kategori</h3>
                        <p class="text-3xl font-bold text-gray-900">28</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-light text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-light rounded-lg shadow-sm border mb-6">
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="showForm = true; editMode = false; resetForm()"
                        class="bg-info text-light px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Pengguna</span>
                    </button>
                    <select class="border border-gray-300 rounded-lg px-3 py-2" x-model="selectedRole">
                        <option value="">Semua Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role}}">{{ $role}}</option>
                        @endforeach
                    </select>
                    <select class="border border-gray-300 rounded-lg px-3 py-2" x-model="sortBy">
                        <option value="name">Urutkan: Nama</option>
                        <option value="role">Urutkan: Role</option>
                        <option value="total_points">Urutkan: Total points</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600 text-sm">Total: <span class="font-semibold"
                            x-text="filteredUsers.length"></span> Pengguna</span>
                </div>
            </div>
        </div>

        <!-- Books Table -->
        <div class="bg-light rounded-lg shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-light uppercase tracking-wider">Gambar
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-light uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-light uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-light uppercase tracking-wider">Total points
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-light uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-light divide-y divide-gray-200">
                        <template x-for="user in paginatedUsers" :key="user.id">
                            <tr class="hover:bg-light">
                                <td class="px-6 py-4 lightspace-nowrap">
                                    <div
                                        class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                        <img :src="`https://ui-avatars.com/api/?name=${user.name}&background=3B82F6&color=fff`" :alt="user.name"
                                            class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <div class="text-sm font-medium text-gray-900 truncate" x-text="user.name"></div>
                                        <div class="text-xs text-muted" x-text="user.email">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 lightspace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-infodark"
                                        x-text="user.role"></span>
                                </td>
                                <td class="px-6 py-4 lightspace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900" x-text="user.total_points"></span>
                                        <span class="text-xs text-light">pts</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 lightspace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button @click="viewUser(user)"
                                            class="text-info hover:text-blue-900 p-1 rounded transition-colors"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button @click="editUser(user)"
                                            class="text-green-600 hover:text-green-900 p-1 rounded transition-colors"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="deleteUser(user)"
                                            class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-light px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-dark">
                    Menampilkan <span x-text="(currentPage - 1) * itemsPerPage + 1"></span> sampai
                    <span x-text="Math.min(currentPage * itemsPerPage, filteredUsers.length)"></span> dari
                    <span x-text="filteredUsers.length"></span> buku
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="currentPage > 1 && currentPage--" :disabled="currentPage === 1"
                        class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-light disabled:opacity-50 disabled:cursor-not-allowed">
                        Sebelumnya
                    </button>
                    <template x-for="page in totalPages" :key="page">
                        <button @click="currentPage = page"
                            :class="currentPage === page ? 'bg-info text-light' : 'text-dark hover:bg-light'"
                            class="px-3 py-1 text-sm border border-gray-300 rounded-md" x-text="page"></button>
                    </template>
                    <button @click="currentPage < totalPages && currentPage++" :disabled="currentPage === totalPages"
                        class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-light disabled:opacity-50 disabled:cursor-not-allowed">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>

        <!-- Add/Edit Book Modal -->
        <div x-show="showForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-light bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form @submit.prevent="submitForm()">
                        <div class="bg-light px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900"
                                    x-text="editMode ? 'Edit User' : 'Tambah User Baru'"></h3>
                                <button type="button" @click="showForm = false" class="text-muted hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-dark mb-2">Nama *</label>
                                    <input type="text" x-model="form.name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukkan nama pengguna" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-dark mb-2">Email *</label>
                                    <input type="text" x-model="form.email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukan email pengguna" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-dark mb-2">Role *</label>
                                    <select x-model="form.role"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="admin">Admin</option>
                                        <option value="anggota">Anggota</option>
                                        <option value="pustakawan">Pustakawan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-6 py-3 flex items-center justify-end space-x-3">
                            <button type="button" @click="showForm = false"
                                class="px-4 py-2 text-sm font-medium text-dark bg-light border border-gray-300 rounded-lg hover:bg-light">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-light bg-info border border-transparent rounded-lg hover:bg-blue-700">
                                <span x-text="editMode ? 'Update User' : 'Simpan User'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Book Modal -->
        <div x-show="showDetail" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-light bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-light px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Detail Pengguna</h3>
                            <button type="button" @click="showDetail = false" class="text-muted hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-show="selectedUser">
                            <div class="md:col-span-1">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden">
                                    <img :src="`https://ui-avatars.com/api/?name=${selectedUser?.name}&background=3B82F6&color=fff`"
                                        :alt="selectedUser?.name" class="w-full h-full object-cover">
                                </div>
                            </div>

                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900" x-text="selectedUser?.name"></h4>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-dark">Email:</span>
                                        <p class="text-gray-600" x-text="selectedUser?.email"></p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-dark">Role:</span>
                                        <p class="text-gray-600" x-text="selectedUser?.role"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light px-6 py-3 flex items-center justify-end space-x-3">
                        <button type="button" @click="showDetail = false"
                            class="px-4 py-2 text-sm font-medium text-dark bg-light border border-gray-300 rounded-lg hover:bg-light">
                            Tutup
                        </button>
                        <button type="button" @click="editUser(selectedUser); showDetail = false"
                            class="px-4 py-2 text-sm font-medium text-light bg-info border border-transparent rounded-lg hover:bg-blue-700">
                            Edit Pengguna
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteConfirm" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-light bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-light px-6 pt-6 pb-4">
                        <div class="flex items-center mb-4">
                            <div
                                class="mx-0 flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Hapus Buku</h3>
                                <p class="text-sm text-light">Apakah Anda yakin ingin menghapus buku ini?</p>
                            </div>
                        </div>

                        <div class="bg-light p-4 rounded-lg" x-show="userToDelete">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-12 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img :src="userToDelete?.cover_image || '/api/placeholder/48/64'"
                                        :alt="userToDelete?.title" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900" x-text="userToDelete?.title"></p>
                                    <p class="text-sm text-light" x-text="userToDelete?.author"></p>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-light mt-4">Data buku yang dihapus tidak dapat dikembalikan. Pastikan
                            tidak ada transaksi yang sedang berlangsung untuk buku ini.</p>
                    </div>

                    <div class="bg-light px-6 py-3 flex items-center justify-end space-x-3">
                        <button type="button" @click="showDeleteConfirm = false; userToDelete = null"
                            class="px-4 py-2 text-sm font-medium text-dark bg-light border border-gray-300 rounded-lg hover:bg-light">
                            Batal
                        </button>
                        <button type="button" @click="confirmDelete()"
                            class="px-4 py-2 text-sm font-medium text-light bg-red-600 border border-transparent rounded-lg hover:bg-dangerdark">
                            Hapus Buku
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Toast -->
        <div x-show="toast.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed top-4 right-4 z-50 max-w-sm w-full"
            style="display: none;">
            <div :class="toast.type === 'success' ? 'bg-successlight border-success text-green-700' : 'bg-red-100 border-danger text-dangerdark'"
                class="border-l-4 p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i
                            :class="toast.type === 'success' ? 'fas fa-check-circle text-success' : 'fas fa-exclamation-circle text-danger'"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium" x-text="toast.message"></p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button @click="toast.show = false" class="text-muted hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function anggotaApp() {
            return {
                // Data
                users: @json($members),

                    // UI State
                showForm: false,
                showDetail: false,
                showDeleteConfirm: false,
                editMode: false,
                selectedUser: null,
                userToDelete: null,

                // Form Data
                form: {
                    id: null,
                    name: '',
                    email: '',
                    role: '',
                    total_points: '',
                },

                // Filters & Search
                searchQuery: '',
                selectedRole: '',
                sortBy: 'name',
                currentPage: 1,
                itemsPerPage: 5,

                // Toast
                toast: {
                    show: false,
                    message: '',
                    type: 'success' // success or error
                },

                // Computed Properties
                get filteredUsers() {
                    let filtered = this.users;

                    // Filter by search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(user =>
                            user.name.toLowerCase().includes(query) ||
                            user.email.toLowerCase().includes(query) ||
                            user.role.toLowerCase().includes(query)
                        );
                    }

                    // Filter by role
                    if (this.selectedRole) {
                        filtered = filtered.filter(user => user.role == this.selectedRole);
                    }

                    // Sort
                    filtered.sort((a, b) => {
                        switch (this.sortBy) {
                            case 'name':
                                return a.name.localeCompare(b.name);
                            case 'email':
                                return a.email.localeCompare(b.email);
                            case 'role':
                                return a.role.localeCompare(b.role);
                            default:
                                return 0;
                        }
                    });

                    return filtered;
                },

                get paginatedUsers() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredUsers.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredUsers.length / this.itemsPerPage);
                },

                // Methods
                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        email: '',
                        role: '',
                        total_points: '',
                    };
                },

                submitForm() {
                    if (this.editMode) {
                        this.updateUser();
                    } else {
                        this.addUser();
                    }
                },

                addUser() {
                    // Generate new ID
                    const newId = Math.max(...this.users.map(b => b.id)) + 1;

                    // Get role name
                    const roles = {
                        '1': 'admin',
                        '2': 'anggota',
                        '3': 'pustakawan',
                    };

                    const newUser = {
                        id: newId,
                        ...this.form,
                    };

                    this.users.unshift(newUser);
                    this.showForm = false;
                    this.resetForm();
                    this.showToast('User berhasil ditambahkan!', 'success');
                },

                editUser(user) {
                    this.editMode = true;
                    this.form = { ...user };
                    this.showForm = true;
                },

                updateUser() {
                    const index = this.users.findIndex(user => user.id === this.form.id);
                    if (index !== -1) {
                        // Get role name
                        const roles = {
                        '1': 'admin',
                        '2': 'anggota',
                        '3': 'pustakawan',
                    };

                        this.users[index] = {
                            ...this.users[index],
                            ...this.form,
                            role: roles[this.form.role] || 'Lainnya'
                        };

                        this.showForm = false;
                        this.resetForm();
                        this.editMode = false;
                        this.showToast('User berhasil diupdate!', 'success');
                    }
                },

                viewUser(user) {
                    this.selectedUser = user;
                    this.showDetail = true;
                },

                deleteUser(user) {
                    this.userToDelete = user;
                    this.showDeleteConfirm = true;
                },

                confirmDelete() {
                    if (this.userToDelete) {
                        const index = this.users.findIndex(user => user.id === this.userToDelete.id);
                        if (index !== -1) {
                            this.users.splice(index, 1);
                            this.showToast('User berhasil dihapus!', 'success');
                        }
                    }
                    this.showDeleteConfirm = false;
                    this.userToDelete = null;
                },

                showToast(message, type = 'success') {
                    this.toast.message = message;
                    this.toast.type = type;
                    this.toast.show = true;

                    setTimeout(() => {
                        this.toast.show = false;
                    }, 3000);
                },

                // Initialize
                init() {
                    // Watch for filter changes to reset pagination
                    this.$watch('searchQuery', () => this.currentPage = 1);
                    this.$watch('selectedRole', () => this.currentPage = 1);
                    this.$watch('sortBy', () => this.currentPage = 1);
                }
            }
        }
    </script>
@endsection
