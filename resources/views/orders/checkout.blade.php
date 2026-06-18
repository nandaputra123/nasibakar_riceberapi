@extends('layouts.app')

@section('title', 'Checkout - Rice Berapi')

@section('content')
<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 md:mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Form Checkout -->
            <div class="lg:col-span-2">
                <form action="/checkout" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6 md:p-8">
                    @csrf

                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Informasi Pengiriman</h2>

                    <!-- Alamat -->
                    <div class="mb-4 md:mb-6">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Alamat Pengiriman <span class="text-red-500">*</span></label>
                        <textarea name="shipping_address" rows="3" required
                                  class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base @error('shipping_address') @enderror"
                                  placeholder="Masukkan alamat lengkap">{{ old('shipping_address', $user->address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4 md:mb-6">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">No. Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" required
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base @error('phone') @enderror"
                               placeholder="08123456789">
                        @error('phone')
                            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-4 md:mb-6">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Metode Pembayaran <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                            <label class="border-2 border-gray-300 rounded-lg p-3 md:p-4 cursor-pointer hover:border-red-800 transition">
                                <input type="radio" name="payment_method" value="cash" required class="mr-2" {{ old('payment_method') === 'cash' ? 'checked' : '' }}>
                                <span class="font-semibold text-sm md:text-base">Cash (COD)</span>
                                <p class="text-xs md:text-sm text-gray-600 mt-1">Bayar saat barang diterima</p>
                            </label>
                            <label class="border-2 border-gray-300 rounded-lg p-3 md:p-4 cursor-pointer hover:border-red-800 transition">
                                <input type="radio" name="payment_method" value="transfer" required class="mr-2" {{ old('payment_method') === 'transfer' ? 'checked' : '' }}>
                                <span class="font-semibold text-sm md:text-base">Transfer Bank</span>
                                <p class="text-xs md:text-sm text-gray-600 mt-1">BCA 5726071752 a/n Muhammad Nurcholis </p>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Proof of Transfer (only for bank transfer) -->
                    <div id="proof-transfer" class="mb-4 md:mb-6 hidden">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Bukti Transfer <span class="text-red-500">*</span></label>
                        <input type="file" name="proof_of_transfer" id="proof_of_transfer"
                               accept="image/jpeg,image/png,image/jpg"
                               class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base @error('proof_of_transfer') @enderror">
                        <p class="text-xs md:text-sm text-gray-500 mt-2">Format jpg/png, maksimal 2MB.</p>
                        @error('proof_of_transfer')
                            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Note -->
                    <div class="mb-4 md:mb-6">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Catatan (Opsional)</label>
                        <textarea name="note" rows="2"
                                  class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base"
                                  placeholder="Catatan untuk pesanan Anda">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-red-800 text-white font-bold py-3 md:py-4 px-4 md:px-6 rounded-lg hover:bg-red-900 hover:shadow-xl transition duration-200">
                        Buat Pesanan
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-4 md:p-6 lg:sticky lg:top-24">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 md:space-y-4 mb-4 md:mb-6 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-gray-700 gap-2">
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm md:text-base">{{ $item->product->name }}</p>
                                    <p class="text-xs md:text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold text-sm md:text-base whitespace-nowrap">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-3 md:pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg md:text-xl font-bold text-gray-800">Total</span>
                            <span class="text-2xl md:text-3xl font-bold text-red-800">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const paymentInputs = document.querySelectorAll('input[name="payment_method"]');
        const proofSection = document.getElementById('proof-transfer');
        const proofInput = document.getElementById('proof_of_transfer');

        if (!paymentInputs.length || !proofSection || !proofInput) {
            return;
        }

        function toggleProof() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            const isTransfer = selected && selected.value === 'transfer';

            proofSection.classList.toggle('hidden', !isTransfer);
            proofInput.required = !!isTransfer;
        }

        paymentInputs.forEach((input) => {
            input.addEventListener('change', toggleProof);
        });

        toggleProof();
    })();
</script>
@endsection
