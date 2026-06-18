<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $booking->booking_code }} — Grand Paijo's Nusantara Hotel</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .invoice-card {
                box-shadow: none !important;
                border: none !important;
            }
        }

        @page {
            size: A4;
            margin: 1.5cm;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen py-8 px-4">

    {{-- Tombol Aksi (tidak ikut print) --}}
    <div class="no-print max-w-3xl mx-auto mb-4 flex items-center gap-3">
        <a href="{{ route('admin.bookings.show', $booking) }}"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-gray-600
              border border-gray-200 bg-white hover:bg-gray-50 transition-colors">
            ← Kembali
        </a>
        <button onclick="window.print()"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
            style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Invoice
        </button>
        <button onclick="downloadPdf()"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
            style="background: linear-gradient(135deg, #059669, #047857)">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Download PDF
        </button>
    </div>

    {{-- Invoice Card --}}
    <div class="invoice-card max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- Header --}}
        <div class="px-10 py-8 text-white"
            style="background: linear-gradient(135deg, #2D0B6B 0%, #4C1D95 50%, #6D28D9 100%)">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='block'"
                            class="w-full h-full object-cover" alt="Logo">
                        <span class="hidden text-white text-2xl">✦</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Grand Paijo's Nusantara Hotel</h1>
                        <p class="text-purple-200 text-xs mt-0.5">Hotel Management System</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-purple-200 text-xs uppercase tracking-widest mb-1">Invoice</p>
                    <p class="text-2xl font-bold font-mono">{{ $booking->booking_code }}</p>
                    <p class="text-purple-200 text-xs mt-1">
                        {{ $booking->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="px-10 py-8">

            {{-- Info Tamu & Status --}}
            <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Tagihan Kepada</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $booking->guest_name }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ $booking->guest_email }}</p>
                    <p class="text-gray-500 text-sm">{{ $booking->guest_phone }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Detail Pembayaran</p>
                    <div class="inline-block">
                        @php
                            $payBadge =
                                $booking->payment_status === 'paid'
                                    ? 'bg-green-100 text-green-700 border-green-200'
                                    : 'bg-red-100 text-red-700 border-red-200';
                        @endphp
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold border {{ $payBadge }}">
                            {{ $booking->payment_status === 'paid' ? '✓ LUNAS' : 'BELUM LUNAS' }}
                        </span>
                    </div>
                    @if ($booking->paid_at)
                        <p class="text-gray-400 text-xs mt-2">
                            Dibayar: {{ $booking->paid_at->format('d M Y, H:i') }}
                        </p>
                    @endif
                    <p class="text-gray-400 text-xs mt-1">
                        Diproses oleh: {{ $booking->handler?->name ?? 'Sistem' }}
                    </p>
                </div>
            </div>

            {{-- Detail Kamar --}}
            <div class="mb-6">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Detail Kamar</p>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Deskripsi</th>
                            <th class="text-right py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Qty</th>
                            <th class="text-right py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Harga</th>
                            <th class="text-right py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-50">
                            <td class="py-3">
                                <p class="font-medium text-gray-800">
                                    Kamar {{ $booking->room->room_number }} — {{ $booking->room->roomType->name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $booking->check_in->format('d M Y') }} s/d
                                    {{ $booking->check_out->format('d M Y') }}
                                </p>
                            </td>
                            <td class="py-3 text-right text-sm text-gray-600">
                                {{ $booking->total_nights }} malam
                            </td>
                            <td class="py-3 text-right text-sm text-gray-600">
                                Rp {{ number_format($booking->room->roomType->price_per_night, 0, ',', '.') }}
                            </td>
                            <td class="py-3 text-right text-sm font-semibold text-gray-800">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Detail F&B --}}
            @if ($booking->fnbOrders->where('status', '!=', 'cancelled')->count())
                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Order F&amp;B</p>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th
                                    class="text-left py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    Menu</th>
                                <th
                                    class="text-right py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    Qty</th>
                                <th
                                    class="text-right py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    Harga</th>
                                <th
                                    class="text-right py-2.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking->fnbOrders->where('status', '!=', 'cancelled') as $order)
                                @foreach ($order->items as $item)
                                    <tr class="border-b border-gray-50">
                                        <td class="py-2.5">
                                            <p class="text-sm text-gray-800">{{ $item->menu->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $order->order_code }}</p>
                                        </td>
                                        <td class="py-2.5 text-right text-sm text-gray-600">{{ $item->quantity }}</td>
                                        <td class="py-2.5 text-right text-sm text-gray-600">
                                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-2.5 text-right text-sm font-semibold text-gray-800">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Total --}}
            <div class="bg-gray-50 rounded-xl p-5">
                <div class="space-y-2 mb-3">
                    {{-- Subtotal Kamar --}}
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal Kamar ({{ $booking->total_nights }} malam)</span>
                        <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>

                    {{-- Subtotal F&B --}}
                    @php
                        $fnbTotal = $booking->fnbOrders->where('status', '!=', 'cancelled')->sum('total_price');
                    @endphp

                    @if ($fnbTotal > 0)
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal F&amp;B</span>
                            <span>Rp {{ number_format($fnbTotal, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                {{-- Grand Total --}}
                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                    <span class="text-base font-bold text-gray-900">GRAND TOTAL</span>
                    <span class="text-2xl font-bold" style="color: #6D28D9">
                        Rp {{ number_format((float) $booking->total_price + (float) $fnbTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Footer Invoice --}}
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400">
                    Terima kasih telah menginap di <strong>Grand Paijo's Nusantara Hotel</strong>
                </p>
                <p class="text-xs text-gray-300 mt-1">
                    Invoice ini digenerate otomatis pada {{ now()->format('d M Y, H:i') }} WIB
                </p>
            </div>
        </div>
    </div>

    <script>
        async function downloadPdf() {
            // Sembunyikan tombol, print sebagai PDF
            const noprint = document.querySelectorAll('.no-print');
            noprint.forEach(el => el.style.display = 'none');

            // Trigger print dialog (user pilih "Save as PDF")
            window.print();

            // Tampilkan lagi setelah print
            setTimeout(() => {
                noprint.forEach(el => el.style.display = '');
            }, 1000);
        }
    </script>

</body>

</html>
