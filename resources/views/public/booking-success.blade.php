<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil — Grand Paijo's Nusantara Hotel</title>
    @vite(['resources/css/app.css'])
    <style>
        @keyframes checkmark {
            from { stroke-dashoffset: 100; opacity: 0; }
            to   { stroke-dashoffset: 0; opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.5); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }
        .check-anim { animation: checkmark 0.6s ease 0.3s forwards; stroke-dasharray: 100; stroke-dashoffset: 100; opacity: 0; }
        .scale-in   { animation: scaleIn 0.5s cubic-bezier(0.34,1.56,0.64,1) forwards; }
    </style>
</head>
<body class="bg-[#0D0B1F] text-white min-h-screen flex items-center justify-center px-6">

<div class="max-w-md w-full text-center">

    {{-- Animasi sukses --}}
    <div class="scale-in w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center"
         style="background: linear-gradient(135deg, rgba(124,58,237,0.3), rgba(79,70,229,0.3));
                border: 2px solid rgba(124,58,237,0.5);
                box-shadow: 0 0 40px rgba(124,58,237,0.3)">
        <svg class="w-10 h-10" viewBox="0 0 40 40" fill="none">
            <path class="check-anim" d="M10 20 L17 27 L30 13"
                  stroke="#A78BFA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <h1 class="text-2xl font-bold mb-2">Booking Berhasil! 🎉</h1>
    <p class="text-white/40 text-sm mb-8">
        Terima kasih, <span class="text-white font-medium">{{ $booking->guest_name }}</span>!<br>
        Booking kamu sedang menunggu konfirmasi dari kami.
    </p>

    {{-- Detail booking --}}
    <div class="bg-white/4 border border-white/8 rounded-2xl p-6 text-left mb-6">
        <div class="flex items-center justify-between mb-5 pb-4 border-b border-white/5">
            <span class="text-sm font-medium">Kode Booking</span>
            <span class="font-mono font-bold text-purple-400 text-lg">{{ $booking->booking_code }}</span>
        </div>
        <div class="space-y-3 text-sm">
            @foreach([
                ['Kamar',       $booking->room->room_number . ' · ' . $booking->room->roomType->name],
                ['Lantai',      'Lantai ' . $booking->room->floor],
                ['Check-in',    $booking->check_in->format('d M Y')],
                ['Check-out',   $booking->check_out->format('d M Y')],
                ['Durasi',      $booking->total_nights . ' malam'],
                ['Total Harga', 'Rp ' . number_format($booking->total_price, 0, ',', '.')],
                ['Status',      'Menunggu Konfirmasi'],
            ] as [$label, $value])
            <div class="flex justify-between">
                <span class="text-white/40">{{ $label }}</span>
                <span class="{{ $label === 'Status' ? 'text-amber-400 font-medium' : 'text-white font-medium' }}">
                    {{ $value }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl px-4 py-3 text-left mb-6">
        <p class="text-xs text-amber-400/80 leading-relaxed">
            📧 Konfirmasi akan dikirim ke <strong>{{ $booking->guest_email }}</strong>.
            Tim kami akan menghubungi kamu via WhatsApp di <strong>{{ $booking->guest_phone }}</strong>
            untuk konfirmasi lebih lanjut.
        </p>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('home') }}"
           class="flex-1 py-3 rounded-xl text-sm font-medium text-white/60 border border-white/10
                  hover:bg-white/5 hover:text-white transition-all">
            Kembali ke Home
        </a>
        <a href="{{ route('rooms') }}"
           class="flex-1 py-3 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
           style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
            Pesan Kamar Lain
        </a>
    </div>
</div>

</body>
</html>
