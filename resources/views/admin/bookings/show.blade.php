@extends('layouts.admin')
@section('title', 'Booking ' . $booking->booking_code)
@section('subtitle', 'Grand Paijo\'s Nusantara Hotel')

@section('topbar-actions')
    <a href="{{ route('admin.bookings.invoice', $booking) }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90"
        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Lihat Invoice
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-3 gap-5">

        {{-- Kiri: Detail + F&B --}}
        <div class="col-span-2 space-y-5">

            {{-- Info Booking --}}
            <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white font-mono">
                            {{ $booking->booking_code }}
                        </h2>
                        <p class="text-xs text-gray-400 dark:text-white/30 mt-0.5">
                            Dibuat {{ $booking->created_at->format('d M Y, H:i') }}
                            @if ($booking->handler)
                                oleh {{ $booking->handler->name }}
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $statusStyle = match ($booking->status) {
                                'confirmed'
                                    => 'bg-purple-50 dark:bg-purple-500/15 text-purple-700 dark:text-purple-300',
                                'pending' => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                                'checked_in' => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                                'checked_out' => 'bg-gray-100 dark:bg-white/8 text-gray-600 dark:text-white/40',
                                'cancelled' => 'bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-400',
                                default => 'bg-gray-100 text-gray-500',
                            };
                            $payStyle =
                                $booking->payment_status === 'paid'
                                    ? 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300'
                                    : 'bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-400';
                        @endphp
                        <span class="text-xs px-3 py-1.5 rounded-full font-semibold {{ $statusStyle }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                        <span class="text-xs px-3 py-1.5 rounded-full font-semibold {{ $payStyle }}">
                            {{ $booking->payment_status === 'paid' ? '✓ Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    @foreach ([['Nama Tamu', $booking->guest_name], ['Kamar', $booking->room->room_number . ' — ' . $booking->room->roomType->name], ['Email', $booking->guest_email], ['WhatsApp', $booking->guest_phone], ['Check-in', $booking->check_in->format('d M Y')], ['Check-out', $booking->check_out->format('d M Y')], ['Durasi', $booking->total_nights . ' malam'], ['Harga Kamar', 'Rp ' . number_format($booking->total_price, 0, ',', '.')]] as [$label, $value])
                        <div>
                            <p class="text-xs text-gray-400 dark:text-white/30 mb-0.5">{{ $label }}</p>
                            <p class="font-medium text-gray-800 dark:text-white">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

                @if ($booking->notes)
                    <div class="mt-4 pt-4 border-t border-gray-50 dark:border-white/5">
                        <p class="text-xs text-gray-400 dark:text-white/30 mb-1">Catatan</p>
                        <p class="text-sm text-gray-600 dark:text-white/60">{{ $booking->notes }}</p>
                    </div>
                @endif

                {{-- Grand Total di halaman show --}}
                @php
                    $fnbSubtotal = $booking->fnbOrders->where('status', '!=', 'cancelled')->sum('total_price');
                    $grandTotal = (float) $booking->total_price + (float) $fnbSubtotal;
                @endphp

                <div class="mt-4 pt-4 border-t border-gray-50 dark:border-white/5 flex justify-between items-center">
                    <div>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">Grand Total</span>
                        <p class="text-xs text-gray-400 dark:text-white/30 mt-0.5">
                            Kamar: Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            @if ($fnbSubtotal > 0)
                                + F&B: Rp {{ number_format($fnbSubtotal, 0, ',', '.') }}
                            @endif
                        </p>
                    </div>
                    <span class="text-xl font-bold text-purple-600 dark:text-purple-400">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- F&B Orders --}}
            <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Order F&amp;B</h3>
                    <button onclick="document.getElementById('modal-fnb').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-white hover:opacity-90 transition-opacity"
                        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                        + Tambah Order
                    </button>
                </div>

                @forelse($booking->fnbOrders as $order)
                    <div
                        class="mb-4 p-4 rounded-xl border border-gray-100 dark:border-white/8 bg-gray-50/50 dark:bg-white/2">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-mono font-semibold text-purple-600 dark:text-purple-400">
                                {{ $order->order_code }}
                            </span>
                            @php
                                $fnbStatus = match ($order->status) {
                                    'done' => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                                    'processing'
                                        => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300',
                                    'queue' => 'bg-gray-100 dark:bg-white/8 text-gray-500 dark:text-white/40',
                                    'cancelled' => 'bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-400',
                                    default => 'bg-gray-100 text-gray-500',
                                };
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $fnbStatus }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                @if ($order->status !== 'done' && $order->status !== 'cancelled')
                                    <form method="POST" action="{{ route('admin.fnb-orders.updateStatus', $order) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status"
                                            value="{{ $order->status === 'queue' ? 'processing' : 'done' }}">
                                        <button type="submit"
                                            class="text-xs px-2.5 py-1 rounded-lg text-white hover:opacity-90"
                                            style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                                            {{ $order->status === 'queue' ? 'Proses' : 'Selesai' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-white/60">
                                        {{ $item->menu->name }} ×{{ $item->quantity }}
                                    </span>
                                    <span class="font-medium text-gray-800 dark:text-white">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                            <div class="flex justify-between text-sm pt-2 border-t border-gray-100 dark:border-white/5">
                                <span class="font-semibold text-gray-700 dark:text-white/70">Subtotal</span>
                                <span class="font-bold text-purple-600 dark:text-purple-400">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-white/25 text-center py-6">
                        Belum ada order F&B
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Kanan: Status & Aksi --}}
        <div class="space-y-4">
            <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <select name="status"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                               bg-white dark:bg-white/5 text-gray-800 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-purple-500/30">
                        @foreach ([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'checked_in' => 'Checked In',
            'checked_out' => 'Checked Out',
            'cancelled' => 'Cancelled',
        ] as $val => $label)
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

            <a href="{{ route('admin.bookings.invoice', $booking) }}" target="_blank"
                class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-medium
                  border border-purple-200 dark:border-purple-500/30 text-purple-600 dark:text-purple-400
                  hover:bg-purple-50 dark:hover:bg-purple-500/10 transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Download Invoice
            </a>

            <a href="{{ route('admin.bookings.index') }}"
                class="flex items-center justify-center w-full py-2.5 rounded-xl text-sm text-gray-500 dark:text-white/40
                  border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5
                  transition-colors duration-150">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- Modal Tambah F&B --}}
    <div id="modal-fnb" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            onclick="document.getElementById('modal-fnb').classList.add('hidden')"></div>
        <div
            class="relative bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10
                rounded-2xl p-6 w-full max-w-lg shadow-2xl max-h-[80vh] overflow-y-auto">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5">
                Tambah Order F&amp;B — Kamar {{ $booking->room->room_number }}
            </h3>
            <form method="POST" action="{{ route('admin.bookings.addFnb', $booking) }}" id="fnb-modal-form">
                @csrf
                @foreach ($fnbCategories as $catId => $cat)
                    @if (isset($fnbMenus[$catId]) && $fnbMenus[$catId]->count())
                        <p class="text-xs font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider mb-3">
                            {{ $cat->name }}
                        </p>
                        <div class="space-y-2 mb-5">
                            @foreach ($fnbMenus[$catId] as $menu)
                                <div
                                    class="flex items-center justify-between p-3 rounded-xl border border-gray-100 dark:border-white/8
                            bg-gray-50 dark:bg-white/2">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $menu->name }}
                                        </p>
                                        <p class="text-xs text-purple-600 dark:text-purple-400">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                            onclick="changeModalQty('modal_menu_{{ $menu->id }}', -1)"
                                            class="w-7 h-7 rounded-lg border border-gray-200 dark:border-white/10
                                       text-gray-500 flex items-center justify-center text-sm font-bold
                                       hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">−</button>
                                        <span id="modal_qty_display_{{ $menu->id }}"
                                            class="text-sm font-semibold text-gray-800 dark:text-white w-5 text-center">0</span>
                                        <button type="button"
                                            onclick="changeModalQty('modal_menu_{{ $menu->id }}', 1)"
                                            class="w-7 h-7 rounded-lg border border-purple-200 dark:border-purple-500/30
                                       text-purple-600 flex items-center justify-center text-sm font-bold
                                       hover:bg-purple-50 dark:hover:bg-purple-500/10 transition-colors">+</button>
                                        <input type="hidden"
                                            name="fnb_items[{{ $loop->parent->index * 100 + $loop->index }}][menu_id]"
                                            value="{{ $menu->id }}">
                                        <input type="number" min="0"
                                            name="fnb_items[{{ $loop->parent->index * 100 + $loop->index }}][qty]"
                                            id="modal_menu_{{ $menu->id }}" value="0" class="hidden">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach

                <div class="flex gap-3 pt-2 border-t border-gray-100 dark:border-white/8">
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90"
                        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                        Tambah ke Invoice
                    </button>
                    <button type="button" onclick="document.getElementById('modal-fnb').classList.add('hidden')"
                        class="flex-1 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                               border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function changeModalQty(inputId, delta) {
            const input = document.getElementById(inputId);
            const menuId = inputId.replace('modal_menu_', '');
            let val = parseInt(input.value || 0) + delta;
            if (val < 0) val = 0;
            input.value = val;
            document.getElementById('modal_qty_display_' + menuId).textContent = val;
        }
    </script>
@endpush
