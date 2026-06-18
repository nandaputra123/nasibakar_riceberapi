@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kelola Produk</h1>
    <a href="/admin/products/create" class="bg-red-800 hover:bg-red-900 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-semibold hover:shadow-lg transition text-sm md:text-base flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Produk
    </a>
</div>

@if($products->count() > 0)
    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-linear-to-br from-red-100 to-orange-100 rounded-lg flex items-center justify-center mr-3 shrink-0 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <span class="text-2xl">🍱</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600 truncate">{{ Str::limit($product->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-sm font-semibold whitespace-nowrap">
                                {{ ucfirst($product->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800 whitespace-nowrap">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 font-semibold {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $product->stock }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-600 hover:text-blue-700 hover:bg-blue-50 p-2 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="showDeleteModal({{ $product->id }})" class="text-red-600 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                <form id="deleteForm{{ $product->id }}" action="/admin/products/{{ $product->id }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile/Tablet Card View -->
    <div class="lg:hidden space-y-4">
        @foreach($products as $product)
            <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-linear-to-br from-red-100 to-orange-100 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <span class="text-2xl sm:text-3xl">🍱</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-800 mb-1 text-sm md:text-base">{{ $product->name }}</h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-2 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                        <div class="flex flex-wrap items-center gap-1.5">
                            <span class="px-2 py-0.5 bg-orange-100 text-orange-600 rounded-full text-xs font-semibold whitespace-nowrap">
                                {{ ucfirst($product->category) }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                    <div class="min-w-0 flex-1">
                        <p class="text-base md:text-lg font-bold text-red-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs md:text-sm {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-600' }} font-semibold">Stok: {{ $product->stock }}</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-600 hover:text-blue-700 hover:bg-blue-50 p-2 rounded-lg transition" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <button onclick="showDeleteModal({{ $product->id }})" class="text-red-600 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        <form id="deleteForm{{ $product->id }}" action="/admin/products/{{ $product->id }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center">
        <div class="text-6xl md:text-8xl mb-4 md:mb-6">📦</div>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Belum Ada Produk</h3>
        <p class="text-sm md:text-base text-gray-600 mb-6 md:mb-8">Mulai tambahkan produk pertama Anda</p>
        <a href="/admin/products/create" class="inline-flex items-center justify-center bg-red-800 hover:bg-red-900 text-white font-bold h-12 md:h-14 px-6 md:px-8 rounded-lg hover:shadow-xl transition text-sm md:text-base gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk
        </a>
    </div>
@endif

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 md:p-8 transform transition-all scale-95" id="deleteModalContent">
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 md:h-16 md:w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 md:h-8 md:w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">Hapus Produk?</h3>
            <p class="text-sm md:text-base text-gray-600">Yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-200 text-gray-700 font-semibold h-11 md:h-12 px-4 rounded-lg hover:bg-gray-300 transition text-sm md:text-base">
                Batal
            </button>
            <button onclick="confirmDelete()" class="flex-1 bg-red-600 text-white font-bold h-11 md:h-12 px-4 rounded-lg hover:bg-red-700 transition text-sm md:text-base">
                Hapus
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let deleteItemId = null;

    function showDeleteModal(itemId) {
        deleteItemId = itemId;
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto', 'flex');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }

    function closeDeleteModal() {
        deleteItemId = null;
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto', 'flex');
        modalContent.classList.add('scale-95');
        modalContent.classList.remove('scale-100');
    }

    function confirmDelete() {
        if (deleteItemId) {
            document.getElementById('deleteForm' + deleteItemId).submit();
        }
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush

@endsection
