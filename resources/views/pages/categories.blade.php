@extends('layout')
@section('content')
    <!-- Content -->
    <div x-data="categoryApp()">
        <!-- Action Bar -->
        <div class="bg-white rounded-lg shadow-sm border mb-6">
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="showForm = true; editMode = false; resetForm()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Kategori</span>
                    </button>
                    <select class="border border-gray-300 rounded-lg px-3 py-2" x-model="sortBy">
                        <option value="name">Urutkan: Nama</option>
                        <option value="books_count">Urutkan: Total Buku</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600 text-sm">Total: <span class="font-semibold"
                            x-text="filteredCategories.length"></span> kategori</span>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Buku</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="category in paginatedCategories" :key="category.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900" x-text="category.name"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900" x-text="limitWords(category.description, 10)"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900" x-text="category.books_count"></span>
                                        <span class="text-xs text-gray-500">buku</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button @click="viewCategory(category)"
                                            class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button @click="editCategory(category)"
                                            class="text-green-600 hover:text-green-900 p-1 rounded transition-colors"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="deleteCategory(category)"
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
            <div class="bg-white px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span x-text="(currentPage - 1) * itemsPerPage + 1"></span> sampai
                    <span x-text="Math.min(currentPage * itemsPerPage, filteredCategories.length)"></span> dari
                    <span x-text="filteredCategories.length"></span> buku
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="currentPage > 1 && currentPage--" :disabled="currentPage === 1"
                        class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Sebelumnya
                    </button>
                    <template x-for="page in totalPages" :key="page">
                        <button @click="currentPage = page"
                            :class="currentPage === page ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="px-3 py-1 text-sm border border-gray-300 rounded-md" x-text="page"></button>
                    </template>
                    <button @click="currentPage < totalPages && currentPage++" :disabled="currentPage === totalPages"
                        class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>

        <!-- Add/Edit Category Modal -->
        <div x-show="showForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form @submit.prevent="submitForm()">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900"
                                    x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori Baru'"></h3>
                                <button type="button" @click="showForm = false" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama *</label>
                                    <input type="text" x-model="form.name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukan nama kategori" required>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                    <textarea x-model="form.description" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Deskripsi singkat tentang buku..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-3 flex items-center justify-end space-x-3">
                            <button type="button" @click="showForm = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                                <span x-text="editMode ? 'Update Kategori' : 'Simpan Kategori'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Category Modal -->
        <div x-show="showDetail" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Detail Kategori</h3>
                            <button type="button" @click="showDetail = false" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-6" x-show="selectedCategory">
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900" x-text="selectedCategory?.name"></h4>
                                </div>

                                <div class="grid grid-flow-col auto-cols-max gap-8 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700">Nama:</span>
                                        <p class="text-gray-600" x-text="selectedCategory?.name"></p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Deskripsi:</span>
                                        <p class="text-gray-600" x-text="selectedCategory?.description"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-end space-x-3">
                        <button type="button" @click="showDetail = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Tutup
                        </button>
                        <button type="button" @click="editCategory(selectedCategory); showDetail = false"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                            Edit Kategori
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
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center mb-4">
                            <div
                                class="mx-0 flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Hapus Kategori</h3>
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus kategori ini?</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg" x-show="categoryToDelete">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p class="font-medium text-gray-900" x-text="categoryToDelete?.name"></p>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-gray-500 mt-4">Data kategori yang dihapus tidak dapat dikembalikan. Pastikan
                            tidak ada transaksi yang sedang berlangsung untuk kategori ini.</p>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-end space-x-3">
                        <button type="button" @click="showDeleteConfirm = false; categoryToDelete = null"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="button" @click="confirmDelete()"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700">
                            Hapus Kategori
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
            <div :class="toast.type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'"
                class="border-l-4 p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i
                            :class="toast.type === 'success' ? 'fas fa-check-circle text-green-500' : 'fas fa-exclamation-circle text-red-500'"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium" x-text="toast.message"></p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button @click="toast.show = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function categoryApp() {
            return {
                // Data
                categories: @json($categories),

                    // UI State
                showForm: false,
                showDetail: false,
                showDeleteConfirm: false,
                editMode: false,
                selectedCategory: null,
                categoryToDelete: null,

                // Form Data
                form: {
                    id: null,
                    name: '',
                    description: '',
                },

                // Filters & Search
                searchQuery: '',
                selectedCategory: '',
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
                get filteredCategories() {
                    let filtered = this.categories;

                    // Filter by search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(category =>
                            category.name.toLowerCase().includes(query) ||
                            category.books_count.includes(query)
                        );
                    }

                    // Sort
                    filtered.sort((a, b) => {
                        switch (this.sortBy) {
                            case 'name':
                                return a.name.localeCompare(b.name);
                            case 'books_count':
                                return a.books_count - b.books_count;
                            default:
                                return 0;
                        }
                    });

                    return filtered;
                },

                get paginatedCategories() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredCategories.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredCategories.length / this.itemsPerPage);
                },

                // Methods
                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        description: '',
                    };
                },

                submitForm() {
                    if (this.editMode) {
                        this.updateCategory();
                    } else {
                        this.addCategory();
                    }
                },

                addCategory() {
                    // Generate new ID
                    const newId = Math.max(...this.categories.map(b => b.id)) + 1;

                    const newCategory = {
                        id: newId,
                        ...this.form,
                    };

                    this.categories.unshift(newCategory);
                    this.showForm = false;
                    this.resetForm();
                    this.showToast('Kategori berhasil ditambahkan!', 'success');
                },

                editCategory(category) {
                    this.editMode = true;
                    this.form = { ...category };
                    this.showForm = true;
                },

                updateCategory() {
                    const index = this.categories.findIndex(category => category.id === this.form.id);
                    if (index !== -1) {

                        this.categories[index] = {
                            ...this.categories[index],
                            ...this.form,
                            category: categories[this.form.category_id] || 'Lainnya'
                        };

                        this.showForm = false;
                        this.resetForm();
                        this.editMode = false;
                        this.showToast('Kategori berhasil diupdate!', 'success');
                    }
                },

                viewCategory(category) {
                    this.selectedCategory = category;
                    this.showDetail = true;
                },

                deleteCategory(category) {
                    this.categoryToDelete = category;
                    this.showDeleteConfirm = true;
                },

                confirmDelete() {
                    if (this.categoryToDelete) {
                        const index = this.categories.findIndex(category => category.id === this.categoryToDelete.id);
                        if (index !== -1) {
                            this.categories.splice(index, 1);
                            this.showToast('Kategori berhasil dihapus!', 'success');
                        }
                    }
                    this.showDeleteConfirm = false;
                    this.categoryToDelete = null;
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
                    this.$watch('selectedCategory', () => this.currentPage = 1);
                    this.$watch('sortBy', () => this.currentPage = 1);
                }
            }
        };

        function limitWords(text, limit) {
            const words = text.split(' ');
            return words.length > limit ? words.slice(0, limit).join(' ') + '...' : text;
        }
    </script>
@endsection
