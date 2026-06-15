@extends('layouts.admin')
@section('title', 'Manajemen Booking')
@section('subtitle', 'Kelola semua reservasi Grand Paijo\'s Nusantara Hotel')

@section('topbar-actions')
    <a href="{{ route('admin.bookings.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all duration-200 hover:opacity-90 active:scale-95"
        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Booking
    </a>
@endsection

@section('content')

    {{-- Filter tabs --}}
    <div
        class="flex items-center gap-1 mb-5 bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-1.5 w-fit">
        @foreach(['' => 'Semua', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'checked_in' => 'Checked In', 'checked_out' => 'Checked Out', 'cancelled' => 'Cancelled'] as $val => $label)
            <a href="{{ route('admin.bookings.index', $val ? ['status' => $val] : []) }}"
                class="px-4 py-1.5 rounded-xl text-xs font-medium transition-all duration-150
                      {{ request('status') === $val || (request('status') === null && $val === '')
                ? 'text-white shadow-sm' : 'text-gray-500 dark:text-white/40 hover:text-gray-700 dark:hover:text-white/70' }}" @if(request('status') === $val || (request('status') === null && $val === '')) style="background: linear-gradient(135deg, #7C3AED, #4F46E5)" @endif>
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-50 dark:border-white/5">
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Kode</th>
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Tamu</th>
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Kamar</th>
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Check-in</th>
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Check-out</th>
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Total</th>
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                @forelse($bookings as $booking)
                    @php
                        $statusStyle = match ($booking->status) {
                            'confirmed' => 'bg-purple-50 dark:bg-purple-500/15 text-purple-700 dark:text-purple-300',
                            'pending' => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                            'checked_in' => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                            'checked_out' => 'bg-gray-100 dark:bg-white/8 text-gray-600 dark:text-white/40',
                            'cancelled' => 'bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-400',
                            default => 'bg-gray-100 text-gray-500',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/2 transition-colors duration-100">
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-mono font-semibold text-purple-600 dark:text-purple-400">
                                {{ $booking->booking_code }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="text-sm font-medium text-gray-800 dark:text-white">{{ $booking->guest_name }}</div>
                            <div class="text-xs text-gray-400 dark:text-white/30 mt-0.5">{{ $booking->guest_phone }}</div>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-600 dark:text-white/60">
                            {{ $booking->room->room_number }}
                            <span class="text-xs text-gray-400 dark:text-white/30">· {{ $booking->room->roomType->name }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-600 dark:text-white/60">
                            {{ $booking->check_in->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-600 dark:text-white/60">
                            {{ $booking->check_out->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5 text-sm font-semibold text-gray-800 dark:text-white">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $statusStyle }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-xs px-3 py-1.5 rounded-lg border border-gray-200 dark:border-white/10
                                          text-gray-600 dark:text-white/50 hover:bg-gray-50 dark:hover:bg-white/5
                                          transition-colors duration-150">
                                    Detail
                                </a>
                                <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                                    onsubmit="return confirm('Hapus booking ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-500/20
                                                   text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10
                                                   transition-colors duration-150">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-sm text-gray-400 dark:text-white/25">
                            Belum ada data booking
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($bookings->hasPages())
            <div class="px-5 py-4 border-t border-gray-50 dark:border-white/5">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

@endsection