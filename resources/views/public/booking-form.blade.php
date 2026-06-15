<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kamar {{ $room->room_number }} — Grand Paijo's Nusantara Hotel</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#0D0B1F] text-white min-h-screen">

    <nav class="fixed top-0 inset-x-0 z-50 backdrop-blur-md border-b border-white/5"
        style="background: rgba(13,11,31,0.8)">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10 border border-white/20">
                    <img src="{{ asset('images/logo.png') }}" onerror="this.style.display='none'"
                        class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-sm font-semibold">Grand Paijo's Nusantara Hotel</span>
            </a>
            <a href="{{ route('rooms') }}" class="text-sm text-white/50 hover:text-white transition-colors">
                ← Pilih Kamar Lain
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-6 pt-28 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Info Kamar --}}
            <div>
                <p class="text-purple-400 text-xs font-medium tracking-widest uppercase mb-3">Detail Kamar</p>
                <div class="bg-white/4 border border-white/8 rounded-2xl overflow-hidden mb-4">
                    <div class="h-48 flex items-center justify-center"
                        style="background: linear-gradient(135deg, rgba(124,58,237,0.2), rgba(79,70,229,0.2))">
                        <span class="text-6xl opacity-30">🛏️</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h2 class="text-xl font-bold">Kamar {{ $room->room_number }}</h2>
                                <p class="text-white/40 text-sm mt-0.5">
                                    {{ $room->roomType->name }} · Lantai {{ $room->floor }}
                                </p>
                            </div>
                            <span
                                class="text-xs px-2.5 py-1 rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/20">
                                Tersedia
                            </span>
                        </div>
                        <p class="text-white/50 text-sm leading-relaxed mb-4">
                            {{ $room->roomType->description }}
                        </p>
                        @if($room->roomType->facilities)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($room->roomType->facilities as $f)
                                    <span class="text-xs px-2.5 py-1 rounded-lg bg-white/5 text-white/50 border border-white/8">
                                        {{ $f }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        <div class="pt-4 border-t border-white/5">
                            <span class="text-2xl font-bold text-purple-400">
                                Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}
                            </span>
                            <span class="text-white/30 text-sm">/malam</span>
                        </div>
                    </div>
                </div>

                {{-- Estimasi harga (JS) --}}
                <div id="price-estimate" class="hidden bg-purple-500/10 border border-purple-500/20 rounded-2xl p-4">
                    <p class="text-xs text-purple-300 font-medium mb-2">Estimasi Total</p>
                    <div class="flex justify-between text-sm text-white/60 mb-1">
                        <span id="nights-text">0 malam</span>
                        <span id="price-per-night">Rp
                            {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}/malam</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-white mt-2 pt-2 border-t border-white/10">
                        <span>Total</span>
                        <span id="total-price" class="text-purple-400">Rp 0</span>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div>
                <p class="text-purple-400 text-xs font-medium tracking-widest uppercase mb-3">Data Pemesan</p>
                <div class="bg-white/4 border border-white/8 rounded-2xl p-6">

                    @if($errors->any())
                        <div class="mb-5 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('booking.store', $room) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}"
                                placeholder="Masukkan nama lengkap" class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                      text-white placeholder:text-white/20
                                      focus:outline-none focus:ring-2 focus:ring-purple-500/40 focus:border-purple-500/50
                                      transition duration-200">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                Email
                            </label>
                            <input type="email" name="guest_email" value="{{ old('guest_email') }}"
                                placeholder="email@contoh.com" class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                      text-white placeholder:text-white/20
                                      focus:outline-none focus:ring-2 focus:ring-purple-500/40 focus:border-purple-500/50
                                      transition duration-200">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                No. WhatsApp
                            </label>
                            <input type="text" name="guest_phone" value="{{ old('guest_phone') }}"
                                placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                      text-white placeholder:text-white/20
                                      focus:outline-none focus:ring-2 focus:ring-purple-500/40 focus:border-purple-500/50
                                      transition duration-200">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                    Check-in
                                </label>
                                <input type="date" name="check_in" id="check_in" value="{{ old('check_in') }}"
                                    min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                          text-white focus:outline-none focus:ring-2 focus:ring-purple-500/40
                                          transition duration-200">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                    Check-out
                                </label>
                                <input type="date" name="check_out" id="check_out" value="{{ old('check_out') }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                          text-white focus:outline-none focus:ring-2 focus:ring-purple-500/40
                                          transition duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                Catatan <span class="normal-case font-normal opacity-60">(opsional)</span>
                            </label>
                            <textarea name="notes" rows="2" placeholder="Permintaan khusus, jam kedatangan, dll..."
                                class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                         text-white placeholder:text-white/20 resize-none
                                         focus:outline-none focus:ring-2 focus:ring-purple-500/40
                                         transition duration-200">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-xl text-sm font-semibold text-white
                                   transition-all hover:opacity-90 active:scale-95 mt-2" style="background: linear-gradient(135deg, #7C3AED, #4F46E5);
                                   box-shadow: 0 0 20px rgba(124,58,237,0.3)">
                            Konfirmasi Pemesanan
                        </button>

                        <p class="text-center text-xs text-white/25">
                            Booking akan berstatus <span class="text-amber-400">Pending</span> sampai dikonfirmasi admin
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pricePerNight = {{ $room->roomType->price_per_night }};

        function updateEstimate() {
            const checkIn = new Date(document.getElementById('check_in').value);
            const checkOut = new Date(document.getElementById('check_out').value);

            if (checkIn && checkOut && checkOut > checkIn) {
                const nights = Math.round((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                const total = nights * pricePerNight;

                document.getElementById('nights-text').textContent = nights + ' malam';
                document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('price-estimate').classList.remove('hidden');
            } else {
                document.getElementById('price-estimate').classList.add('hidden');
            }
        }

        document.getElementById('check_in').addEventListener('change', updateEstimate);
        document.getElementById('check_out').addEventListener('change', updateEstimate);
    </script>

</body>

</html>