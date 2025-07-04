<x-guest-layout class="min-h-screen bg-gradient-to-br from-blue-50 via-light to-cyan-50">
    <div class="min-h-screen flex items-center justify-center p-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-4">
            <!-- Header -->
            <div class="text-center">
                <x-application-logo :sizeLogo="20" :sizeIcon="'3xl'"/>
            </div>

            <!-- Login Form -->
            <div class="bg-light rounded-2xl shadow-xl py-4 px-6 border border-lighthover" x-data="loginForm()">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form @submit.prevent="submitLogin" action="{{ route('login') }}" method="post" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-dark mb-2">
                            <i class="fas fa-envelope text-muted mr-2"></i>Email
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                x-model="form.email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                :class="errors.email ? 'border-red-300 focus:ring-danger focus:border-danger' : ''"
                                placeholder="Masukkan email Anda">
                        </div>
                        <p x-show="errors.email" x-text="errors.email" class="mt-1 text-sm text-red-600"></p>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-dark mb-2">
                            <i class="fas fa-lock text-muted mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                required
                                x-model="form.password"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                :class="errors.password ? 'border-red-300 focus:ring-danger focus:border-danger' : ''"
                                placeholder="Masukkan password Anda">
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-dark hover:text-gray-600"></i>
                            </button>
                        </div>
                        <p x-show="errors.password" x-text="errors.password" class="mt-1 text-sm text-red-600"></p>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember_me"
                                name="remember_me"
                                type="checkbox"
                                x-model="form.remember"
                                class="h-4 w-4 text-info focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-dark">
                                Ingat saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-info hover:text-blue-500 font-medium">
                            Lupa password?
                        </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-light bg-gradient-to-r from-info to-primary hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </span>
                        <span x-show="loading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-light text-dark">Belum punya akun?</span>
                        </div>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('register') }}" class="inline-flex items-center text-info hover:text-blue-500 font-medium">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar sekarang
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-dark">
                    © 2024 Sistem Perpustakaan. Semua hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>

    <!-- Error Toast -->
    @if(session('error') || $errors->any())
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="bg-red-100 border-l-4 border-danger text-dangerdark p-4 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-danger"></i>
                    </div>
                    <div class="ml-3">
                        @if(session('error'))
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        @endif
                        @if($errors->any())
                            <p class="text-sm font-medium">{{ $errors->first() }}</p>
                        @endif
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
        function loginForm() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false,
                },
                showPassword: false,
                loading: false,
                errors: {},

                async submitLogin() {
                    this.loading = true;
                    this.errors = {};

                    try {
                        // Submit form menggunakan fetch API atau biarkan form submit normal
                        // Untuk Laravel, biarkan form submit normal
                        this.$el.submit();
                    } catch (error) {
                        this.loading = false;
                        console.error('Login error:', error);
                    }
                },

                init() {
                    // Auto focus pada email field
                    this.$nextTick(() => {
                        this.$refs.emailInput?.focus();
                    });
                }
            }
        }
    </script>
</x-guest-layout>
