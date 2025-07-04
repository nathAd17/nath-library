
<x-guest-layout class="min-h-screen bg-gradient-to-br from-cyan-50 via-light to-emerald-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <x-application-logo :sizeLogo="20" :sizeIcon="'3xl'"/>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun</h2>
                <p class="text-gray-600">Bergabunglah dengan Sistem Perpustakaan</p>
            </div>

            <!-- Register Form -->
            <div class="bg-light rounded-2xl shadow-xl p-8 border border-lighthover" x-data="registerForm()">
                <form @submit.prevent="submitRegister" action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST')
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-dark mb-2">
                            <i class="fas fa-user text-muted mr-2"></i>Nama Lengkap
                        </label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            required
                            x-model="form.name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                            :class="errors.name ? 'border-red-300 focus:ring-danger focus:border-danger' : ''"
                            placeholder="Masukkan nama lengkap">
                        <p x-show="errors.name" x-text="errors.name" class="mt-1 text-sm text-red-600"></p>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-dark mb-2">
                            <i class="fas fa-envelope text-muted mr-2"></i>Email
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            x-model="form.email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                            :class="errors.email ? 'border-red-300 focus:ring-danger focus:border-danger' : ''"
                            placeholder="Masukkan email Anda">
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
                                autocomplete="new-password"
                                required
                                x-model="form.password"
                                @input="checkPasswordStrength"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                :class="errors.password ? 'border-red-300 focus:ring-danger focus:border-danger' : ''"
                                placeholder="Minimal 8 karakter">
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-muted hover:text-gray-600"></i>
                            </button>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div x-show="form.password" class="mt-2">
                            <div class="flex space-x-1 mb-1">
                                <div class="h-1 flex-1 rounded" :class="passwordStrength >= 1 ? 'bg-danger' : 'bg-gray-200'"></div>
                                <div class="h-1 flex-1 rounded" :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                                <div class="h-1 flex-1 rounded" :class="passwordStrength >= 3 ? 'bg-cyan-500' : 'bg-gray-200'"></div>
                            </div>
                            <p class="text-xs" :class="passwordStrength >= 3 ? 'text-primary' : passwordStrength >= 2 ? 'text-yellow-600' : 'text-red-600'">
                                <span x-text="passwordStrengthText"></span>
                            </p>
                        </div>

                        <p x-show="errors.password" x-text="errors.password" class="mt-1 text-sm text-red-600"></p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-dark mb-2">
                            <i class="fas fa-lock text-muted mr-2"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                autocomplete="new-password"
                                required
                                x-model="form.password_confirmation"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                :class="!passwordsMatch && form.password_confirmation ? 'border-red-300 focus:ring-danger focus:border-danger' : ''"
                                placeholder="Ulangi password Anda">
                            <button
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-muted hover:text-gray-600"></i>
                            </button>
                        </div>
                        <p x-show="!passwordsMatch && form.password_confirmation" class="mt-1 text-sm text-red-600">
                            Password tidak cocok
                        </p>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input
                            id="terms"
                            name="terms"
                            type="checkbox"
                            required
                            x-model="form.terms"
                            class="h-4 w-4 text-primary focus:ring-cyan-500 border-gray-300 rounded mt-1">
                        <label for="terms" class="ml-2 block text-sm text-dark">
                            Saya menyetujui
                            <a href="#" class="text-primary hover:text-cyan-500 font-medium">Syarat & Ketentuan</a>
                            dan
                            <a href="#" class="text-primary hover:text-cyan-500 font-medium">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="loading || !form.terms || !passwordsMatch"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-light bg-gradient-to-r from-primary to-primarydark hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading">
                            <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                        </span>
                        <span x-show="loading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mendaftarkan...
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
                            <span class="px-2 bg-light text-light">Sudah punya akun?</span>
                        </div>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-info hover:text-infodark font-medium">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk di sini
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-light">
                    © 2024 Sistem Perpustakaan. Semua hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>

    <!-- Error/Success Toast -->
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
        function registerForm() {
            return {
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    role: '',
                    password: '',
                    password_confirmation: '',
                    terms: false
                },
                showPassword: false,
                showConfirmPassword: false,
                loading: false,
                errors: {},
                passwordStrength: 0,
                passwordStrengthText: '',

                get passwordsMatch() {
                    return this.form.password === this.form.password_confirmation;
                },

                checkPasswordStrength() {
                    const password = this.form.password;
                    let strength = 0;
                    let text = '';

                    if (password.length >= 8) strength++;
                    if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength++;
                    if (/\d/.test(password) && /[!@#$%^&*]/.test(password)) strength++;

                    switch (strength) {
                        case 1:
                            text = 'Password lemah';
                            break;
                        case 2:
                            text = 'Password sedang';
                            break;
                        case 3:
                            text = 'Password kuat';
                            break;
                        default:
                            text = 'Password terlalu pendek';
                    }

                    this.passwordStrength = strength;
                    this.passwordStrengthText = text;
                },

                async submitRegister() {
                    this.loading = true;
                    this.errors = {};

                    try {
                        // Submit form menggunakan Laravel
                        this.$el.submit();
                    } catch (error) {
                        this.loading = false;
                        console.error('Register error:', error);
                    }
                }
            }
        }
    </script>
</x-guest-layout>
