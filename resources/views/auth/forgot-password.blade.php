<x-guest-layout class="bg-gradient-to-br from-blue-50 via-light to-cyan-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div class="w-full space-y-4">
            <!-- Header -->
            <div class="text-center">
                <x-application-logo :sizeLogo="20" :sizeIcon="'3xl'"/>
                <h2 class="mt-4 text-3xl font-bold text-gray-900">
                    Lupa Password?
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
                </p>
            </div>

            <div class="flex md:flex-row flex-col gap-4 items-center md:items-start justify-center">

                            <!-- Forgot Password Form -->
                            <div class="bg-light rounded-2xl shadow-xl px-8 py-4 border border-lighthover">
                                <form class="space-y-4" action="{{ route('password.email') }}" method="POST" x-data="forgotPasswordForm()">
                                    @csrf

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-dark mb-2">
                                            <i class="fas fa-envelope mr-2 text-muted"></i>Email
                                        </label>
                                        <input
                                            id="email"
                                            name="email"
                                            type="email"
                                            required
                                            autocomplete="email"
                                            value="{{ old('email') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('email') border-danger @enderror"
                                            placeholder="Masukkan email Anda"
                                            x-model="form.email">
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div>
                                        <button
                                            type="submit"
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium bg-gradient-to-r from-primary to-primarylight hover:from-info hover:to-primarydark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primarylight transition-all duration-200 transform hover:scale-[1.02]  hover:text-light text-dark"
                                            x-bind:disabled="loading"
                                            x-bind:class="loading ? 'opacity-50 cursor-not-allowed' : ''"
                                            @click="loading = true">
                                            <span x-show="!loading" class="flex items-center">
                                                <i class="fas fa-paper-plane mr-2 "></i>
                                                Kirim Link Reset Password
                                            </span>
                                            <span x-show="loading" class="flex items-center">
                                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                                Mengirim...
                                            </span>
                                        </button>
                                    </div>

                                    <!-- Instructions -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-infodark">
                                                    Petunjuk Reset Password
                                                </h3>
                                                <div class="mt-2 text-sm text-blue-700">
                                                    <ul class="list-disc list-inside space-y-1">
                                                        <li>Masukkan email yang terdaftar di sistem</li>
                                                        <li>Periksa kotak masuk email Anda</li>
                                                        <li>Klik link yang dikirimkan untuk reset password</li>
                                                        <li>Buat password baru yang kuat</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Back to Login -->
                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-darkhover font-medium">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Kembali ke Halaman Login
                                        </a>
                                    </div>
                                </form>
                            </div>

                            <!-- Additional Help -->
                            <div class="bg-light max-w-md rounded-xl p-6 border border-gray-200">
                                <h3 class="text-sm font-medium text-gray-900 mb-2">
                                    <i class="fas fa-question-circle mr-2 text-light"></i>
                                    Butuh Bantuan?
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    Jika Anda tidak menerima email reset password, periksa folder spam atau hubungi administrator.
                                </p>
                                <div class="flex items-center space-x-4 text-sm">
                                    <a href="mailto:admin@perpustakaan.com" class="text-info hover:text-infodark flex items-center">
                                        <i class="fas fa-envelope mr-1"></i>
                                        admin@perpustakaan.com
                                    </a>
                                    <a href="tel:+6281234567890" class="text-green-600 hover:text-successdark flex items-center">
                                        <i class="fas fa-phone mr-1"></i>
                                        (021) 1234-5678
                                    </a>
                                </div>
                            </div>

            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-xs text-light">
                    © 2024 Sistem Perpustakaan. Semua hak dilindungi.
                </p>
            </div>
        </div>
    </div>

    <!-- Success/Error Toast -->
    @if(session('status'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 8000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="bg-successlight border-l-4 border-success text-green-700 p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('status') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button @click="show = false" class="text-muted hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 8000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="bg-red-100 border-l-4 border-danger text-dangerdark p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-danger"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ $errors->first() }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button @click="show = false" class="text-muted hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function forgotPasswordForm() {
            return {
                form: {
                    email: ''
                },
                loading: false,

                init() {
                    // Auto focus on email field
                    this.$nextTick(() => {
                        document.getElementById('email').focus();
                    });
                }
            }
        }
    </script>
</x-guest-layout>
