@extends('layouts.admin')
@section('title', 'Tambah Booking Manual')
@section('subtitle', 'Grand Paijo\'s Nusantara Hotel')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">

        @if($errors->any())
        <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
            <ul class="space-y-1 text-sm text-red-600 dark:text-red-400">
                @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.bookings.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                    Pilih Kamar
                </label>
                <select name="room_id" id="room_select"
                        class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                               bg-white dark:bg-white/5 text-gray-800 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                    <option value="">Pilih kamar yang tersedia</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}"
                            data-price="{{ $room->roomType->price_per_night }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        Kamar {{ $room->room_number }} — {{ $room->roomType->name }}
                        (Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}/malam)
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Nama Tamu
                    </label>
                    <input type="text" name="guest_name" value="{{ old('guest_name') }}"
                           placeholder="Nama lengkap tamu"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  placeholder:text-gray-300 dark:placeholder:text-white/20
                                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        No. WhatsApp
                    </label>
                    <input type="text" name="guest_phone" value="{{ old('guest_phone') }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  placeholder:text-gray-300 dark:placeholder:text-white/20
                                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                    Email Tamu
                </label>
                <input type="email" name="guest_email" value="{{ old('guest_email') }}"
                       placeholder="email@contoh.com"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              placeholder:text-gray-300 dark:placeholder:text-white/20
                              focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Check-in
                    </label>
                    <input type="date" name="check_in" id="admin_check_in"
                           value="{{ old('check_in') }}" min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Check-out
                    </label>
                    <input type="date" name="check_out" id="admin_check_out"
                           value="{{ old('check_out') }}"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 transition duration-200">
                </div>
            </div>

            {{-- Estimasi harga --}}
            <div id="admin-estimate" class="hidden px-4 py-3 rounded-xl bg-purple-50 dark:bg-purple-500/10 border border-purple-200 dark:border-purple-500/20">
                <div class="flex justify-between text-sm text-gray-600 dark:text-white/50 mb-1">
                    <span id="admin-nights">0 malam</span>
                    <span id="admin-pricepn">—</span>
                </div>
                <div class="flex justify-between font-bold text-purple-700 dark:text-purple-400">
                    <span>Total Estimasi</span>
                    <span id="admin-total">Rp 0</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                    Catatan <span class="normal-case font-normal text-gray-400">(opsional)</span>
                </label>
                <textarea name="notes" rows="2" placeholder="Catatan khusus..."
                          class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                 bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                 placeholder:text-gray-300 dark:placeholder:text-white/20
                                 focus:outline-none focus:ring-2 focus:ring-purple-500/30
                                 transition duration-200 resize-none">{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 active:scale-95"
                        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                    Simpan Booking
                </button>
                <a href="{{ route('admin.bookings.index') }}"
                   class="px-6 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                          border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5
                          transition-colors duration-150">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function updateAdminEstimate() {
    const roomSelect = document.getElementById('room_select');
    const selectedOption = roomSelect.options[roomSelect.selectedIndex];
    const price = parseFloat(selectedOption.dataset.price || 0);

    const checkIn  = new Date(document.getElementById('admin_check_in').value);
    const checkOut = new Date(document.getElementById('admin_check_out').value);

    if (price && checkIn && checkOut && checkOut > checkIn) {
        const nights = Math.round((checkOut - checkIn) / (1000 * 60 * 60 * 24));
        const total  = nights * price;
        document.getElementById('admin-nights').textContent  = nights + ' malam';
        document.getElementById('admin-pricepn').textContent = 'Rp ' + price.toLocaleString('id-ID') + '/malam';
        document.getElementById('admin-total').textContent   = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('admin-estimate').classList.remove('hidden');
    } else {
        document.getElementById('admin-estimate').classList.add('hidden');
    }
}

document.getElementById('room_select').addEventListener('change', updateAdminEstimate);
document.getElementById('admin_check_in').addEventListener('change', updateAdminEstimate);
document.getElementById('admin_check_out').addEventListener('change', updateAdminEstimate);
</script>
@endpush
