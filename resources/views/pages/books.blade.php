@extends('layout')
@section('content')
    <!-- Content -->
    <div x-data="bookApp()">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="shadow-lg shadow-lighthover bg-gradient-to-r from-cyan-50 from-40% to-cyan-200 to-100% p-6 rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium">Total Buku</h3>
                        <p class="text-3xl font-bold text-gray-900">1,234</p>
                    </div>
                    <div class="w-12 h-12 bg-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="shadow-lg shadow-lighthover bg-gradient-to-r from-green-50 from-40% to-green-200 to-100% p-6 rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium">Tersedia</h3>
                        <p class="text-3xl font-bold text-gray-900">892</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
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
                        <i class="fas fa-book-reader text-white text-xl"></i>
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
                        <i class="fas fa-tags text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white rounded-lg shadow-sm border mb-6">
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="showForm = true; editMode = false; resetForm()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Buku</span>
                    </button>
                    <select class="border border-gray-300 rounded-lg px-3 py-2" x-model="selectedCategory">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select class="border border-gray-300 rounded-lg px-3 py-2" x-model="sortBy">
                        <option value="title">Urutkan: Judul</option>
                        <option value="author">Urutkan: Pengarang</option>
                        <option value="year">Urutkan: Tahun</option>
                        <option value="stock">Urutkan: Stok</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600 text-sm">Total: <span class="font-semibold"
                            x-text="filteredBooks.length"></span> buku</span>
                </div>
            </div>
        </div>

        <!-- Books Table -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rating</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="book in paginatedBooks" :key="book.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div
                                        class="w-12 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                        <img :src="book.cover_image || '/api/placeholder/48/64'" :alt="book.title"
                                            class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <div class="text-sm font-medium text-gray-900 truncate" x-text="book.title"></div>
                                        <div class="text-sm text-gray-500 truncate" x-text="book.author"></div>
                                        <div class="text-xs text-gray-400" x-text="book.publisher + ' • ' + book.year">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                        x-text="book.category.name"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900" x-text="book.stock"></span>
                                        <span class="text-xs text-gray-500">unit</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-1">
                                        <div class="flex text-yellow-400">
                                            <template x-for="i in 5">
                                                <i class="fas fa-star text-xs"
                                                    :class="i <= book.rating ? 'text-yellow-400' : 'text-gray-300'"></i>
                                            </template>
                                        </div>
                                        <span class="text-xs text-gray-500" x-text="book.rating + '/5'"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button @click="viewBook(book)"
                                            class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button @click="editBook(book)"
                                            class="text-green-600 hover:text-green-900 p-1 rounded transition-colors"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="deleteBook(book)"
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
                    <span x-text="Math.min(currentPage * itemsPerPage, filteredBooks.length)"></span> dari
                    <span x-text="filteredBooks.length"></span> buku
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

        <!-- Add/Edit Book Modal -->
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
                                    x-text="editMode ? 'Edit Buku' : 'Tambah Buku Baru'"></h3>
                                <button type="button" @click="showForm = false" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Buku *</label>
                                    <input type="text" x-model="form.title"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukkan judul buku" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pengarang *</label>
                                    <input type="text" x-model="form.author"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Nama pengarang" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Penerbit *</label>
                                    <input type="text" x-model="form.publisher"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Nama penerbit" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Terbit *</label>
                                    <input type="number" x-model="form.year"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="2024" min="1900" max="2030" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                                    <input type="text" x-model="form.isbn"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="978-0-123456-78-9">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                                    <select x-model="form.category_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="1">Teknologi</option>
                                        <option value="2">Bisnis</option>
                                        <option value="3">Fiksi</option>
                                        <option value="4">Sejarah</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok *</label>
                                    <input type="number" x-model="form.stock"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="10" min="0" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cover Buku</label>
                                    <input type="file" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                <span x-text="editMode ? 'Update Buku' : 'Simpan Buku'"></span>
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
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Detail Buku</h3>
                            <button type="button" @click="showDetail = false" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-show="selectedBook">
                            <div class="md:col-span-1">
                                <div class="w-full h-64 bg-gray-200 rounded-lg overflow-hidden">
                                    <img :src="selectedBook?.cover_image || '/api/placeholder/200/300'"
                                        :alt="selectedBook?.title" class="w-full h-full object-cover">
                                </div>
                            </div>

                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900" x-text="selectedBook?.title"></h4>
                                    <p class="text-gray-600" x-text="'oleh ' + selectedBook?.author"></p>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700">Penerbit:</span>
                                        <p class="text-gray-600" x-text="selectedBook?.publisher"></p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Tahun:</span>
                                        <p class="text-gray-600" x-text="selectedBook?.year"></p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">ISBN:</span>
                                        <p class="text-gray-600" x-text="selectedBook?.isbn || '-'"></p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Stok:</span>
                                        <p class="text-gray-600" x-text="selectedBook?.stock + ' unit'"></p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Kategori:</span>
                                        <p class="text-gray-600" x-text="selectedBook?.category"></p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Rating:</span>
                                        <div class="flex items-center space-x-1">
                                            <div class="flex text-yellow-400">
                                                <template x-for="i in 5">
                                                    <i class="fas fa-star text-sm"
                                                        :class="i <= selectedBook?.rating ? 'text-yellow-400' : 'text-gray-300'"></i>
                                                </template>
                                            </div>
                                            <span class="text-sm text-gray-600" x-text="selectedBook?.rating + '/5'"></span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">Deskripsi:</span>
                                    <p class="text-gray-600 mt-1"
                                        x-text="selectedBook?.description || 'Tidak ada deskripsi'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-end space-x-3">
                        <button type="button" @click="showDetail = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Tutup
                        </button>
                        <button type="button" @click="editBook(selectedBook); showDetail = false"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                            Edit Buku
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
                                <h3 class="text-lg font-medium text-gray-900">Hapus Buku</h3>
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus buku ini?</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg" x-show="bookToDelete">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-12 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img :src="bookToDelete?.cover_image || '/api/placeholder/48/64'"
                                        :alt="bookToDelete?.title" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900" x-text="bookToDelete?.title"></p>
                                    <p class="text-sm text-gray-500" x-text="bookToDelete?.author"></p>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-gray-500 mt-4">Data buku yang dihapus tidak dapat dikembalikan. Pastikan
                            tidak ada transaksi yang sedang berlangsung untuk buku ini.</p>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-end space-x-3">
                        <button type="button" @click="showDeleteConfirm = false; bookToDelete = null"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="button" @click="confirmDelete()"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700">
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
        function bookApp() {
            return {
                // Data
                books: @json($books),

                    // UI State
                showForm: false,
                showDetail: false,
                showDeleteConfirm: false,
                editMode: false,
                selectedBook: null,
                bookToDelete: null,

                // Form Data
                form: {
                    id: null,
                    title: '',
                    author: '',
                    publisher: '',
                    year: new Date().getFullYear(),
                    isbn: '',
                    description: '',
                    category_id: '',
                    stock: 1
                },

                // Filters & Search
                searchQuery: '',
                selectedCategory: '',
                sortBy: 'title',
                currentPage: 1,
                itemsPerPage: 5,

                // Toast
                toast: {
                    show: false,
                    message: '',
                    type: 'success' // success or error
                },

                // Computed Properties
                get filteredBooks() {
                    let filtered = this.books;

                    // Filter by search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(book =>
                            book.title.toLowerCase().includes(query) ||
                            book.author.toLowerCase().includes(query) ||
                            book.publisher.toLowerCase().includes(query)
                        );
                    }

                    // Filter by category
                    if (this.selectedCategory) {
                        filtered = filtered.filter(book => book.category_id == this.selectedCategory);
                    }

                    // Sort
                    filtered.sort((a, b) => {
                        switch (this.sortBy) {
                            case 'title':
                                return a.title.localeCompare(b.title);
                            case 'author':
                                return a.author.localeCompare(b.author);
                            case 'year':
                                return b.year - a.year;
                            case 'stock':
                                return b.stock - a.stock;
                            default:
                                return 0;
                        }
                    });

                    return filtered;
                },

                get paginatedBooks() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredBooks.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredBooks.length / this.itemsPerPage);
                },

                // Methods
                resetForm() {
                    this.form = {
                        id: null,
                        title: '',
                        author: '',
                        publisher: '',
                        year: new Date().getFullYear(),
                        isbn: '',
                        description: '',
                        category_id: '',
                        stock: 1
                    };
                },

                submitForm() {
                    if (this.editMode) {
                        this.updateBook();
                    } else {
                        this.addBook();
                    }
                },

                addBook() {
                    // Generate new ID
                    const newId = Math.max(...this.books.map(b => b.id)) + 1;

                    // Get category name
                    const categories = {
                        '1': 'Teknologi',
                        '2': 'Bisnis',
                        '3': 'Fiksi',
                        '4': 'Sejarah'
                    };

                    const newBook = {
                        id: newId,
                        ...this.form,
                        category: categories[this.form.category_id] || 'Lainnya',
                        cover_image: '/api/placeholder/200/300',
                        rating: 0
                    };

                    this.books.unshift(newBook);
                    this.showForm = false;
                    this.resetForm();
                    this.showToast('Buku berhasil ditambahkan!', 'success');
                },

                editBook(book) {
                    this.editMode = true;
                    this.form = { ...book };
                    this.showForm = true;
                },

                updateBook() {
                    const index = this.books.findIndex(book => book.id === this.form.id);
                    if (index !== -1) {
                        // Get category name
                        const categories = {
                            '1': 'Teknologi',
                            '2': 'Bisnis',
                            '3': 'Fiksi',
                            '4': 'Sejarah'
                        };

                        this.books[index] = {
                            ...this.books[index],
                            ...this.form,
                            category: categories[this.form.category_id] || 'Lainnya'
                        };

                        this.showForm = false;
                        this.resetForm();
                        this.editMode = false;
                        this.showToast('Buku berhasil diupdate!', 'success');
                    }
                },

                viewBook(book) {
                    this.selectedBook = book;
                    this.showDetail = true;
                },

                deleteBook(book) {
                    this.bookToDelete = book;
                    this.showDeleteConfirm = true;
                },

                confirmDelete() {
                    if (this.bookToDelete) {
                        const index = this.books.findIndex(book => book.id === this.bookToDelete.id);
                        if (index !== -1) {
                            this.books.splice(index, 1);
                            this.showToast('Buku berhasil dihapus!', 'success');
                        }
                    }
                    this.showDeleteConfirm = false;
                    this.bookToDelete = null;
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
        }
    </script>
@endsection
