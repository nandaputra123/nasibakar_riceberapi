<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Rice Berapi - UMKM Nasi Bakar Terbaik">
    <title>Rice Berapi</title>
    <link rel="icon" href="{{ asset('assets/rice-icon.jpg') }}" type="image/jpeg">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- <!-- Custom Tailwind Config untuk warna merah tua -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8B0000',    // Merah tua (Dark Red)
                        secondary: '#DC143C',  // Merah Crimson
                    }
                }
            }
        }
    </script> --}}

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Scroll margin untuk section agar tidak tertutup navbar */
        section[id] {
            scroll-margin-top: 80px;
        }

        /* Smooth scroll behavior untuk HTML */
        html {
            scroll-behavior: smooth;
        }

        /* Carousel transitions */
        .carousel-slide {
            transition: opacity 1s ease-in-out;
        }

        .carousel-slide.active {
            opacity: 1 !important;
        }

        .carousel-dot {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .carousel-dot.active {
            width: 2rem;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-3 md:px-4">
            <div class="flex justify-between items-center py-3 md:py-4">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2 md:space-x-3">
                    <img src="{{ asset('assets/rice-icon.jpg') }}" alt="Rice Berapi"
                        class="w-10 h-10 md:w-12 md:h-12 rounded-lg object-cover">
                    <span class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800">Rice <span
                            class="text-red-800">Berapi</span></span>
                </a>

                <!-- Menu Desktop/Tablet -->
                <div class="hidden md:flex items-center space-x-3 lg:space-x-6 xl:space-x-8">
                    @if(session('user_id'))
                        <a href="/"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base">Beranda</a>
                        <a href="/menu"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base">Menu</a>
                        <a href="/orders"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base">Pesanan</a>
                        <a href="/reviews"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base">Review</a>
                    @else
                        <a href="/#beranda"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base smooth-scroll">Beranda</a>
                        <a href="/#tentang"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base smooth-scroll">Tentang
                            Kami</a>
                        <a href="/#menu"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base smooth-scroll">Menu</a>
                        <a href="/#review"
                            class="text-gray-700 hover:text-red-800 transition font-medium text-sm lg:text-base smooth-scroll">Reviews</a>
                    @endif
                </div>

                <!-- User Menu Desktop/Tablet -->
                <div class="hidden md:flex items-center space-x-2 lg:space-x-3 xl:space-x-4">
                    @if(session('user_id'))
                        <div class="flex items-center space-x-2 lg:space-x-3 xl:space-x-4">
                            <!-- Notifikasi Icon -->
                            <a href="/notifications"
                                class="text-gray-700 hover:text-red-800 transition relative p-1.5 lg:p-2"
                                title="Notifikasi">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @php
                                    $unreadCount = \App\Models\Notification::where('user_id', session('user_id'))->where('is_read', false)->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span
                                        class="absolute top-0 right-0 bg-red-800 text-white text-xs rounded-full w-4 h-4 lg:w-5 lg:h-5 flex items-center justify-center font-semibold text-[10px] lg:text-xs">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                @endif
                            </a>

                            <!-- Keranjang Icon -->
                            <a href="/cart" class="text-gray-700 hover:text-red-800 transition relative p-1.5 lg:p-2"
                                title="Keranjang">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                @php
                                    $cartCount = \App\Models\Cart::where('user_id', session('user_id'))->count();
                                @endphp
                                @if($cartCount > 0)
                                    <span
                                        class="absolute top-0 right-0 bg-red-800 text-white text-xs rounded-full w-4 h-4 lg:w-5 lg:h-5 flex items-center justify-center font-semibold text-[10px] lg:text-xs">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                                @endif
                            </a>

                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button id="profileDropdownBtn"
                                    class="flex items-center space-x-1.5 lg:space-x-2 text-gray-700 hover:text-red-800 transition focus:outline-none">
                                    <div
                                        class="w-8 h-8 lg:w-9 lg:h-9 bg-red-800 rounded-full flex items-center justify-center text-white font-bold text-sm lg:text-base">
                                        {{ substr(session('user_name'), 0, 1) }}
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-semibold text-gray-800">{{ session('user_name') }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst(session('user_role')) }}</p>
                                    </div>
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="profileDropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-200">
                                    <div class="px-4 py-2 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-800">{{ session('user_name') }}</p>
                                        <p class="text-xs text-gray-500">{{ session('user_email') }}</p>
                                    </div>
                                    @if(session('user_role') === 'admin')
                                        <a href="/admin/dashboard"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                                </path>
                                            </svg>
                                            <span>Dashboard Admin</span>
                                        </a>
                                    @endif
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2 cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="/login"
                            class="text-red-800 hover:text-red-900 font-medium transition cursor-pointer text-sm lg:text-base">Login</a>
                        <a href="/register"
                            class="bg-red-800 text-white px-4 lg:px-6 py-1.5 lg:py-2 rounded-lg hover:bg-red-900 hover:shadow-lg transition font-medium cursor-pointer text-sm lg:text-base">
                            Daftar
                        </a>
                    @endif
                </div>

                <!-- Mobile Icons & Menu Button -->
                <div class="flex items-center space-x-2 md:hidden">
                    @if(session('user_id'))
                        <!-- Notifikasi Icon Mobile -->
                        <a href="/notifications" class="text-gray-700 hover:text-red-800 transition relative p-1.5"
                            title="Notifikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @php
                                $unreadCount = \App\Models\Notification::where('user_id', session('user_id'))->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span
                                    class="absolute top-0 right-0 bg-red-800 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-semibold text-[10px]">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </a>

                        <!-- Keranjang Icon Mobile -->
                        <a href="/cart" class="text-gray-700 hover:text-red-800 transition relative p-1.5"
                            title="Keranjang">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', session('user_id'))->count();
                            @endphp
                            @if($cartCount > 0)
                                <span
                                    class="absolute top-0 right-0 bg-red-800 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-semibold text-[10px]">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        </a>
                    @endif

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-red-800 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    @if(session('user_id'))
                        <a href="/" class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2">Beranda</a>
                        <a href="/menu" class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2">Menu</a>
                        <a href="/orders"
                            class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2">Pesanan</a>
                        <a href="/reviews"
                            class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2">Review</a>
                        <div class="border-t pt-3 px-4">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-10 h-10 bg-red-800 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(session('user_name'), 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ session('user_name') }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(session('user_role')) }}</p>
                                </div>
                            </div>
                            @if(session('user_role') === 'admin')
                                <a href="/admin/dashboard"
                                    class="w-full bg-red-800 hover:bg-red-900 text-white px-4 py-2 rounded-lg transition font-medium flex items-center justify-center space-x-2 cursor-pointer mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    <span>Dashboard Admin</span>
                                </a>
                            @endif
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition font-medium flex items-center justify-center space-x-2 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="/#beranda"
                            class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2 smooth-scroll">Beranda</a>
                        <a href="/#tentang"
                            class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2 smooth-scroll">Tentang
                            Kami</a>
                        <a href="/#menu"
                            class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2 smooth-scroll">Menu</a>
                        <a href="/#review"
                            class="text-gray-700 hover:text-red-800 transition font-medium px-4 py-2 smooth-scroll">Review</a>
                        <a href="/login"
                            class="text-red-800 hover:text-red-900 font-medium px-4 py-2 cursor-pointer">Login</a>
                        <a href="/register"
                            class="bg-red-800 text-white hover:bg-red-900 px-4 py-2 rounded-lg font-medium cursor-pointer">Daftar</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Login Modal -->
    <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Login Diperlukan</h3>
                <p class="text-gray-600">Silakan login terlebih dahulu untuk mengakses fitur ini</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="/login"
                    class="flex-1 bg-red-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-900 transition text-center cursor-pointer">
                    Login
                </a>
                <button onclick="closeLoginModal()"
                    class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition cursor-pointer">
                    Batal
                </button>
            </div>
            <p class="text-center text-sm text-gray-600 mt-4">
                Belum punya akun? <a href="/register" class="text-red-800 font-semibold hover:text-red-900">Daftar
                    disini</a>
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 text-red-800 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Brand -->
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-bold mb-1">Rice Berapi</h3>
                    <p class="text-red-800 text-sm">UMKM Nasi Bakar Terbaik</p>
                </div>

                <!-- Contact -->
                <div class="text-center md:text-right">
                    <p class="text-red-800 text-sm">Email: info@riceberapi.com</p>
                    <p class="text-red-800 text-sm">Phone: 0896-3595-7141</p>
                </div>
            </div>

            <div class="border-t border-red-700 mt-6 pt-4 text-center">
                <p class="text-red-800 text-sm">&copy; 2026 Rice Berapi. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript untuk Mobile Menu -->
    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-btn').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Profile Dropdown Toggle
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileDropdownBtn && profileDropdown) {
            profileDropdownBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!profileDropdownBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }

        // Show Login Modal
        function showLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Login Modal
        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('loginModal')?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });

        // Expose to window for use in other scripts
        window.showLoginModal = showLoginModal;
        window.closeLoginModal = closeLoginModal;

        // Smooth scroll untuk anchor links
        document.querySelectorAll('a.smooth-scroll').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');

                // Cek apakah link mengandung hash
                if (href.includes('#')) {
                    e.preventDefault();

                    const targetId = href.split('#')[1];
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        // Tutup mobile menu jika terbuka
                        const mobileMenu = document.getElementById('mobile-menu');
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }

                        // Smooth scroll ke target
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                        // Update URL tanpa reload
                        history.pushState(null, null, href);
                    }
                }
            });
        });

        // Handle direct access dengan hash di URL
        window.addEventListener('load', function () {
            if (window.location.hash) {
                const targetId = window.location.hash.substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    setTimeout(() => {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            }
        });

        // Auto hide alerts after 5 seconds
        setTimeout(function () {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>