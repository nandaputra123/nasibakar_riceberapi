@extends('layouts.app')

@section('title', 'Rice Berapi - Nasi Bakar Terlezat')

@section('content')

<!-- Hero Section with Carousel -->
<section id="beranda" class="bg-linear-to-br from-red-50 to-red-100 py-10 md:py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 md:gap-8">
            <!-- Left Content -->
            <div class="md:w-1/2 mb-6 md:mb-0">
                <h1 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 md:mb-5 lg:mb-6 leading-tight text-gray-800">
                    Nasi Bakar <br>
                    <span class="text-red-800">Berapi</span> Terbaik!
                </h1>
                <p class="text-base md:text-lg lg:text-xl mb-6 md:mb-7 lg:mb-8 text-gray-700">
                    Nikmati kelezatan nasi bakar dengan berbagai varian rasa yang menggugah selera. Dibuat dengan bahan berkualitas dan bumbu pilihan.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <a href="/#menu" class="bg-white border-2 border-red-800 text-red-800 px-6 py-3 rounded-lg text-sm lg:px-8 lg:py-4 lg:text-base font-bold hover:bg-red-800 hover:text-white transition duration-200 cursor-pointer text-center">
                        Lihat Menu
                    </a>
                    @if(!session('user_id'))
                        <a href="/register" class="bg-white border-2 border-red-800 text-red-800 px-6 py-3 rounded-lg text-sm lg:px-8 lg:py-4 lg:text-base font-bold hover:bg-red-800 hover:text-white transition duration-200 cursor-pointer text-center">
                            Daftar Sekarang
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Right Content - Carousel -->
            <div class="md:w-1/2 w-full">
                <div class="carousel-container relative w-full h-56 sm:h-72 md:h-80 lg:h-96 xl:h-[450px] rounded-2xl overflow-hidden shadow-2xl">
                    <!-- Slide 1 -->
                    <div class="carousel-slide active absolute inset-0 w-full h-full">
                        <img src="{{ asset('assets/carousel_1.jpeg') }}" alt="Rice Berapi Carousel 1" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Slide 2 -->
                    <div class="carousel-slide absolute inset-0 w-full h-full opacity-0">
                        <img src="{{ asset('assets/carousel_2.jpeg') }}" alt="Rice Berapi Carousel 2" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Slide 3 -->
                    <div class="carousel-slide absolute inset-0 w-full h-full opacity-0">
                        <img src="{{ asset('assets/carousel_3.jpeg') }}" alt="Rice Berapi Carousel 3" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Carousel Navigation Dots -->
                    <div class="absolute bottom-3 md:bottom-4 left-1/2 transform -translate-x-1/2 z-10 flex gap-2 md:gap-3">
                        <button class="carousel-dot active w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white" data-slide="0"></button>
                        <button class="carousel-dot w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white" data-slide="1"></button>
                        <button class="carousel-dot w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white" data-slide="2"></button>
                    </div>
                    
                    <!-- Carousel Arrow Navigation -->
                    <button class="carousel-prev absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 z-10 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-1.5 md:p-2 rounded-full transition">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="carousel-next absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 z-10 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-1.5 md:p-2 rounded-full transition">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Carousel functionality - Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;
        let autoplayInterval;

        // Check if carousel elements exist
        if (slides.length === 0 || dots.length === 0) {
            console.warn('Carousel elements not found');
            return;
        }

        function showSlide(index) {
            // Remove active class from all slides and dots
            slides.forEach(slide => {
                slide.classList.remove('active');
                slide.classList.add('opacity-0');
            });
            dots.forEach(dot => {
                dot.classList.remove('active', 'bg-white');
                dot.classList.add('bg-opacity-50');
            });
            
            // Add active class to current slide and dot
            slides[index].classList.add('active');
            slides[index].classList.remove('opacity-0');
            dots[index].classList.add('active', 'bg-white');
            dots[index].classList.remove('bg-opacity-50');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        // Arrow navigation
        const nextBtn = document.querySelector('.carousel-next');
        const prevBtn = document.querySelector('.carousel-prev');
        const carouselContainer = document.querySelector('.carousel-container');

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                stopAutoplay();
                startAutoplay(); // Restart autoplay
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                stopAutoplay();
                startAutoplay(); // Restart autoplay
            });
        }

        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
                stopAutoplay();
                startAutoplay(); // Restart autoplay
            });
        });

        // Start autoplay on page load
        startAutoplay();

        // Pause autoplay on hover
        if (carouselContainer) {
            carouselContainer.addEventListener('mouseenter', stopAutoplay);
            carouselContainer.addEventListener('mouseleave', startAutoplay);
        }
    });
</script>
@endpush

<!-- About Section -->
<section id="tentang" class="py-8 md:py-12 lg:py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-10 lg:gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4 md:mb-5 lg:mb-6">Tentang <span class="text-red-800">Rice Berapi</span></h2>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-4 md:mb-5 lg:mb-6 leading-relaxed">
                    Rice Berapi adalah UMKM lokal yang berkomitmen menghadirkan nasi bakar berkualitas tinggi dengan cita rasa autentik Indonesia. 
                    Setiap produk kami dibuat dengan penuh perhatian menggunakan bahan-bahan pilihan dan resep rahasia yang telah diwariskan turun-temurun.
                </p>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-6 md:mb-7 lg:mb-8 leading-relaxed">
                    Kami percaya bahwa makanan bukan hanya tentang rasa, tetapi juga tentang kehangatan dan kenangan. 
                    Itulah mengapa setiap nasi bakar kami dibuat dengan penuh cinta untuk menghadirkan pengalaman kuliner yang tak terlupakan.
                </p>

                <!-- Keunggulan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                    <div class="flex items-start space-x-2 md:space-x-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-red-800 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm md:text-base font-bold text-gray-800 mb-1">Bahan Berkualitas</h3>
                            <p class="text-gray-600 text-xs md:text-sm">Menggunakan bahan segar dan pilihan terbaik</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2 md:space-x-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-red-800 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm md:text-base font-bold text-gray-800 mb-1">Resep Autentik</h3>
                            <p class="text-gray-600 text-xs md:text-sm">Cita rasa asli Indonesia yang kaya bumbu</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2 md:space-x-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-red-800 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm md:text-base font-bold text-gray-800 mb-1">Higienis & Aman</h3>
                            <p class="text-gray-600 text-xs md:text-sm">Proses pembuatan yang bersih dan terjamin</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2 md:space-x-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-red-800 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm md:text-base font-bold text-gray-800 mb-1">Harga Terjangkau</h3>
                            <p class="text-gray-600 text-xs md:text-sm">Kualitas premium dengan harga bersahabat</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content - Image/Illustration -->
            <div class="relative">
                <div class="bg-linear-to-br from-red-50 to-red-100 rounded-2xl p-4 md:p-6 lg:p-8 shadow-xl">
                    <img src="{{ asset('assets/rice-icon.jpg') }}" alt="Rice Berapi" class="w-full h-auto rounded-xl shadow-lg mb-4 md:mb-5 lg:mb-6">
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-2 md:gap-3 lg:gap-4 text-center">
                        <div class="bg-white rounded-lg p-2 md:p-3 lg:p-4 shadow-md">
                            <p class="text-xl md:text-2xl lg:text-3xl font-bold text-red-800 mb-0.5 md:mb-1">{{ DB::table('users')->where('role', 'customer')->count() }}+</p>
                            <p class="text-gray-600 text-xs md:text-sm">Pelanggan</p>
                        </div>
                        <div class="bg-white rounded-lg p-2 md:p-3 lg:p-4 shadow-md">
                            <p class="text-xl md:text-2xl lg:text-3xl font-bold text-red-800 mb-0.5 md:mb-1">{{ DB::table('products')->count() }}</p>
                            <p class="text-gray-600 text-xs md:text-sm">Menu</p>
                        </div>
                        <div class="bg-white rounded-lg p-2 md:p-3 lg:p-4 shadow-md">
                            <p class="text-xl md:text-2xl lg:text-3xl font-bold text-red-800 mb-0.5 md:mb-1">{{ DB::table('orders')->where('status', 'completed')->count() }}+</p>
                            <p class="text-gray-600 text-xs md:text-sm">Pesanan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Unggulan -->
<section id="menu" class="py-8 md:py-12 lg:py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 md:mb-10 lg:mb-12">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-3 md:mb-4">Menu Unggulan</h2>
            <p class="text-gray-600 text-sm md:text-base lg:text-lg">Pilihan nasi bakar favorit pelanggan kami</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 overflow-hidden">
                    <!-- Gambar Produk -->
                    <div class="h-48 bg-linear-to-br from-red-50 to-red-100 flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl">🍱</span>
                        @endif
                    </div>

                    <!-- Info Produk -->
                    <div class="p-5">
                        <div class="mb-2">
                            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-semibold">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                        
                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex mr-2">
                                @php
                                    $avgRating = $product->reviews_avg_rating ? round($product->reviews_avg_rating) : 0;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $avgRating)
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">
                                @if($product->reviews_avg_rating)
                                    {{ number_format($product->reviews_avg_rating, 1) }}
                                @else
                                    0.0
                                @endif
                                ({{ $product->reviews_count }})
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="text-2xl font-bold text-red-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex gap-2">
                            @if(session('user_id'))
                                <a href="/menu/{{ $product->id }}" class="flex-1 inline-flex items-center justify-center bg-white border-2 border-red-800 text-red-800 px-4 py-2 rounded-lg font-semibold hover:bg-red-50 transition cursor-pointer">
                                    Detail
                                </a>
                            @else
                                <a href="/login?redirect=detail" class="flex-1 inline-flex items-center justify-center bg-white border-2 border-red-800 text-red-800 px-4 py-2 rounded-lg font-semibold hover:bg-red-50 transition cursor-pointer">
                                    Detail
                                </a>
                            @endif
                            @if(session('user_id'))
                                <form action="/cart/add" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full inline-flex items-center justify-center bg-red-800 border-2 border-red-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-900 hover:border-red-900 transition cursor-pointer">
                                        Pesan
                                    </button>
                                </form>
                            @else
                                <a href="/login?redirect=order" class="flex-1 inline-flex items-center justify-center bg-red-800 border-2 border-red-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-900 hover:border-red-900 transition cursor-pointer">
                                    Pesan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            @if(session('user_id'))
                <a href="/menu" class="inline-block bg-red-800 text-white px-8 py-4 rounded-lg font-bold hover:shadow-xl transform hover:scale-105 transition duration-200 cursor-pointer">
                    Lihat Semua Menu
                </a>
            @else
                <a href="/login?redirect=menu" class="inline-block bg-red-800 text-white px-8 py-4 rounded-lg font-bold hover:shadow-xl transform hover:scale-105 transition duration-200 cursor-pointer">
                    Lihat Semua Menu
                </a>
            @endif
        </div>
    </div>
</section>

<!-- Reviews dari Customer -->
<section id="review" class="py-8 md:py-12 lg:py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 md:mb-10 lg:mb-12">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-3 md:mb-4">Review Pelanggan Kami</h2>
            <p class="text-gray-600 text-sm md:text-base lg:text-lg">Kepuasan pelanggan adalah prioritas kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5 lg:gap-6 mb-6 md:mb-7 lg:mb-8">
            <!-- Review Stats -->
            <div class="bg-white rounded-xl p-5 md:p-6 lg:p-8 shadow-lg text-center">
                <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-red-800 mb-2">4.8</div>
                <div class="flex justify-center mb-2 md:mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-gray-600 text-xs md:text-sm">Rating rata-rata</p>
                <p class="text-gray-500 text-xs mt-1 md:mt-2">Dari {{ DB::table('reviews')->count() }}+ reviews</p>
            </div>

            <!-- Customer Satisfaction -->
            <div class="bg-white rounded-xl p-5 md:p-6 lg:p-8 shadow-lg text-center">
                <div class="text-3xl md:text-4xl lg:text-5xl mb-2 md:mb-3">😊</div>
                <div class="text-2xl md:text-3xl font-bold text-red-800 mb-2">98%</div>
                <p class="text-gray-600 text-xs md:text-sm">Kepuasan Pelanggan</p>
                <p class="text-gray-500 text-xs mt-1 md:mt-2">Pelanggan puas dengan produk kami</p>
            </div>

            <!-- Repeat Customers -->
            <div class="bg-white rounded-xl p-5 md:p-6 lg:p-8 shadow-lg text-center">
                <div class="text-3xl md:text-4xl lg:text-5xl mb-2 md:mb-3">🔄</div>
                <div class="text-2xl md:text-3xl font-bold text-red-800 mb-2">85%</div>
                <p class="text-gray-600 text-xs md:text-sm">Repeat Order</p>
                <p class="text-gray-500 text-xs mt-1 md:mt-2">Pelanggan memesan kembali</p>
            </div>
        </div>

        <!-- Customer Testimonials -->
        @if($testimonials->count() > 0)
        <div>
            <div class="text-center mb-6 md:mb-8">
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Apa Kata Mereka?</h3>
                <p class="text-gray-600 text-sm md:text-base">Testimoni dari pelanggan setia Rice Berapi</p>
            </div>
            
            <div id="reviewsContainer" class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                @foreach($testimonials as $index => $review)
                    <div class="review-card {{ $index >= 3 ? 'hidden' : '' }} bg-white rounded-xl p-4 md:p-6 shadow-md hover:shadow-xl transition duration-300">
                        <!-- Rating -->
                        <div class="flex mb-3 md:mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        
                        <!-- Comment -->
                        @php
                            $defaultMessages = [
                                1 => 'Tidak sesuai harapan.',
                                2 => 'Kurang memuaskan, ada yang perlu ditingkatkan.',
                                3 => 'Cukup baik, sesuai dengan harga.',
                                4 => 'Memuaskan, produk enak dan sesuai ekspektasi.',
                                5 => 'Sangat puas! Produk sangat enak dan berkualitas.'
                            ];
                            $displayComment = $review->comment ?: $defaultMessages[$review->rating];
                        @endphp
                        <p class="text-sm md:text-base text-gray-700 mb-3 md:mb-4 italic line-clamp-3">"{{ $displayComment }}"</p>
                        
                        <!-- User Info -->
                        <div class="flex items-center pt-3 md:pt-4 border-t border-gray-200">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-800 rounded-full flex items-center justify-center text-white font-bold text-base md:text-lg shrink-0">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div class="ml-3 min-w-0 flex-1">
                                <p class="font-semibold text-gray-800 text-sm md:text-base truncate">{{ $review->user->name }}</p>
                                <p class="text-xs md:text-sm text-gray-500 truncate">{{ $review->product->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 md:mt-1">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Button Lihat Semua Review -->
            @if($testimonials->count() > 3)
            <div class="text-center mt-6 md:mt-8">
                <button id="toggleReviewsBtn" onclick="toggleAllReviews()" class="inline-flex items-center justify-center bg-white border-2 border-red-800 text-red-800 px-6 md:px-8 py-3 md:py-4 rounded-lg text-sm md:text-base font-bold hover:bg-red-800 hover:text-white hover:shadow-xl transform hover:scale-105 transition duration-200 cursor-pointer">
                    <span id="btnText">Lihat Semua Review ({{ $testimonials->count() }})</span>
                    <svg id="btnIconDown" class="w-4 h-4 md:w-5 md:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <svg id="btnIconUp" class="w-4 h-4 md:w-5 md:h-5 ml-2" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </div>
            
            <script>
                let showingAll = false;
                
                function toggleAllReviews() {
                    const reviewCards = document.querySelectorAll('.review-card');
                    const btnText = document.getElementById('btnText');
                    const btnIconDown = document.getElementById('btnIconDown');
                    const btnIconUp = document.getElementById('btnIconUp');
                    const reviewsContainer = document.getElementById('reviewsContainer');
                    
                    if (!showingAll) {
                        // Show all reviews
                        reviewCards.forEach((card, index) => {
                            if (index >= 3) {
                                card.classList.remove('hidden');
                            }
                        });
                        btnText.textContent = 'Sembunyikan Review';
                        // Hide down icon, show up icon
                        btnIconDown.style.display = 'none';
                        btnIconUp.style.display = 'inline-block';
                        showingAll = true;
                        
                        // Smooth scroll to show new reviews
                        setTimeout(() => {
                            reviewsContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }, 100);
                    } else {
                        // Hide extra reviews
                        reviewCards.forEach((card, index) => {
                            if (index >= 3) {
                                card.classList.add('hidden');
                            }
                        });
                        btnText.textContent = 'Lihat Semua Review ({{ $testimonials->count() }})';
                        // Show down icon, hide up icon
                        btnIconDown.style.display = 'inline-block';
                        btnIconUp.style.display = 'none';
                        showingAll = false;
                        
                        // Scroll back to reviews section
                        reviewsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            </script>
            @endif
        </div>
        @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Review</h3>
            <p class="text-gray-600">Jadilah yang pertama memberikan review untuk produk kami!</p>
        </div>
        @endif
    </div>
</section>

<!-- Lokasi Section -->
<section id="lokasi" class="py-12 md:py-16 lg:py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 md:mb-10 lg:mb-12">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-3 md:mb-4">Lokasi Kami</h2>
            <p class="text-gray-600 text-base md:text-lg lg:text-xl">Kunjungi langsung kedai kami atau pesan online untuk delivery</p>
        </div>

        <!-- Map (Full Width) -->
        <div class="mb-6 md:mb-8">
            <div class="rounded-xl md:rounded-2xl overflow-hidden shadow-lg md:shadow-xl">
                <iframe 
                    src="https://maps.google.com/maps?q=-6.433510845537245,106.91111762157104&z=16&output=embed" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-64 sm:h-80 md:h-96 lg:h-[450px] xl:h-[500px]">
                </iframe>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 lg:gap-8">
            <!-- Alamat -->
            <div class="bg-gray-50 rounded-xl p-4 sm:p-6 lg:p-8 shadow-md hover:shadow-xl transition duration-300">
                <div class="flex items-start space-x-3 sm:space-x-4">
                    <div class="bg-red-800 text-white p-3 sm:p-3.5 lg:p-4 rounded-xl shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-2 sm:mb-3">Alamat Lengkap</h3>
                        <p class="text-sm sm:text-base lg:text-lg text-gray-600 leading-relaxed">
                            Jl. Rinjani, Griya Bukit Jaya<br>
                            Blok S No. 10, RT 05/RW 24<br>
                            Desa Tlajung Udik, Kec. Gunung Putri<br>
                            Kabupaten Bogor
                        </p>
                    </div>
                </div>
            </div>

            <!-- Jam Operasional -->
            <div class="bg-gray-50 rounded-xl p-4 sm:p-6 lg:p-8 shadow-md hover:shadow-xl transition duration-300">
                <div class="flex items-start space-x-3 sm:space-x-4">
                    <div class="bg-red-800 text-white p-3 sm:p-3.5 lg:p-4 rounded-xl shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-2 sm:mb-3">Jam Operasional</h3>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 space-y-1.5 sm:space-y-2">
                            <p>Senin - Jumat:<br class="sm:hidden"> <span class="font-semibold text-red-800">10.00 - 21.00</span></p>
                            <p>Sabtu - Minggu:<br class="sm:hidden"> <span class="font-semibold text-red-800">09.00 - 22.00</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
