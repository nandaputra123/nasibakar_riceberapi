@extends('layouts.app')

@section('title', 'Notifikasi - Rice Berapi')

@section('content')
<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Notifikasi</h1>
                <p class="text-gray-600 text-sm md:text-base">Semua pemberitahuan untuk Anda</p>
            </div>
            @if($notifications->where('is_read', false)->count() > 0)
                <form action="/notifications/read-all" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full sm:w-auto bg-blue-500 text-white px-4 md:px-6 py-2 md:py-2.5 rounded-lg font-semibold hover:bg-blue-600 transition text-sm md:text-base">
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-3 md:space-y-4">
                @foreach($notifications as $notification)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-4 md:p-6 {{ !$notification->is_read ? 'border-l-4 border-red-800' : '' }}">
                        <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                            <div class="flex-1 w-full">
                                <div class="flex items-start sm:items-center mb-2 gap-2">
                                    <div class="flex-1">
                                        <h3 class="text-base md:text-xl font-bold text-gray-800">{{ $notification->title }}</h3>
                                    </div>
                                    @if(!$notification->is_read)
                                        <span class="bg-red-800 text-white text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap">Baru</span>
                                    @endif
                                </div>
                                <p class="text-gray-700 mb-2 text-sm md:text-base">{{ $notification->message }}</p>
                                <p class="text-xs md:text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>

                            @if(!$notification->is_read)
                                <form action="/notifications/{{ $notification->id }}/read" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full sm:w-auto text-blue-600 hover:text-blue-800 font-semibold transition text-sm md:text-base whitespace-nowrap">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6 md:mt-8">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center">
                <div class="text-6xl md:text-8xl mb-4 md:mb-6">🔔</div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Tidak Ada Notifikasi</h3>
                <p class="text-gray-600 text-base md:text-lg">Anda tidak memiliki notifikasi saat ini</p>
            </div>
        @endif
    </div>
</section>
@endsection
