@extends('layouts.app')

@section('title', 'Beri Review - Rice Berapi')

@section('content')
<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <a href="/orders/{{ $order->id }}" class="inline-flex items-center text-red-800 hover:text-red-900 mb-6 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Detail Pesanan
            </a>

            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                <div class="text-center mb-6 md:mb-8">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Beri Review</h1>
                    <p class="text-gray-600 text-sm md:text-base">Bantu customer lain dengan memberikan review Anda</p>
                </div>

                <!-- Product Info -->
                <div class="bg-linear-to-r from-red-50 to-orange-50 rounded-lg p-4 md:p-6 mb-6 md:mb-8 border border-red-100">
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-lg flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl md:text-4xl">🍱</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-800 text-base md:text-lg mb-1">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm md:text-base line-clamp-2">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Review Form -->
                <form action="/reviews" method="POST" id="reviewForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Rating -->
                    <div class="mb-6 md:mb-8">
                        <label class="block text-gray-800 font-bold mb-3 text-base md:text-lg">
                            Berapa bintang yang Anda berikan? <span class="text-red-500">*</span>
                        </label>
                        <div class="flex justify-center space-x-2 md:space-x-3 mb-2" id="starRating">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="rating" value="{{ $i }}" required class="hidden rating-input" data-rating="{{ $i }}">
                                    <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-300 group-hover:text-yellow-400 fill-current transition duration-150 star-icon" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        <p class="text-center text-sm text-gray-600" id="ratingText">Klik bintang untuk memberi rating</p>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-6 md:mb-8">
                        <label class="block text-gray-800 font-bold mb-2 text-base md:text-lg">
                            Ceritakan pengalaman Anda <span class="text-gray-500 font-normal">(Opsional)</span>
                        </label>
                        
                        <!-- Default Message Preview -->
                        <div id="defaultMessagePreview" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                            <div class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs md:text-sm text-blue-800 font-semibold mb-1">Preview ulasan default:</p>
                                    <p class="text-xs md:text-sm text-blue-700 italic" id="defaultMessageText"></p>
                                    <p class="text-xs text-blue-600 mt-1">Jika Anda tidak menulis komentar, ulasan ini akan ditampilkan secara otomatis.</p>
                                </div>
                            </div>
                        </div>
                        
                        <textarea name="comment" id="commentTextarea" rows="5"
                                  class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base"
                                  placeholder="Bagikan pengalaman Anda tentang produk ini... (minimal 10 karakter jika diisi)">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 bg-red-800 text-white font-bold py-3 md:py-4 px-6 rounded-lg hover:bg-red-900 hover:shadow-xl transition duration-200">
                            Kirim Review
                        </button>
                        <a href="/orders/{{ $order->id }}" class="flex-1 bg-gray-200 text-gray-700 font-semibold py-3 md:py-4 px-6 rounded-lg text-center hover:bg-gray-300 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Interactive Star Rating
    const ratingInputs = document.querySelectorAll('.rating-input');
    const starIcons = document.querySelectorAll('.star-icon');
    const ratingText = document.getElementById('ratingText');
    const defaultMessagePreview = document.getElementById('defaultMessagePreview');
    const defaultMessageText = document.getElementById('defaultMessageText');
    const commentTextarea = document.getElementById('commentTextarea');
    
    const ratingLabels = {
        1: 'Sangat Buruk ⭐',
        2: 'Buruk ⭐⭐',
        3: 'Cukup ⭐⭐⭐',
        4: 'Bagus ⭐⭐⭐⭐',
        5: 'Sangat Bagus ⭐⭐⭐⭐⭐'
    };

    const defaultMessages = {
        1: 'Tidak sesuai harapan.',
        2: 'Kurang memuaskan, ada yang perlu ditingkatkan.',
        3: 'Cukup baik, sesuai dengan harga.',
        4: 'Memuaskan, produk enak dan sesuai ekspektasi.',
        5: 'Sangat puas! Produk sangat enak dan berkualitas.'
    };

    // Function to update default message preview
    function updateDefaultMessagePreview() {
        const checkedInput = document.querySelector('.rating-input:checked');
        const hasComment = commentTextarea.value.trim().length > 0;
        
        if (checkedInput && !hasComment) {
            const rating = parseInt(checkedInput.value);
            defaultMessageText.textContent = defaultMessages[rating];
            defaultMessagePreview.classList.remove('hidden');
        } else {
            defaultMessagePreview.classList.add('hidden');
        }
    }

    ratingInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            const rating = parseInt(this.value);
            updateStars(rating);
            ratingText.textContent = ratingLabels[rating];
            ratingText.classList.add('text-yellow-600', 'font-semibold');
            updateDefaultMessagePreview();
        });

        // Hover effect
        input.parentElement.addEventListener('mouseenter', function() {
            const rating = parseInt(input.value);
            updateStars(rating, true);
        });
    });

    // Listen to textarea input to hide/show preview
    commentTextarea.addEventListener('input', function() {
        updateDefaultMessagePreview();
    });

    // Reset on mouse leave
    document.getElementById('starRating').addEventListener('mouseleave', function() {
        const checkedInput = document.querySelector('.rating-input:checked');
        if (checkedInput) {
            updateStars(parseInt(checkedInput.value));
        } else {
            updateStars(0);
        }
    });

    function updateStars(rating, isHover = false) {
        starIcons.forEach((icon, index) => {
            if (index < rating) {
                icon.classList.remove('text-gray-300');
                icon.classList.add('text-yellow-400');
            } else {
                icon.classList.remove('text-yellow-400');
                icon.classList.add('text-gray-300');
            }
        });
    }

    // Form validation
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        const rating = document.querySelector('.rating-input:checked');
        if (!rating) {
            e.preventDefault();
            alert('Silakan pilih rating bintang terlebih dahulu!');
            return false;
        }
    });
</script>
@endsection
