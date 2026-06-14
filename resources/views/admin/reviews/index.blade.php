@extends('layouts.admin')
@section('title', 'Ulasan Tamu')
@section('subtitle', 'Review dari tamu Grand Paijo\'s Nusantara Hotel')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    @php
    $avgRating = number_format($avgRating ?? 0, 1);
    $total = $reviews->total();
    $five  = $reviews->getCollection()->where('rating', 5)->count();
    $needReply = $reviews->getCollection()->whereNull('admin_reply')->count();
    @endphp
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5">
        <p class="text-xs text-gray-400 dark:text-white/30 mb-2">Rating Rata-rata</p>
        <p class="text-3xl font-bold text-amber-500">{{ $avgRating }} ⭐</p>
    </div>
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5">
        <p class="text-xs text-gray-400 dark:text-white/30 mb-2">Total Ulasan</p>
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total }}</p>
    </div>
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5">
        <p class="text-xs text-gray-400 dark:text-white/30 mb-2">Bintang 5</p>
        <p class="text-3xl font-bold text-green-500">{{ $five }}</p>
    </div>
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5">
        <p class="text-xs text-gray-400 dark:text-white/30 mb-2">Perlu Respons</p>
        <p class="text-3xl font-bold text-red-500">{{ $needReply }}</p>
    </div>
</div>

{{-- Reviews --}}
<div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl divide-y divide-gray-50 dark:divide-white/5">
    @forelse($reviews as $review)
    <div class="p-5">
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-semibold text-xs text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                    {{ strtoupper(substr($review->guest_name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $review->guest_name }}</p>
                    <p class="text-xs text-gray-400 dark:text-white/30">
                        {{ $review->created_at->format('d M Y') }}
                        @if($review->booking)· Kamar {{ $review->booking->room->room_number }}@endif
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200 dark:text-white/10' }}"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                @endfor
            </div>
        </div>

        <p class="text-sm text-gray-600 dark:text-white/60 mb-3 leading-relaxed">{{ $review->comment }}</p>

        @if($review->admin_reply)
        <div class="ml-4 pl-4 border-l-2 border-purple-200 dark:border-purple-500/30">
            <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 mb-1">Balasan Admin</p>
            <p class="text-sm text-gray-500 dark:text-white/40">{{ $review->admin_reply }}</p>
        </div>
        @else
        <form method="POST" action="{{ route('admin.reviews.reply', $review) }}" class="flex gap-2 mt-3">
            @csrf @method('PATCH')
            <input type="text" name="admin_reply" placeholder="Tulis balasan..."
                   class="flex-1 px-4 py-2 rounded-xl text-sm border border-gray-200 dark:border-white/10
                          bg-gray-50 dark:bg-white/5 text-gray-800 dark:text-white
                          placeholder:text-gray-300 dark:placeholder:text-white/20
                          focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
            <button type="submit"
                    class="px-4 py-2 rounded-xl text-sm font-medium text-white hover:opacity-90 transition-opacity"
                    style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                Balas
            </button>
        </form>
        @endif

        <div class="flex items-center gap-2 mt-3">
            <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                @csrf @method('PATCH')
                <button type="submit"
                        class="text-xs px-3 py-1 rounded-lg border transition-colors duration-150
                               {{ $review->is_published
                                  ? 'border-green-200 dark:border-green-500/20 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-500/10'
                                  : 'border-gray-200 dark:border-white/10 text-gray-500 dark:text-white/30 hover:bg-gray-50 dark:hover:bg-white/5' }}">
                    {{ $review->is_published ? '✓ Dipublikasikan' : '○ Disembunyikan' }}
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="py-16 text-center text-sm text-gray-400 dark:text-white/25">
        Belum ada ulasan tamu
    </div>
    @endforelse
</div>

@if($reviews->hasPages())
<div class="mt-4">{{ $reviews->links() }}</div>
@endif

@endsection