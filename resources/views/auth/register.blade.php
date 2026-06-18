<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Rice Berapi</title>
    <link rel="icon" href="{{ asset('assets/rice-icon.jpg') }}" type="image/jpeg">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
<!-- Back Button -->
<a href="/" class="fixed top-4 left-4 sm:top-6 sm:left-6 z-50 flex items-center space-x-2 text-gray-700 hover:text-red-800 transition bg-white px-3 py-2 rounded-lg shadow-md">
    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    <span class="font-medium text-sm sm:text-base">Kembali</span>
</a>

<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 pt-20 sm:pt-24">
    <!-- Main Card -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden my-8">
        <div class="flex flex-col md:flex-row">
            <!-- Left Side - Branding -->
            <div class="w-full md:w-5/12 bg-linear-to-br from-red-800 to-red-900 p-8 md:p-10 flex flex-col justify-center items-center text-white">
                <img src="{{ asset('assets/rice-icon.jpg') }}" alt="Rice Berapi" class="w-20 h-20 md:w-24 md:h-24 rounded-2xl mb-4 object-cover shadow-xl">
                <h1 class="text-3xl md:text-4xl font-bold mb-3">Rice Berapi</h1>
                <p class="text-sm md:text-base text-red-100 text-center">Bergabunglah dengan ribuan pelanggan yang sudah merasakan kelezatan nasi bakar kami</p>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full md:w-7/12 p-6 sm:p-8 md:p-10 overflow-y-auto" style="max-height: 90vh;">
                <!-- Header -->
                <div class="mb-5">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Daftar Akun</h2>
                    <p class="text-sm sm:text-base text-gray-600 mt-2">Bergabung sekarang</p>
                </div>

                <!-- Form Register -->
                <form action="/register" method="POST" class="space-y-3">
                    @csrf

                    <!-- Nama & Email (2 kolom di desktop) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 transition"
                                   placeholder="Nama lengkap"
                                   value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="email" id="email" required
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 transition"
                                   placeholder="nama@email.com"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon <span class="text-gray-400 text-xs">(Opsional)</span></label>
                        <input type="text" name="phone" id="phone"
                               class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 transition"
                               placeholder="08123456789"
                               value="{{ old('phone') }}">
                    </div>

                    <!-- Password & Konfirmasi (2 kolom di desktop) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <input type="password" name="password" id="password" required
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 transition"
                                   placeholder="Min. 6 karakter">
                            @error('password')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full px-3 py-2 sm:px-4 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 transition"
                                   placeholder="Ulangi password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-red-800 text-white font-semibold py-2.5 sm:py-3 px-4 text-sm sm:text-base rounded-lg hover:bg-red-900 hover:shadow-lg transition mt-4 cursor-pointer">
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-4 text-center">
                    <p class="text-sm sm:text-base text-gray-600">
                        Sudah punya akun? 
                        <a href="/login" class="text-red-800 hover:text-red-900 font-semibold cursor-pointer">Login di sini</a>
                    </p>
                </div>
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
