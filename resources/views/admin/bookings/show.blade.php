@extends('layouts.admin')
@section('title', 'Detail Booking ' . $booking->booking_code)
@section('subtitle', 'Grand Paijo\'s Nusantara Hotel')

@section('content')
<div class="max-w-3xl">

    <div class="grid grid-cols-3 gap-5 mb-5">

        {{-- Info Booking --}}
        <div class="col-span-2 bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">{{ $booking->booking_code }}</h2>
                    <p class="text-sm text-gray-400 dark:text-white/30 mt-0.5">
                        Dibuat {{ $booking->created_at->diffForHumans() }}
                    </p>
                </div>
                @php
                $statusStyle = match($booking->status) {
                    'confirmed'   => 'bg-purple-50 dark:bg-purple-500/15 text-purple-700 dark:text-purple-300',
                    'pending'     => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                    'checked_in'  => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                    'checked_out' => 'bg-gray-100 dark:bg-white/8 text-gray-600 dark:text-white/40',
                    'cancelled'   => 'bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-400',
                    default       => 'bg-gray-100 text-gray-500',
                };
                @endphp
                <span class="text-xs px-3 py-1.5 rounded-full font-semibold {{ $statusStyle }}">
                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm mb-5">
                @foreach([
                    ['Nama Tamu',  $booking->guest_name],
                    ['Email',      $booking->guest_email],
                    ['WhatsApp',   $booking->guest_phone],
                    ['Kamar',      $booking->room->room_number . ' — ' . $booking->room->roomType->name],
                    ['Check-in',   $booking->check_in->format('d M Y')],
                    ['Check-out',  $booking->check_out->format('d M Y')],
                    ['Total Malam',$booking->total_nights . ' malam'],
                    ['Total Harga','Rp ' . number_format($booking->total_price, 0, ',', '.')],
                ] as [$label, $value])
                <div>
                    <p class="text-xs text-gray-400 dark:text-white/30 mb-0.5">{{ $label }}</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $value }}</p>
                </div>
                @endforeach
            </div>

            @if($booking->notes)
            <div class="pt-4 border-t border-gray-50 dark:border-white/5">
                <p class="text-xs text-gray-400 dark:text-white/30 mb-1">Catatan</p>
                <p class="text-sm text-gray-600 dark:text-white/60">{{ $booking->notes }}</p>
            </div>
            @endif
        </div>

        {{-- Update Status --}}
        <div class="space-y-4">
            <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <select name="status"
                            class="w-full px-3 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                   bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-purple-500/30">
                        @foreach(['pending'=>'Pending','confirmed'=>'Confirmed','checked_in'=>'Checked In','checked_out'=>'Checked Out','cancelled'=>'Cancelled'] as $val => $label)
                        <option value="{{ $val }}" {{ $booking->status === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
                            style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                        Update Status
                    </button>
                </form>
            </div>

            <a href="{{ route('admin.bookings.index') }}"
               class="block w-full text-center py-2.5 rounded-xl text-sm text-gray-500 dark:text-white/40
                      border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5
                      transition-colors duration-150">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- Order F&B terkait --}}
    @if($booking->fnbOrders->count())
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Order F&amp;B Terkait</h3>
        <div class="space-y-3">
            @foreach($booking->fnbOrders as $order)
            <div class="flex items-center justify-between py-2 border-b border-gray-50 dark:border-white/5 last:border-0">
                <div>
                    <span class="text-xs font-mono font-semibold text-purple-600 dark:text-purple-400">
                        {{ $order->order_code }}
                    </span>
                    <span class="text-xs text-gray-400 dark:text-white/30 ml-2">
                        {{ $order->items->count() }} item
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-gray-800 dark:text-white">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                 {{ match($order->status) {
                                    'done'       => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                                    'processing' => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                                    default      => 'bg-gray-100 dark:bg-white/8 text-gray-500 dark:text-white/40'
                                 } }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
