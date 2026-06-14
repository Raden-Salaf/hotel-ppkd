@extends('layouts.admin')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan operasional hotel hari ini')

@section('content')

{{-- Metric Cards --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    @php
    $metrics = [
        ['label' => 'Total Kamar',      'value' => $stats['total_rooms'],     'color' => 'purple', 'sub' => '3 tipe kamar'],
        ['label' => 'Kamar Tersedia',   'value' => $stats['available_rooms'], 'color' => 'green',  'sub' => 'siap dipesan'],
        ['label' => 'Booking Aktif',    'value' => $stats['active_bookings'], 'color' => 'blue',   'sub' => 'hari ini'],
        ['label' => 'Revenue Hari Ini', 'value' => 'Rp '.number_format($stats['revenue_today'],0,',','.'), 'color' => 'amber', 'sub' => 'total pendapatan'],
    ];
    $colors = [
        'purple' => ['bg' => 'bg-purple-50 dark:bg-purple-500/10', 'text' => 'text-purple-700 dark:text-purple-300', 'border' => 'border-purple-100 dark:border-purple-500/20', 'dot' => 'bg-purple-500'],
        'green'  => ['bg' => 'bg-green-50 dark:bg-green-500/10',   'text' => 'text-green-700 dark:text-green-300',   'border' => 'border-green-100 dark:border-green-500/20',   'dot' => 'bg-green-500'],
        'blue'   => ['bg' => 'bg-blue-50 dark:bg-blue-500/10',     'text' => 'text-blue-700 dark:text-blue-300',     'border' => 'border-blue-100 dark:border-blue-500/20',     'dot' => 'bg-blue-500'],
        'amber'  => ['bg' => 'bg-amber-50 dark:bg-amber-500/10',   'text' => 'text-amber-700 dark:text-amber-300',   'border' => 'border-amber-100 dark:border-amber-500/20',   'dot' => 'bg-amber-500'],
    ];
    @endphp

    @foreach($metrics as $m)
    @php $c = $colors[$m['color']]; @endphp
    <div class="bg-white dark:bg-white/4 border {{ $c['border'] }} rounded-2xl p-5 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-start justify-between mb-3">
            <p class="text-xs font-medium text-gray-500 dark:text-white/40">{{ $m['label'] }}</p>
            <div class="w-2 h-2 rounded-full {{ $c['dot'] }}"></div>
        </div>
        <p class="text-2xl font-bold {{ $c['text'] }} mb-1">{{ $m['value'] }}</p>
        <p class="text-xs text-gray-400 dark:text-white/25">{{ $m['sub'] }}</p>
    </div>
    @endforeach
</div>

{{-- Tables --}}
<div class="grid grid-cols-2 gap-5 mb-5">

    {{-- Booking Terbaru --}}
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50 dark:border-white/5">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Booking Terbaru</h3>
            <a href="{{ route('admin.bookings.index') }}"
               class="text-xs text-purple-600 dark:text-purple-400 hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-white/5">
            @forelse($recent_bookings as $booking)
            <div class="flex items-center justify-between px-5 py-3">
                <div>
                    <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $booking->guest_name }}</p>
                    <p class="text-xs text-gray-400 dark:text-white/30 mt-0.5">
                        {{ $booking->room->room_number }} · {{ $booking->check_in->format('d M') }}
                    </p>
                </div>
                @php
                $statusMap = [
                    'confirmed'   => 'bg-purple-50 dark:bg-purple-500/15 text-purple-700 dark:text-purple-300',
                    'pending'     => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                    'checked_in'  => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                    'checked_out' => 'bg-gray-100 dark:bg-white/8 text-gray-600 dark:text-white/50',
                    'cancelled'   => 'bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-300',
                ];
                @endphp
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $statusMap[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>
            @empty
            <p class="px-5 py-6 text-center text-sm text-gray-400 dark:text-white/25">Belum ada booking</p>
            @endforelse
        </div>
    </div>

    {{-- Order F&B Terbaru --}}
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50 dark:border-white/5">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Order F&amp;B Terbaru</h3>
            <a href="{{ route('admin.fnb-orders.index') }}"
               class="text-xs text-purple-600 dark:text-purple-400 hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-white/5">
            @forelse($recent_fnb_orders as $order)
            <div class="flex items-center justify-between px-5 py-3">
                <div>
                    <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $order->order_code }}</p>
                    <p class="text-xs text-gray-400 dark:text-white/30 mt-0.5">
                        Kamar {{ $order->room_number ?? '-' }} · Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </p>
                </div>
                @php
                $fnbMap = [
                    'done'       => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                    'processing' => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                    'queue'      => 'bg-gray-100 dark:bg-white/8 text-gray-600 dark:text-white/50',
                    'cancelled'  => 'bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-300',
                ];
                @endphp
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $fnbMap[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            @empty
            <p class="px-5 py-6 text-center text-sm text-gray-400 dark:text-white/25">Belum ada order</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Room Status Grid --}}
<div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Status Kamar Hari Ini</h3>
        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-white/40">
            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Tersedia</span>
            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-400"></span>Terisi</span>
            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-400"></span>Maintenance</span>
        </div>
    </div>
    @php
    use App\Models\Room;
    $rooms = Room::with('roomType')->orderBy('room_number')->get();
    @endphp
    <div class="grid grid-cols-8 gap-2">
        @foreach($rooms as $room)
        @php
        $roomStyle = match($room->status) {
            'available'   => 'bg-purple-50 dark:bg-purple-500/10 border-purple-200 dark:border-purple-500/30 text-purple-700 dark:text-purple-300',
            'occupied'    => 'bg-red-50 dark:bg-red-500/10 border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-300',
            'maintenance' => 'bg-amber-50 dark:bg-amber-500/10 border-amber-200 dark:border-amber-500/30 text-amber-700 dark:text-amber-300',
            default       => 'bg-gray-50 border-gray-200 text-gray-500',
        };
        @endphp
        <div class="border rounded-xl p-2.5 text-center cursor-pointer hover:scale-105 transition-transform duration-150 {{ $roomStyle }}">
            <div class="text-sm font-semibold">{{ $room->room_number }}</div>
            <div class="text-[10px] mt-0.5 opacity-70">{{ Str::limit($room->roomType->name, 3, '') }}</div>
        </div>
        @endforeach
    </div>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

</div>

@endsection