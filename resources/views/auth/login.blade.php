<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rice Berapi</title>
    <link rel="icon" href="{{ asset('assets/rice-icon.jpg') }}" type="image/jpeg">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
<!-- Back Button -->
<a href="/" class="fixed top-4 left-4 sm:top-6 sm:left-6 z-50 flex items-center space-x-2 text-gray-700  px-3 py-2 rounded-lg shadow-md">
    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    <span class="font-medium text-sm sm:text-base">Kembali</span>
</a>

<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 pt-20 sm:pt-24">
    <!-- Main Card -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Left Side - Branding -->
            <div class="w-full md:w-5/12 bg-linear-to-br from-red-800 to-red-900 p-8 md:p-10 flex flex-col justify-center items-center text-white">
                <img src="{{ asset('assets/rice-icon.jpg') }}" alt="Rice Berapi" class="w-20 h-20 md:w-24 md:h-24 rounded-2xl mb-4 object-cover shadow-xl">
                <h1 class="text-3xl md:text-4xl font-bold mb-3">Rice Berapi</h1>
                <p class="text-sm md:text-base text-red-100 text-center">UMKM Nasi Bakar dengan berbagai varian rasa yang lezat dan berkualitas</p>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full md:w-7/12 p-6 sm:p-8 md:p-10">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Selamat Datang!</h2>
                    <p class="text-sm sm:text-base text-gray-600 mt-2">Login untuk melanjutkan</p>
                </div>

                <!-- Info Alert -->
                @if(request('redirect') == 'order')
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">Login Diperlukan</p>
                            <p class="text-sm text-yellow-700 mt-1">Silakan login terlebih dahulu untuk melakukan pemesanan produk</p>
                        </div>
                    </div>
                </div>
                @elseif(request('redirect') == 'detail')
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Login Diperlukan</p>
                            <p class="text-sm text-blue-700 mt-1">Silakan login terlebih dahulu untuk melihat detail produk</p>
                        </div>
                    </div>
                </div>
                @elseif(request('redirect') == 'menu')
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Login Diperlukan</p>
                            <p class="text-sm text-blue-700 mt-1">Silakan login terlebih dahulu untuk melihat katalog menu lengkap</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form Login -->
                <form action="/login" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-3 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 transition"
                               placeholder="nama@email.com"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-3 py-2.5 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 transition"
                               placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-red-800 text-white font-semibold py-2.5 sm:py-3 px-4 text-sm sm:text-base rounded-lg hover:bg-red-900 hover:shadow-lg transition cursor-pointer">
                        Login
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-5 text-center">
                    <p class="text-sm sm:text-base text-gray-600">
                        Belum punya akun? 
                        <a href="/register" class="text-red-800 hover:text-red-900 font-semibold cursor-pointer">Daftar sekarang</a>
                    </p>
                </div>

                {{-- <!-- Demo Accounts -->
                <div class="mt-5 pt-5 border-t border-gray-200">
                    <p class="text-xs sm:text-sm text-gray-500 text-center mb-3">Demo Account:</p>
                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                        <div class="bg-gray-50 rounded-lg p-2 sm:p-3 text-center border border-gray-200">
                            <p class="text-xs text-gray-500 font-semibold mb-1">Admin</p>
                            <p class="text-xs text-gray-600 break-all">admin@riceberapi.com</p>
                            <p class="text-xs text-gray-600">admin123</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2 sm:p-3 text-center border border-gray-200">
                            <p class="text-xs text-gray-500 font-semibold mb-1">Customer</p>
                            <p class="text-xs text-gray-600">andi@test.com</p>
                            <p class="text-xs text-gray-600">customer123</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg z-50" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg z-50" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<script>
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
</body>
</html>
