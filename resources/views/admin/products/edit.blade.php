@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="mb-6 md:mb-8">
    <a href="/admin/products" class="text-red-800 hover:text-red-900 font-semibold inline-flex items-center text-sm md:text-base transition">
        <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali
    </a>
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mt-3 md:mt-4">Edit Produk</h1>
</div>

<div class="bg-white rounded-xl shadow-md p-4 md:p-6 lg:p-8">
    <form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Current Image -->
        @if($product->image)
            <div class="mb-4 md:mb-6">
                <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Gambar Saat Ini</label>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 md:w-48 md:h-48 object-cover rounded-lg shadow-md">
            </div>
        @endif

        <!-- Name -->
        <div class="mb-4 md:mb-6">
            <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" required value="{{ old('name', $product->name) }}"
                   class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">
        </div>

        <!-- Description -->
        <div class="mb-4 md:mb-6">
            <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Deskripsi</label>
            <textarea name="description" rows="4"
                      class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Price & Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-4 md:mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Harga <span class="text-red-500">*</span></label>
                <input type="number" name="price" required value="{{ old('price', $product->price) }}" min="0"
                       class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stock" required value="{{ old('stock', $product->stock) }}" min="0"
                       class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">
            </div>
        </div>

        <!-- Category -->
        <div class="mb-4 md:mb-6">
            <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Kategori <span class="text-red-500">*</span></label>
            <select name="category" required class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $product->category == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Image -->
        <div class="mb-4 md:mb-6">
            <label class="block text-gray-700 font-semibold mb-2 text-sm md:text-base">Ganti Gambar (Opsional)</label>
            <input type="file" name="image" accept="image/*" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg text-sm md:text-base">
            <p class="text-xs md:text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF, WEBP, AVIF. Max: 2MB</p>
        </div>

        <!-- Is Active -->
        <div class="mb-6 md:mb-8">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="w-4 h-4 md:w-5 md:h-5 text-red-800 rounded focus:ring-2 focus:ring-red-800">
                <span class="ml-2 text-sm md:text-base text-gray-700 font-semibold">Aktifkan Produk</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
            <button type="submit" class="flex-1 bg-red-800 hover:bg-red-900 text-white font-bold h-11 md:h-12 px-4 md:px-6 rounded-lg hover:shadow-lg transition text-sm md:text-base">
                Update Produk
            </button>
            <a href="/admin/products" class="flex-1 bg-gray-200 text-gray-700 font-semibold h-11 md:h-12 px-4 md:px-6 rounded-lg text-center hover:bg-gray-300 transition flex items-center justify-center text-sm md:text-base">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
