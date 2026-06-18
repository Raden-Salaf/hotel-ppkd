@extends('layouts.admin')
@section('title', 'Booking Walk-in')
@section('subtitle', 'Grand Paijo\'s Nusantara Hotel — Resepsionis')

@section('content')

{{-- Tampilkan error validasi --}}
@if($errors->any())
<div class="mb-5 px-4 py-3 rounded-xl bg-red-50 dark:bg-red-500/10
            border border-red-200 dark:border-red-500/20">
    <p class="text-sm font-semibold text-red-600 dark:text-red-400 mb-2">
        Ada kesalahan input:
    </p>
    <ul class="space-y-1">
        @foreach($errors->all() as $error)
        <li class="text-sm text-red-600 dark:text-red-400">• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- SATU FORM BESAR yang membungkus semuanya --}}
<form method="POST" action="{{ route('admin.bookings.store') }}" id="booking-form">
@csrf

<div class="grid grid-cols-3 gap-5">

    {{-- Kiri: Form --}}
    <div class="col-span-2 space-y-5">

        {{-- Step 1: Data Tamu --}}
        <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold"
                      style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">1</span>
                Data Tamu
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Nama Lengkap <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="guest_name" value="{{ old('guest_name') }}"
                           placeholder="Nama tamu walk-in"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border
                                  {{ $errors->has('guest_name') ? 'border-red-400' : 'border-gray-200 dark:border-white/10' }}
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  placeholder:text-gray-300 dark:placeholder:text-white/20
                                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                    @error('guest_name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        No. WhatsApp <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="guest_phone" value="{{ old('guest_phone') }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border
                                  {{ $errors->has('guest_phone') ? 'border-red-400' : 'border-gray-200 dark:border-white/10' }}
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  placeholder:text-gray-300 dark:placeholder:text-white/20
                                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                    @error('guest_phone')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="guest_email" value="{{ old('guest_email') }}"
                           placeholder="email@contoh.com"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border
                                  {{ $errors->has('guest_email') ? 'border-red-400' : 'border-gray-200 dark:border-white/10' }}
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  placeholder:text-gray-300 dark:placeholder:text-white/20
                                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                    @error('guest_email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Step 2: Kamar & Tanggal --}}
        <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold"
                      style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">2</span>
                Kamar &amp; Tanggal
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Pilih Kamar <span class="text-red-400">*</span>
                    </label>
                    <select name="room_id" id="room_select"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border
                                   {{ $errors->has('room_id') ? 'border-red-400' : 'border-gray-200 dark:border-white/10' }}
                                   bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                        <option value="">— Pilih kamar yang tersedia —</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}"
                                data-price="{{ $room->roomType->price_per_night }}"
                                data-number="{{ $room->room_number }}"
                                data-type="{{ $room->roomType->name }}"
                                {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            Kamar {{ $room->room_number }} — {{ $room->roomType->name }}
                            (Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}/malam)
                        </option>
                        @endforeach
                    </select>
                    @error('room_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                            Check-in <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="check_in" id="check_in"
                               value="{{ old('check_in', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border
                                      {{ $errors->has('check_in') ? 'border-red-400' : 'border-gray-200 dark:border-white/10' }}
                                      bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                        @error('check_in')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                            Check-out <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="check_out" id="check_out"
                               value="{{ old('check_out') }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border
                                      {{ $errors->has('check_out') ? 'border-red-400' : 'border-gray-200 dark:border-white/10' }}
                                      bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                        @error('check_out')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Catatan <span class="text-gray-300 dark:text-white/20 font-normal normal-case">(opsional)</span>
                    </label>
                    <textarea name="notes" rows="2" placeholder="Permintaan khusus tamu..."
                              class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                     bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                     placeholder:text-gray-300 dark:placeholder:text-white/20
                                     focus:outline-none focus:ring-2 focus:ring-purple-500/30
                                     transition duration-200 resize-none">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Step 3: F&B --}}
        <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-1 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold"
                      style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">3</span>
                F&amp;B Order
                <span class="text-xs font-normal text-gray-400 dark:text-white/30">(opsional)</span>
            </h3>
            <p class="text-xs text-gray-400 dark:text-white/30 mb-5 ml-8">
                Pesanan makanan/minuman akan otomatis masuk ke invoice
            </p>

            @foreach($fnbCategories as $catId => $cat)
            @if(isset($fnbMenus[$catId]) && $fnbMenus[$catId]->count())
            <div class="mb-5">
                <p class="text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-3">
                    {{ $cat->icon ?? '' }} {{ $cat->name }}
                </p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($fnbMenus[$catId] as $menu)
                    @php $idx = $loop->parent->index * 100 + $loop->index; @endphp
                    <div class="flex items-center justify-between p-3 rounded-xl border
                                border-gray-100 dark:border-white/8 bg-gray-50 dark:bg-white/2
                                hover:border-purple-200 dark:hover:border-purple-500/20 transition-colors">
                        <div class="flex-1 min-w-0 mr-3">
                            <p class="text-sm font-medium text-gray-800 dark:text-white truncate">
                                {{ $menu->name }}
                            </p>
                            <p class="text-xs text-purple-600 dark:text-purple-400 mt-0.5">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button type="button"
                                    onclick="changeQty({{ $menu->id }}, -1)"
                                    class="w-7 h-7 rounded-lg border border-gray-200 dark:border-white/10
                                           text-gray-500 dark:text-white/40 text-sm font-bold
                                           hover:bg-gray-100 dark:hover:bg-white/10 transition-colors
                                           flex items-center justify-center">
                                −
                            </button>
                            <span id="qty_display_{{ $menu->id }}"
                                  class="text-sm font-semibold text-gray-800 dark:text-white w-5 text-center">
                                0
                            </span>
                            <button type="button"
                                    onclick="changeQty({{ $menu->id }}, 1)"
                                    class="w-7 h-7 rounded-lg border border-purple-200 dark:border-purple-500/30
                                           text-purple-600 dark:text-purple-400 text-sm font-bold
                                           hover:bg-purple-50 dark:hover:bg-purple-500/10 transition-colors
                                           flex items-center justify-center">
                                +
                            </button>

                            {{-- Input hidden yang dikirim ke server --}}
                            <input type="hidden"
                                   name="fnb_items[{{ $idx }}][menu_id]"
                                   value="{{ $menu->id }}">
                            <input type="number"
                                   name="fnb_items[{{ $idx }}][qty]"
                                   id="fnb_qty_{{ $menu->id }}"
                                   value="0" min="0"
                                   data-price="{{ $menu->price }}"
                                   data-name="{{ $menu->name }}"
                                   class="hidden"
                                   onchange="updateSummary()">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    {{-- Kanan: Ringkasan --}}
    <div>
        <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5 sticky top-20">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Ringkasan Booking</h3>

            {{-- Info Kamar --}}
            <div class="mb-4 pb-4 border-b border-gray-50 dark:border-white/5">
                <p class="text-xs text-gray-400 dark:text-white/30 mb-2 uppercase tracking-wider">Kamar</p>
                <p id="summary_room" class="text-sm font-medium text-gray-800 dark:text-white">
                    Belum dipilih
                </p>
                <p id="summary_dates" class="text-xs text-gray-400 dark:text-white/30 mt-1"></p>
                <div class="flex justify-between mt-2">
                    <span id="summary_nights" class="text-xs text-gray-500 dark:text-white/40"></span>
                    <span id="summary_room_price" class="text-sm font-semibold text-gray-800 dark:text-white">—</span>
                </div>
            </div>

            {{-- F&B --}}
            <div class="mb-4 pb-4 border-b border-gray-50 dark:border-white/5">
                <p class="text-xs text-gray-400 dark:text-white/30 mb-2 uppercase tracking-wider">F&amp;B</p>
                <div id="summary_fnb_items">
                    <p class="text-xs text-gray-400 dark:text-white/30 italic">Belum ada</p>
                </div>
                <div class="flex justify-between mt-2">
                    <span class="text-xs text-gray-500 dark:text-white/40">Subtotal F&B</span>
                    <span id="summary_fnb_total" class="text-sm font-semibold text-gray-800 dark:text-white">Rp 0</span>
                </div>
            </div>

            {{-- Grand Total --}}
            <div class="flex justify-between items-center mb-5">
                <span class="text-sm font-bold text-gray-800 dark:text-white">Grand Total</span>
                <span id="summary_grand_total" class="text-xl font-bold text-purple-600 dark:text-purple-400">
                    Rp 0
                </span>
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-xl text-sm font-semibold text-white
                           transition-all hover:opacity-90 active:scale-95"
                    style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                Buat Booking &amp; Invoice
            </button>

            <a href="{{ route('admin.bookings.index') }}"
               class="block w-full text-center mt-3 py-2.5 rounded-xl text-sm
                      text-gray-500 dark:text-white/40
                      border border-gray-200 dark:border-white/10
                      hover:bg-gray-50 dark:hover:bg-white/5 transition-colors duration-150">
                Batal
            </a>
        </div>
    </div>

</div>
</form>

@endsection

@push('scripts')
<script>
// ── State ──────────────────────────────────────
let roomPricePerNight = 0;
let totalNights       = 0;
let fnbTotal          = 0;

// ── Format Rupiah ──────────────────────────────
function fmt(num) {
    return 'Rp ' + Math.round(num).toLocaleString('id-ID');
}

// ── Update ringkasan kamar ─────────────────────
function updateRoomSummary() {
    const sel    = document.getElementById('room_select');
    const opt    = sel.options[sel.selectedIndex];
    const checkIn  = document.getElementById('check_in').value;
    const checkOut = document.getElementById('check_out').value;

    roomPricePerNight = parseFloat(opt.dataset.price || 0);
    const roomNumber  = opt.dataset.number || '';
    const roomType    = opt.dataset.type   || '';

    if (roomPricePerNight && checkIn && checkOut) {
        const d1 = new Date(checkIn);
        const d2 = new Date(checkOut);

        if (d2 > d1) {
            totalNights = Math.round((d2 - d1) / (1000 * 60 * 60 * 24));

            document.getElementById('summary_room').textContent =
                `Kamar ${roomNumber} — ${roomType}`;
            document.getElementById('summary_dates').textContent =
                `${checkIn} s/d ${checkOut}`;
            document.getElementById('summary_nights').textContent =
                `${totalNights} malam × ${fmt(roomPricePerNight)}`;
            document.getElementById('summary_room_price').textContent =
                fmt(roomPricePerNight * totalNights);
        } else {
            totalNights = 0;
            document.getElementById('summary_nights').textContent = '';
            document.getElementById('summary_room_price').textContent = '—';
        }
    } else if (roomNumber) {
        document.getElementById('summary_room').textContent =
            `Kamar ${roomNumber} — ${roomType}`;
    } else {
        document.getElementById('summary_room').textContent = 'Belum dipilih';
        document.getElementById('summary_dates').textContent = '';
        document.getElementById('summary_nights').textContent = '';
        document.getElementById('summary_room_price').textContent = '—';
        totalNights = 0;
    }

    updateGrandTotal();
}

// ── Update qty F&B ─────────────────────────────
function changeQty(menuId, delta) {
    const input = document.getElementById('fnb_qty_' + menuId);
    let val = parseInt(input.value || 0) + delta;
    if (val < 0) val = 0;
    input.value = val;
    document.getElementById('qty_display_' + menuId).textContent = val;
    updateSummary();
}

// ── Update ringkasan F&B ───────────────────────
function updateSummary() {
    fnbTotal = 0;
    const lines  = [];
    const inputs = document.querySelectorAll('input[id^="fnb_qty_"]');

    inputs.forEach(input => {
        const qty   = parseInt(input.value || 0);
        const price = parseFloat(input.dataset.price || 0);
        const name  = input.dataset.name || 'Menu';

        if (qty > 0) {
            fnbTotal += qty * price;
            lines.push(`
                <div class="flex justify-between text-xs py-0.5">
                    <span class="text-gray-600 dark:text-white/50">${name} ×${qty}</span>
                    <span class="font-medium text-gray-800 dark:text-white">${fmt(qty * price)}</span>
                </div>
            `);
        }
    });

    const container = document.getElementById('summary_fnb_items');
    container.innerHTML = lines.length
        ? lines.join('')
        : '<p class="text-xs text-gray-400 dark:text-white/30 italic">Belum ada</p>';

    document.getElementById('summary_fnb_total').textContent = fmt(fnbTotal);
    updateGrandTotal();
}

// ── Update grand total ─────────────────────────
function updateGrandTotal() {
    const roomTotal = roomPricePerNight * totalNights;
    document.getElementById('summary_grand_total').textContent = fmt(roomTotal + fnbTotal);
}

// ── Event listeners ────────────────────────────
document.getElementById('room_select').addEventListener('change', updateRoomSummary);
document.getElementById('check_in').addEventListener('change', updateRoomSummary);
document.getElementById('check_out').addEventListener('change', updateRoomSummary);
</script>
@endpush